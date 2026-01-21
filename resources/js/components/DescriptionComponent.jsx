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

import AddDescriptionDialog from './AddDescriptionComponent';
import UpdateDescriptionDialog from './UpdateDescriptionComponent';
import {store} from '../reducer';

class DescriptionDialog extends React.Component {

   constructor(props) {
      super(props);

      this.modalClose = this.modalClose.bind(this);

      this.state = {
         variant: null,
         show: false,
         id: null,

         tableData: window.description,

         columns: [
            { data: 'description' },
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
      DataTable.use(DT); //https://datatables.net/manual/react

      store.subscribe(() => this.handleStore(store.getState()));    
   } 

   handleStore(storeReducer) {
      this.handleDescription(storeReducer.descriptionReducer);
   }   

   handleDescription(description) {
       this.setState({
          tableData: description,  
       });
   }  

   modalShow(variant, id = null) {
      console.log(id);

      this.setState({
         variant: variant,
         show: true,
         id: id,
      }); 
   } 

   preDeleteDescription(id) {
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
            this.deleteDescription(id);
         }
      });
   }  
   
   deleteDescription(id) {
         let self = this;

         axios
         .delete('/descriptions/' + id)
            .then(function (resp) {
               console.log(resp.data);

               self.handleDescription(resp.data);
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
                     <AddDescriptionDialog modalClose={this.modalClose} /> 
                     )} 
                     {this.state.variant == 'update' &&
                     (
                     <UpdateDescriptionDialog modalClose={this.modalClose} id={this.state.id} /> 
                     )}                                                                
                  </Modal.Body>                 
               </Modal> 

               <div id="page-wrapper">
                  <div className="container-fluid pt-5">

                    <div className="row page-header">
                        {! this.state.tableData.length ?
                        (
                        <div className="row page-header">
                              <div className="col-lg-12">
                                 <i className="fa fa-plus fa-2x my-plus-icon" aria-hidden="true" onClick={() => {this.modalShow('add');}}></i> <span className="my-plus-text">Add a new Description </span>
                              </div>
                        </div> 
                        )
                        :
                        <span></span>
                        }
                    </div>  
                    <hr /> 
                   
                    <div className="row">
                        <DataTable
                           slots={{
                              0: (data, row) => (<textarea className="form-control" rows="10" value={data} disabled={true}>{data}</textarea>),                           
                              2: (data, row) => (<i className="fa fa-pencil-square fa-2x my-pencil-icon" aria-hidden="true" onClick={() => {this.modalShow('update', data);}}></i>), 
                              3: (data, row) => (<i className="fa fa-trash fa-2x my-trash-icon" aria-hidden="true" onClick={() => {this.preDeleteDescription(data);}}></i>)     
                           }} 
                           data={this.state.tableData} 
                           columns={this.state.columns} 
                           //className="display"
                           className="table table-striped table-bordered"
                           options={{
                              responsive: true,
                              select: true,
                              paging: false,
                              info: false,
                              searching: false,
                           }}>
                            <thead>
                                <tr>
                                    <th style={{width: '75%'}}>Description</th>
                                    <th style={{width: '15%'}}>Created</th>
                                    <th className="my-pencil-text" style={{width: '5%'}}>update</th>
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

const root = ReactDOM.createRoot(document.querySelector('.description'));

root.render(<DescriptionDialog />);


