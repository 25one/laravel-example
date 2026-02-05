import React from 'react';
import ReactDOM from "react-dom/client";
import axios from 'axios';
import Swal from 'sweetalert2';

import ClipboardJS from 'clipboard'; //???

import ModalDialog from '../Components/ModalComponent';

import TableDialog from '../Components/TableComponent';

import AddPromptDialog from './AddPromptComponent';
import UpdatePromptDialog from './UpdatePromptComponent';
import ExecutePromptDialog from './ExecutePromptComponent';
import ExecuteProjectDialog from '../Project/ExecuteProjectComponent';
import {store} from '../reducer';

class ListPromptsDialog extends React.Component {

   constructor(props) {
      super(props);

      this.reset = this.reset.bind(this);

      this.state = {
         variant: null,
         id: null,

         tableData: window.project.prompts,

         idProject: window.project.id,
         titleProject: window.project.title,
         tokenProject: window.project.token,         
         issetActivePrompts: false,

         columns: [
            { data: 'id', className: 'text-center' },
            { data: 'number', className: 'text-danger text-center' },
            { data: 'active', className: 'text-primary text-center' },
            { data: 'title' },
            { data: 'content' },
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

         slots: {
                  0: (data, row) => (<i className="fa fa-play fa-2x my-play-icon" aria-hidden="true" onClick={() => {this.modalShow('executePrompt', data);}}></i>),  
                  2: (data, row) => (<input type="checkbox" name="active" value={data} checked={data == 1} onChange={() => {this.changeActive(row.id);}} />), 
                  4: (data, row) => (<textarea className="form-control" rows="5" value={data} disabled={true}>{data}</textarea>),                           
                  6: (data, row) => (<i className="fa fa-pencil-square fa-2x my-pencil-icon" aria-hidden="true" onClick={() => {this.modalShow('update', data);}}></i>), 
                  7: (data, row) => (<i className="fa fa-trash fa-2x my-trash-icon" aria-hidden="true" onClick={() => {this.preDeletePrompt(data);}}></i>)     
                },

         options: {
                     responsive: true,
                     select: true,
                  },

         thead: <thead>
                  <tr>
                     <th className="my-play-text" style={{width: '5%'}}>execute Prompt</th>   
                     <th className="text-danger" style={{width: '5%'}}>№</th> 
                     <th className="text-primary" style={{width: '5%'}}>Active</th>                             
                     <th style={{width: '20%'}}>Title</th>
                     <th style={{width: '40%'}}>Content</th>
                     <th style={{width: '15%'}}>Created</th>
                     <th className="my-pencil-text" style={{width: '5%'}}>update</th>
                     <th className="my-trash-text" style={{width: '5%'}}>delete</th>
                  </tr>
               </thead>           
      }
   }

   componentDidMount() {
      window.clipboard = new ClipboardJS('a.btn'); //???

      //because componentDidUpdate() and getIssetActivePrompts()
      store.subscribe(() => this.handleStore(store.getState()));    

      this.getIssetActivePrompts();
   }

   handleStore(storeReducer) {
      if (storeReducer.tableDataReducer) this.handlePrompts(storeReducer.tableDataReducer);
   }   

   handlePrompts(prompts) {
       this.setState({
          tableData: prompts,  
       });
   } 

   componentDidUpdate(prevProps, prevState) {
   // Если tableData изменился, делаем новый запрос
      if (prevState.tableData != this.state.tableData) {
         this.getIssetActivePrompts();

         //console.log('change');
      }
   }   

   getIssetActivePrompts() {
      let self = this;

      for (let item of this.state.tableData) {
         if (item.active == '1') {
            self.setState({
               issetActivePrompts: true,  
            }); 

            return;
         }
      } 
      
      this.setState({
         issetActivePrompts: false,  
      });   
   }

   modalShow(variant, id = null) {
      console.log(id);

      this.setState({
         variant: variant,
         id: id,
      }); 
   } 

   preDeletePrompt(id) {
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
            this.deletePrompt(id);
         }
      });
   }  
   
   deletePrompt(id) {
         let self = this;

         axios
         .delete('/prompts/' + id)
            .then(function (resp) {
               console.log(resp.data);

               store.dispatch({ type: 'CHANGE_STATE_TABLEDATA', tableDataAfterChange: resp.data.prompts });
            })
            .catch(function (resp) {
               console.log(resp.response);

               Swal.fire({
                  icon: 'error',
                  text: resp.response.data.message,
               });                
            });  
   }

   changeActive(id) {
      //console.log(id);

         let self = this;

         axios
         .post('/change-active-prompt', {id: id, idProject: this.state.idProject})
            .then(function (resp) {
               console.log(resp.data);

               store.dispatch({ type: 'CHANGE_STATE_TABLEDATA', tableDataAfterChange: resp.data.prompts });
            })
            .catch(function (resp) {
               console.log(resp.response);

               Swal.fire({
                  icon: 'error',
                  text: resp.response.data.message,
               });                
            });        
   }

   reset() {
      this.setState({
         variant: null,
         id: null,
      }); 
   }

   render() {
      return (
            <div>

               {this.state.variant == 'add' &&
               (
               <ModalDialog reset={this.reset} component={<AddPromptDialog idProject={this.state.idProject} />} /> 
               )}
               {this.state.variant == 'update' &&
               (
               <ModalDialog reset={this.reset} component={<UpdatePromptDialog id={this.state.id} />} /> 
               )}
               {this.state.variant == 'executePrompt' &&
               (
               <ModalDialog reset={this.reset} component={<ExecutePromptDialog id={this.state.id} />} /> 
               )} 
               {this.state.variant == 'executeProject' &&
               (
               <ModalDialog reset={this.reset} component={<ExecuteProjectDialog idProject={this.state.idProject} />} /> 
               )}                                

               <div id="page-wrapper">
                  <div className="container-fluid pt-5">

                    <div className="row page-header">
                        {this.state.tableData.length && this.state.issetActivePrompts ?
                        (
                        <div className="col-lg-12">
                            <i className="fa fa-play fa-2x my-play-icon" aria-hidden="true" onClick={() => {this.modalShow('executeProject', this.state.idProject);}}></i> 
                            <span className="fs-4">execute Project</span> <b className="my-play-text fs-3">{this.state.titleProject}</b> 
                            {/*<p>(token-API <a href="#" data-toggle="tooltip" title="click to copy to clipboard" value="copied..." onClick={(event) => {event.preventDefault();}} data-clipboard-text={this.state.tokenProject}>{this.state.tokenProject})</a>)</p>*/}
                        </div>
                        )
                        :
                        <span></span>
                        }
                    </div>  
                    <hr />
                    <div className="row page-header">
                        <div className="col-lg-12">
                            <i className="fa fa-plus fa-2x my-plus-icon" aria-hidden="true" onClick={() => {this.modalShow('add');}}></i> <span className="my-plus-text">Add a new Prompt to Project </span>
                            <b className="my-play-text fs-3">{this.state.titleProject}</b>
                        </div>
                    </div>   
                   
                    <div className="row">

                        <TableDialog tableData={this.state.tableData} 
                                     columns={this.state.columns} 
                                     slots={this.state.slots} 
                                     options={this.state.options} 
                                     thead={this.state.thead} 
                                     />

                     </div>
                  </div>
               </div>
            </div>                       
      );    	
   }

}

const root = ReactDOM.createRoot(document.querySelector('.list-prompts'));

root.render(<ListPromptsDialog />);


