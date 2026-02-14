import React from 'react';
import ReactDOM from "react-dom/client";
import axios from 'axios';
import Swal from 'sweetalert2';

class ReactDialog extends React.Component {

   constructor(props) {
      super(props);

      this.handleQuestion = this.handleQuestion.bind(this);  

      this.state = {
         api_token: window.api_token,

         question: '',
         answer: '',
         loader: false,
      }
   }

   componentDidMount() {
      //...
   }
  
   handleQuestion(event) {
      this.setState({
         question: event.target.value, 
      }); 
   } 

   sendQuestion() {
         let self = this;

         this.setState({
            answer: '',
            loader: true,                  
         }); 

         axios
         //.post('http://192.168.33.10:8080/api/widget-chat-question?api_token=' + this.state.api_token, {prompt: this.state.question}) //...or...
         .post('/api/widget-chat-question?api_token=' + this.state.api_token, {prompt: this.state.question})
            .then(function (resp) {
               //console.log(resp.data);

               let result = null;
               let errorPython = null;

               if (typeof resp.data === 'object' && resp.data !== null && 'errorPython' in resp.data) {
                  errorPython = resp.data.errorPython.message;
               } else {
                  result = resp.data;
               }

               if (errorPython) {
                  self.setState({
                     loader: false, 
                     resultPrompt: '',
                  });                  
                  Swal.fire({
                     icon: 'error',
                     //text: errorPython,
                     text: "There is something wrong. Please try again later.",
                  });
               } else {
                     self.setState({
                        loader: false,
                        answer: result, 
                     }); 
               }                            
            })
            .catch(function (resp) {
               console.log(resp.response);

               self.setState({
                  answer: '',
                  loader: false,
               });

               if ('errors' in resp.response.data) {
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
               } else if ('message' in resp.response.data) {
                  Swal.fire({
                     icon: 'error',
                     text: resp.response.data.message,
                     //text: "There is something wrong. Please try again later.",
                  }); 
               }             
            });
   }

   render() {
      return (
      	<div className="m-2">
               <form role="form">
                  <div className="form-group">
                        {this.state.loader ? (
                        <div>
                           <img className="img_loader" src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif" alt="" />
                        </div>
                        )
                        :
                        <div className="img_loader">&nbsp;</div>
                        }                                   
                        <textarea className="form-control" rows="5" value={this.state.answer} readOnly></textarea>
                  </div> 
                  <div className="input-group">
                     <input className="form-control" placeholder="type your question here" onChange={this.handleQuestion} />
                     <span className="input-group-text" onClick={() => {this.sendQuestion();}}><i className="bi bi-chevron-right text-success"></i></span>
                  </div>
               </form>
		   </div>
      );    	
   }

}

const root = ReactDOM.createRoot(document.querySelector('.react-container'));

root.render(<ReactDialog />);
