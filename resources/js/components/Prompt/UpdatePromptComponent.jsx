import React from 'react'
import axios from 'axios'
import Swal from 'sweetalert2'
import {store} from '../reducer'

export default class UpdatePromptDialog extends React.Component {

   constructor(props) {
      super(props);

      this.handleNumberPrompt = this.handleNumberPrompt.bind(this);
      this.handleTitlePrompt = this.handleTitlePrompt.bind(this);
      this.handleContentPrompt = this.handleContentPrompt.bind(this);

      this.state = {
         id: null,
         numberPrompt: '',
         titlePrompt: '',
         contentPrompt: '',
      }
   }

   componentDidMount() {
      this.getPrompt();  
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

   getPrompt() {
         let self = this;

         axios
         .get('/prompts/' + this.props.id)
            .then(function (resp) {
               console.log(resp.data);

               self.setState({
                  id: resp.data.id, 
                  idProject: resp.data.project_id,
                  numberPrompt: resp.data.number,
                  titlePrompt: resp.data.title,
                  contentPrompt: resp.data.content,                  
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

   updatePrompt() {
         let self = this;

         axios
         .put('/prompts/' + this.state.id, {idProject: this.state.idProject, idPrompt: this.state.id, numberPrompt: this.state.numberPrompt, titlePrompt: this.state.titlePrompt, contentPrompt: this.state.contentPrompt})
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
                  <input className="form-control" onChange={this.handleNumberPrompt} value={this.state.numberPrompt} />
            </div>              
            <div className="form-group">
                  <label>Title of prompt</label>
                  <input className="form-control" onChange={this.handleTitlePrompt} value={this.state.titlePrompt} />
            </div>
            <div className="form-group">
                  <label>Content of prompt</label>
                  <textarea className="form-control" rows="3" onChange={this.handleContentPrompt} value={this.state.contentPrompt}></textarea>
                  <p className="help-block">What do you want to ask AI?</p>
            </div> 
            {/* 
            <div className="form-group">
                  <label>File input</label>
                  <input type="file" />
            </div> 
            */} 
            <div className="form-group">
               <button type="button" className="btn btn-primary" onClick={() => this.updatePrompt()}>Submit</button>
            </div>                                                                                 
         </div>
      );    	
   }

}
