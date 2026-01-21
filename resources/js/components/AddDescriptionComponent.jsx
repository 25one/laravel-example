import React from 'react'
import axios from 'axios'
import Swal from 'sweetalert2'
import {store} from '../reducer'

export default class AddDescriptionDialog extends React.Component {

   constructor(props) {
      super(props);

      this.handleDescription = this.handleDescription.bind(this);

      this.state = {
         description: '',
      }
   }

   componentDidMount() {
      //...  
   } 

   handleDescription(event) {
      this.setState({
         description: event.target.value, 
      }); 
   }

   addDescription() {
         let self = this;

         axios
         .post('/descriptions', {description: this.state.description})
            .then(function (resp) {
               console.log(resp.data);

               store.dispatch({ type: 'CHANGE_STATE_DESCRIPTION', descriptionAfterChange: resp.data });

               self.props.modalClose();
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
         <form role="form">
            <div className="form-group">
                  <label>Description</label>
                  <textarea className="form-control" rows="7" onChange={this.handleDescription}></textarea>
            </div>
            <div className="form-group pt-2">
               <button type="button" className="btn btn-primary" onClick={() => this.addDescription()}>Submit</button>
            </div>                                                                                 
         </form>
      );    	
   }

}
