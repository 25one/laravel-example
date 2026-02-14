import React from 'react';
import ReactDOM from "react-dom/client";
import axios from 'axios';
import Swal from 'sweetalert2';

class RemoveDialog extends React.Component {

   constructor(props) {
      super(props);

      //...

      this.state = {
         //...
      }
   }

   componentDidMount() {
      //...        
   }
  
   preDeleteAccount() {
      Swal.fire({
      title: "Are you sure?",
      text: "There will remove all your projects and prompts! You won't be able to revert this!",
      color: '#FF0000',
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
      }).then((result) => {
         if (result.isConfirmed) {
            this.deleteAccount();
         }
      });
   }  
   
   deleteAccount() {
         let self = this;

         axios
         .post('/remove-account', {})
            .then(function (resp) {
               console.log(resp.data);

               location.href = '/home/';
            })
            .catch(function (resp) {
               console.log(resp.response);

               Swal.fire({
                  icon: 'error',
                  text: resp.response.data.message,
               });                
            });  
   }

   render() {
      return (
         <span className="text-danger" onClick={(e) => {this.preDeleteAccount(); e.preventDefault();}}>Remove account</span>                   
      );    	
   }

}

const root = ReactDOM.createRoot(document.querySelector('.remove-account'));

root.render(<RemoveDialog />);


