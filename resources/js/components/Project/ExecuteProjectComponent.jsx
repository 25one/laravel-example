import React from 'react'
import axios from 'axios'
import Swal from 'sweetalert2'
import {store} from '../reducer'

import ClipboardJS from 'clipboard';

export default class ExecuteProjectDialog extends React.Component {

   constructor(props) {
      super(props);

      this.result = '';

      this.state = {
         idProject: null,
         tokenProject: '',
         titleProject: '',
         promptsProject: [],
         resultProject: '',
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
         .get('/projects/' + this.props.idProject)
            .then(function (resp) {
               console.log(resp.data);

               self.setState({
                  idProject: resp.data.id, 
                  tokenProject: resp.data.token,
                  titleProject: resp.data.title,
                  promptsProject: resp.data.prompts_active,                  
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

   async executeProject() {
         let self = this;

         this.setState({
            resultProject: '',               
         }); 
 

      for (let prompt of this.state.promptsProject) {
         if (prompt.content.includes('#beforeprompt#')) {
             //console.log(prompt.content);

             //console.log(this.result);

             prompt.content = prompt.content.replace(/#beforeprompt#/, this.result);

             console.log(prompt.content);
         }  

         this.setState({
            loader: true,
            executablePrompt: prompt.title,
         });
         await axios
         .post('/execute-prompt', {prompt: prompt.content})
            .then(function (resp) {
               let errorPython = null;

               if (Array.isArray(resp.data)) {
                  self.result = JSON.stringify(resp.data)
               } else if (typeof resp.data === 'object' && resp.data !== null && 'errorPython' in resp.data) {
                  errorPython = resp.data.errorPython.message;
               } else {
                  self.result = resp.data;
               }

               //console.log(self.result);
               //console.log(errorPython);

               if (errorPython) {
                  self.setState({
                     loader: false, 
                     resultProject: '',
                  });                  
                  Swal.fire({
                     icon: 'error',
                     //text: errorPython,
                     text: "There is something wrong. Please try again later.", 
                  });
               } else {
                  self.setState({
                     loader: false, 
                     executablePrompt: '',
                     resultProject: self.result                 
                  });  
               }              
            })
            .catch(function (resp) {
               console.log(resp.response);

               Swal.fire({
                  icon: 'error',
                  //text: resp.response.data.message,
                  text: "There is something wrong. Please try again later.",
               });

               self.props.modalClose();
            });

      }      
   } 

   render() {
      return (         
         <div>
            <div className="form-group">
                  <label>Token-API of project </label>
                  <a href="#" className="form-control btn btn-link" data-toggle="tooltip" title="click to copy to clipboard" value="copied..." onClick={(event) => {event.preventDefault();}} data-clipboard-text={this.state.tokenProject}>{this.state.tokenProject}</a>
            </div>  
            <hr />          
            <div className="form-group">
                  <label>Title of project</label>
                  <input className="form-control" disabled={true} value={this.state.titleProject} readOnly />
            </div>
            <div className="form-group pt-2">
                  <label className="form-group text-success">List prompts of project</label>
                  {this.state.promptsProject.map((item, key) =>
                     <div key={key}><span className="text-danger">{item.number}.</span> {item.title}</div>
                  )}
            </div>
            {/*
            <div className="form-group">
                  <label>Content of prompt</label>
                  <textarea className="form-control" rows="3" disabled={true} value={this.state.contentPrompt} readOnly></textarea>
                  <p className="help-block">What do you want to ask AI?</p>
            </div> 
            */}
            <div className="form-group pt-2">
                  <label>AI-result of project</label>
                  {this.state.loader ? (
                  <div>
                     <img className="img_loader" src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif" alt="" />
                     <span className="text-danger">{this.state.executablePrompt}</span>
                  </div>
                  )
                  :
                  <div>&nbsp;</div>
                  }                   
                  <textarea className="form-control" rows="3" readOnly value={this.state.resultProject}></textarea>
                  <p className="help-block">What will AI answer you?</p>
            </div>             
            {/* 
            <div className="form-group">
                  <label>File input</label>
                  <input type="file" />
            </div> 
            */} 
            <div className="form-group">
               <button type="button" className="btn btn-primary" onClick={() => this.executeProject()}>Submit</button>
            </div>                                                                                 
         </div>
      );    	
   }

}
