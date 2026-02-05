import React from 'react'
import axios from 'axios'
import Swal from 'sweetalert2'
import {store} from '../reducer'

export default class AddPromptDialog extends React.Component {

   constructor(props) {
      super(props);

      this.handleNumberPrompt = this.handleNumberPrompt.bind(this); 
      this.handleTitlePrompt = this.handleTitlePrompt.bind(this);
      this.handleContentPrompt = this.handleContentPrompt.bind(this);

      this.state = {
         numberPrompt: '',
         titlePrompt: '',
         contentPrompt: '',
      }
   }

   componentDidMount() {
      //...  
   } 

   handleNumberPrompt(event) {
      this.setState({
         numberPrompt: event.target.value, 
      }); 
   }

   handleTitlePrompt(event) {
      this.setState({
         titlePrompt: event.target.value, 
      }); 
   }

   handleContentPrompt(event) {
      this.setState({
         contentPrompt: event.target.value, 
      }); 
   }

   addPrompt() {
         let self = this;

         axios
         .post('/prompts', {idProject: this.props.idProject, numberPrompt: this.state.numberPrompt, titlePrompt: this.state.titlePrompt, contentPrompt: this.state.contentPrompt})
            .then(function (resp) {
               console.log(resp.data);

               store.dispatch({ type: 'CHANGE_STATE_TABLEDATA', tableDataAfterChange: resp.data.prompts });
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
                  <label className="text-danger">Number of Prompt</label>
                  <input className="form-control" onChange={this.handleNumberPrompt} />
            </div>           
            <div className="form-group">
                  <label>Title of Prompt</label>
                  <input className="form-control" onChange={this.handleTitlePrompt} />
            </div>
            <div className="form-group">
                  <label>Content of Prompt</label>
                  <textarea className="form-control" rows="3" onChange={this.handleContentPrompt}></textarea>
                  <p className="help-block">What do you want to ask AI?</p>
            </div> 
            {/* 
            <div className="form-group">
                  <label>File input</label>
                  <input type="file" />
            </div> 
            */} 
            <div className="form-group pt-2">
               <button type="button" className="btn btn-primary" onClick={() => this.addPrompt()}>Submit</button>
            </div>                                                                                 
         </div>
      );    	
   }

}
