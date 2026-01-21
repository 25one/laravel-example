import React from 'react'
import axios from 'axios'
import Swal from 'sweetalert2'
import {store} from '../reducer'

import ClipboardJS from 'clipboard';

export default class ExecutePromptDialog extends React.Component {

   constructor(props) {
      super(props);

      this.state = {
         id: null,
         tokenPrompt: '',
         titlePrompt: '',
         contentPrompt: '',
         resultPrompt: '',
         loader: false,
      }
   }

   componentDidMount() {
      window.clipboard = new ClipboardJS('a.btn');

      this.getPrompt();  
   }

   getPrompt() {
         let self = this;

         axios
         .get('/prompts/' + this.props.id)
            .then(function (resp) {
               console.log(resp.data);

               self.setState({
                  id: resp.data.id, 
                  tokenPrompt: resp.data.token,
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

   executePrompt() {
         let self = this;

         this.setState({
            resultPrompt: '',
            loader: true,                  
         }); 

         axios
         .post('/execute-prompt', {prompt: this.state.contentPrompt})
            .then(function (resp) {
               console.log(resp.data);

               self.setState({
                  loader: false, 
                  resultPrompt: resp.data,                  
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

   render() {
      return (         
         <form role="form">
            <div className="form-group">
                  <label>Token-API of prompt </label>
                  <a href="#" className="form-control btn btn-link" data-toggle="tooltip" title="click to copy to clipboard" value="copied..." onClick={(event) => {event.preventDefault();}} data-clipboard-text={this.state.tokenPrompt}>{this.state.tokenPrompt}</a>
            </div>  
            <hr />          
            <div className="form-group">
                  <label>Title of prompt</label>
                  <input className="form-control" disabled={true} value={this.state.titlePrompt} readOnly />
            </div>
            <div className="form-group">
                  <label>Content of prompt</label>
                  <textarea className="form-control" rows="3" disabled={true} value={this.state.contentPrompt} readOnly></textarea>
                  <p className="help-block">What do you want to ask AI?</p>
            </div> 
            <div className="form-group pt-2">
                  <label>AI-result of prompt</label>
                  {this.state.loader ? (
                  <div>
                     <img className="img_loader" src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif" alt="" />
                  </div>
                  )
                  :
                  <div>&nbsp;</div>
                  }                   
                  <textarea className="form-control" rows="3" readOnly value={this.state.resultPrompt}></textarea>
                  <p className="help-block">What will AI answer you?</p>
            </div>             
            {/* 
            <div className="form-group">
                  <label>File input</label>
                  <input type="file" />
            </div> 
            */} 
            <div className="form-group">
               <button type="button" className="btn btn-primary" onClick={() => this.executePrompt()}>Submit</button>
            </div>                                                                                 
         </form>
      );    	
   }

}
