import React from 'react';
import ReactDOM from "react-dom/client";
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import axios from 'axios';
import Swal from 'sweetalert2';
import DataTable from 'datatables.net-react';
//import DT from 'datatables.net-dt';
import DT from 'datatables.net-bs5';
import 'datatables.net-select-dt';
import 'datatables.net-responsive-dt';

//import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/css/bootstrap-grid.min.css';

import ClipboardJS from 'clipboard';

import AddProjectDialog from './AddProjectComponent';
//import UpdatePromptDialog from './UpdatePromptComponent';
//import ExecutePromptDialog from './ExecutePromptComponent';
import {store} from '../reducer';

class ListProjectsDialog extends React.Component {

   constructor(props) {
      super(props);

      this.modalClose = this.modalClose.bind(this);

      this.state = {
         variant: null,
         show: false,
         id: null,

         tableData: window.projects,

         columns: [
            //{ data: 'id', className: 'text-center' },
            { data: 'title' },
            //{ data: 'token', className: 'text-token' },
            //{ data: 'content' },
            { data: 'updated_at' },
            { data: 'id', className: 'text-center' },
            { data: 'id', className: 'text-center' },
            /* 
            {data: "id" , render : function ( data, type, row, meta ) {
              return type === 'display'  ?
                '<a href="#'+ data +'" ><i class="fe fe-delete"></i></a>' :
                data;
            }},
            */
         ],
      }
   }

   componentDidMount() {
      window.clipboard = new ClipboardJS('a.btn');

      DataTable.use(DT); //https://datatables.net/manual/react 

      store.subscribe(() => this.handleStore(store.getState()));            
   }

   handleStore(storeReducer) {
      this.handleProjects(storeReducer.projectsReducer);
   }   

   handleProjects(projects) {
       this.setState({
          tableData: projects,  
       });
   } 
   
   viewPrompts(idProject) {
      location.href = '/project/' + idProject + '/list-prompts';
   }

   modalShow(variant, id = null) {
      console.log(id);

      this.setState({
         variant: variant,
         show: true,
         id: id,
      }); 
   } 

   preDeleteProject(id) {
      Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
      }).then((result) => {
         if (result.isConfirmed) {
            this.deleteProject(id);
         }
      });
   }  
   
   deleteProject(id) {
         let self = this;

         axios
         .delete('/projects/' + id)
            .then(function (resp) {
               console.log(resp.data);

               self.handleProjects(resp.data);
            })
            .catch(function (resp) {
               console.log(resp.response);

               Swal.fire({
                  icon: 'error',
                  text: resp.response.data.message,
               });                
            });  
   }

   modalClose() {
      this.setState({
         show: false, 
      });  
   }

   render() {
      return (
            <div>

               <Modal show={this.state.show}>
                  <Modal.Header>
                     <Button variant="secondary" onClick={this.modalClose}>Close</Button>
                  </Modal.Header>        
                  <Modal.Body>

                     {this.state.variant == 'add' &&
                     (
                     <AddProjectDialog modalClose={this.modalClose} /> 
                     )} 

                     {/*
                     {this.state.variant == 'update' &&
                     (
                     <UpdatePromptDialog modalClose={this.modalClose} id={this.state.id} /> 
                     )}
                     {this.state.variant == 'execute' &&
                     (
                     <ExecutePromptDialog modalClose={this.modalClose} id={this.state.id} /> 
                     )}  
                     */}                                                                     
                  </Modal.Body>                 
               </Modal> 

               <div id="page-wrapper">
                  <div className="container-fluid pt-5">
                    <div className="row page-header">
                        <div className="col-lg-12">
                            <i className="fa fa-plus fa-2x my-plus-icon" aria-hidden="true" onClick={() => {this.modalShow('add');}}></i> <span className="my-plus-text">Add a new Project</span>
                        </div>
                    </div>                  
                   
                    <div className="row">
                        <DataTable
                           slots={{
                              //0: (data, row) => (<i className="fa fa-play fa-2x my-play-icon" aria-hidden="true" onClick={() => {this.modalShow('execute', data);}}></i>),  
                              //1: (data, row) => (<a href="#" className="btn btn-link" data-toggle="tooltip" title="click to copy to clipboard" value="copied..." onClick={(event) => {event.preventDefault();}} data-clipboard-text={data}>{data}</a>),  
                              //3: (data, row) => (<textarea className="form-control" rows="5" disabled="true">{data}</textarea>),                           
                              2: (data, row) => (<i className="fa fa-desktop fa-2x my-desktop-icon" aria-hidden="true" onClick={() => {this.viewPrompts(data);}}></i>), 
                              3: (data, row) => (<i className="fa fa-trash fa-2x my-trash-icon" aria-hidden="true" onClick={() => {this.preDeleteProject(data);}}></i>)     
                           }} 
                           data={this.state.tableData} 
                           columns={this.state.columns} 
                           //className="display"
                           className="table table-striped table-bordered"
                           options={{
                              responsive: true,
                              select: true,
                           }}>
                            <thead>
                                <tr>
                                    {/*<th className="my-play-text" style={{width: '5%'}}>execute</th>*/}   
                                    <th style={{width: '70%'}}>Title</th>
                                    {/*<th style={{width: '20%', color: 'black', cursor: 'auto'}}>Token-API</th>*/}                              
                                    {/*<th style={{width: '40%'}}>Content</th>*/}
                                    <th style={{width: '20%'}}>Created</th>
                                    <th className="my-pencil-text" style={{width: '5%'}}>show Project</th>
                                    <th className="my-trash-text" style={{width: '5%'}}>delete</th>
                                </tr>
                            </thead>
                        </DataTable>
                     </div>
                  </div>
               </div>
            </div>                       
      );    	
   }

}

const root = ReactDOM.createRoot(document.querySelector('.list-projects'));

root.render(<ListProjectsDialog />);


