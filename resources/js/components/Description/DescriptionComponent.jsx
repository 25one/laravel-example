import React from 'react';
import ReactDOM from "react-dom/client";
import axios from 'axios';
import Swal from 'sweetalert2';

import ModalDialog from '../Components/ModalComponent';

import TableDialog from '../Components/TableComponent';

import AddDescriptionDialog from './AddDescriptionComponent';
import UpdateDescriptionDialog from './UpdateDescriptionComponent';
import {store} from '../reducer';

class DescriptionDialog extends React.Component {

   constructor(props) {
      super(props);

      this.reset = this.reset.bind(this);

      this.state = {
         variant: null,
         id: null,

         tableData: window.description,

         noAddAction: window.description.length, //...!!!table - only here

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

         slots: {
                  0: (data, row) => (<textarea className="form-control" rows="10" value={data} disabled={true}>{data}</textarea>),                           
                  2: (data, row) => (<i className="fa fa-pencil-square fa-2x my-pencil-icon" aria-hidden="true" onClick={() => {this.modalShow('update', data);}}></i>), 
                  3: (data, row) => (<i className="fa fa-trash fa-2x my-trash-icon" aria-hidden="true" onClick={() => {this.preDeleteDescription(data);}}></i>)     
                },

         options: {
                     responsive: true,
                     select: true,
                     paging: false,
                     info: false,
                     searching: false,
                  },

         thead: <thead>
                  <tr>
                     <th style={{width: '75%'}}>Description</th>
                     <th style={{width: '15%'}}>Created</th>
                     <th className="my-pencil-text" style={{width: '5%'}}>update</th>
                     <th className="my-trash-text" style={{width: '5%'}}>delete</th>
                  </tr>
               </thead>
      }
   }

   componentDidMount() {
      //because this.state.noAddAction
      store.subscribe(() => this.handleStore(store.getState()));  //...!!!table - only here
   }

   handleStore(storeReducer) {  //...!!!table - only here
      if (storeReducer.tableDataReducer) {
         this.setState({
            noAddAction: storeReducer.tableDataReducer.length,  
         });
      }   
   } 

   modalShow(variant, id = null) {
      //console.log(id);

      this.setState({
         variant: variant,
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

               //...!!!table
               store.dispatch({ type: 'CHANGE_STATE_TABLEDATA', tableDataAfterChange: resp.data });
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
               <ModalDialog reset={this.reset} component={<AddDescriptionDialog />} /> 
               )}

               {this.state.variant == 'update' &&
               (
               <ModalDialog reset={this.reset} component={<UpdateDescriptionDialog id={this.state.id} />} /> 
               )}               

               <div id="page-wrapper">
                  <div className="container-fluid pt-5">

                    <div className="row page-header">
                        {! this.state.noAddAction ?
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

                        <TableDialog tableData={this.state.tableData}
                                     //actionAdd={this.actionAdd} 
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

const root = ReactDOM.createRoot(document.querySelector('.description'));

root.render(<DescriptionDialog />);


