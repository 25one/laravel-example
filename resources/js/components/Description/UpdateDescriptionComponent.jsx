import React from 'react'
import axios from 'axios'
import Swal from 'sweetalert2'
import {store} from '../reducer'

export default class UpdateDescriptionDialog extends React.Component {

   constructor(props) {
      super(props);

      this.handleDescription = this.handleDescription.bind(this);

      this.state = {
         id: null,
         description: '',
      }
   }

   componentDidMount() {
      this.getDescription();  
   } 

   handleDescription(event) {
      this.setState({
         description: event.target.value, 
      }); 
   }

   getDescription() {
         let self = this;

         axios
         .get('/descriptions/' + this.props.id)
            .then(function (resp) {
               console.log(resp.data);

               self.setState({
                  id: resp.data.id, 
                  description: resp.data.description,                  
               });
            })
            .catch(function (resp) {
               console.log(resp.response);

               Swal.fire({
                  icon: 'error',
                  text: resp.response.data.message,
               });

               self.props.modalClose();
            });
   } 

   updateDescription() {
         let self = this;

         axios
         .put('/descriptions/' + this.state.id, {description: this.state.description})
            .then(function (resp) {
               console.log(resp.data);

               //...!!!table
               store.dispatch({ type: 'CHANGE_STATE_TABLEDATA', tableDataAfterChange: resp.data });
               store.dispatch({ type: 'CHANGE_MODAL_SHOW', showModalAfterChange: false });
            })
            .catch(function (resp) {
               console.log(resp.response);

               let errors = resp.response.data.errors;               
               let titleErrors = '';
               for (let i in errors) {
                  //titleErrors += i + ' - ' + errors[i] + ' ';
                  titleErrors += errors[i] + ' ';
               }
               Swal.fire({
                  icon: 'error',
                  text: titleErrors,
               });                 
            });
   } 

   render() {
      return (
         <div>
            <div className="form-group">
                  <label>Description</label>
                  <textarea className="form-control" rows="7" value={this.state.description} onChange={this.handleDescription}></textarea>
            </div>
            <div className="form-group pt-2">
               <button type="button" className="btn btn-primary" onClick={() => this.updateDescription()}>Submit</button>
            </div>                                                                                 
         </div>
      );    	
   }

}
