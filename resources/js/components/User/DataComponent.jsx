import React from 'react'
import axios from 'axios'
import Swal from 'sweetalert2'

import './user.css';

export default class DataDialog extends React.Component {

   constructor(props) {
      super(props);

      this.handlePassword = this.handlePassword.bind(this);
      this.handlePasswordConfirm = this.handlePasswordConfirm.bind(this);

      this.topmodelChange = this.topmodelChange.bind(this);

      this.activeChange = this.activeChange.bind(this);

      this.handleApiKey = this.handleApiKey.bind(this);

      this.eyeIconPassword = this.eyeIconPassword.bind(this);
      this.eyeIconPasswordConfirm = this.eyeIconPasswordConfirm.bind(this);

      this.state = {
         user: [],
         topmodels: [],
         keys: [],
         topmodelId: '1',
         selectedApiKey: '',
         selectedActive: '0',

         password: '',
         passwordConfirm: '',

         eyeIconPassword: 'bi bi-eye-slash',
         eyeIconPasswordConfirm: 'bi bi-eye-slash',
         //eyeIconPassword: 'zmdi zmdi-eye-off',
         //eyeIconPasswordConfirm: 'zmdi zmdi-eye-off',         

         typePassword: 'password',
         typePasswordConfirm: 'password',
      }
   }

   componentDidMount() {
      this.getData();  
   } 

   getData() {
         let self = this;

         axios
         .get('/get-data-user')
            .then(function (resp) {
               //console.log(resp.data);

               self.setState({
                  user: resp.data.user,
                  keys: resp.data.user.keys,
                  topmodels: resp.data.topmodels,
                  topmodelId: resp.data.topmodels[0].id,
               });

               self.getSelectedKey(resp.data.topmodels[0].id, resp.data.user.keys);
            })
            .catch(function (resp) {
               //console.log(resp.response);

               Swal.fire({
                  icon: 'error',
                  text: resp.response.data.message,
               });
            });
   } 

   topmodelChange(event) {
      this.setState({
         topmodelId: event.target.value,
      });

      this.getSelectedKey(event.target.value, this.state.keys);
   }

   getSelectedKey(topmodelId, userKeys) {
      let self = this;

      this.setState({
         selectedApiKey: '',
         selectedActive: '0',
      });

      userKeys.map(function(item, key) {
         if (item.topmodel_id == topmodelId) {
            self.setState({
               selectedApiKey: item.api_key,
               selectedActive: item.active,
            });            
         }
      });
   }

   activeChange() {
      if (this.state.selectedActive == 1) {
         this.setState({
            selectedActive: '0',
         }); 
      } else {
         this.setState({
            selectedActive: '1',
         }); 
      }    
   }

   handleApiKey(event) {
      this.setState({
         selectedApiKey: event.target.value,
      }); 
   }

   saveApiKey() {
      let self = this;

      axios
      .post('/save-apikey-user', {topmodelId: this.state.topmodelId, apiKey: this.state.selectedApiKey, active: this.state.selectedActive})
         .then(function (resp) {
            //console.log(resp.data);

            self.setState({
               selectedApiKey: resp.data.api_key,
               selectedActive: resp.data.active,
               keys: resp.data.userKeys,
            }); 

            Swal.fire({
               icon: resp.data.activeCheck.icon,
               //text: 'The Api Key has been changed',
               text: resp.data.activeCheck.text,
            });  
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

   removeApiKey() {
      let self = this;

      axios
      .post('/remove-apikey-user', {topmodelId: this.state.topmodelId})
         .then(function (resp) {
            //console.log(resp.data);

            self.setState({
               selectedApiKey: resp.data.api_key,
               selectedActive: resp.data.active,
               keys: resp.data.userKeys,
            }); 

            Swal.fire({
               icon:  resp.data.activeCheck.icon,
               //text: 'The Api Key has been removed',
               text: resp.data.activeCheck.text,
            });     
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

   eyeIconPassword() {
      if (this.state.eyeIconPassword == 'bi bi-eye-slash') {
      //if (this.state.eyeIconPassword == 'zmdi zmdi-eye-off') {
         this.setState({
            eyeIconPassword: 'bi bi-eye', 
            //eyeIconPassword: 'zmdi zmdi-eye',
            typePassword: 'text',
         });
      } else {
         this.setState({
            eyeIconPassword: 'bi bi-eye-slash',
            //eyeIconPassword: 'zmdi zmdi-eye-off',
            typePassword: 'password',  
         });         
      }
   }

   eyeIconPasswordConfirm() {
      if (this.state.eyeIconPasswordConfirm == 'bi bi-eye-slash') {
      //if (this.state.eyeIconPasswordConfirm == 'zmdi zmdi-eye-off') {
         this.setState({
            eyeIconPasswordConfirm: 'bi bi-eye',  
            //eyeIconPasswordConfirm: 'zmdi zmdi-eye', 
            typePasswordConfirm: 'text', 
         });
      } else {
         this.setState({
            eyeIconPasswordConfirm: 'bi bi-eye-slash',  
            //eyeIconPasswordConfirm: 'zmdi zmdi-eye-off',
            typePasswordConfirm: 'password',  
         });         
      }      
   }

   handlePassword(event) {
      this.setState({
         password: event.target.value, 
      }); 
   }

   handlePasswordConfirm(event) {
      this.setState({
         passwordConfirm: event.target.value, 
      }); 
   }

   changePassword() {
         let self = this;

         axios
         .post('/change-password-user', {password: this.state.password, password_confirmation: this.state.passwordConfirm})
            .then(function (resp) {
               console.log(resp.data);

               location.href = '/';           
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

               location.href = '/';
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
         <div>
            <strong className="text-success">API KEY</strong>
            <div className="row">
               <div className="col-xl-4">   
                  <select className="form-select p-2" value={this.state.topmodelId} onChange={this.topmodelChange}>
                     {this.state.topmodels.map((item, key) =>
                        <option key={key} value={item.id}>{item.model}</option>   
                     )}             
                  </select>
               </div>
               <div className="col-xl-4">
                  <div className="form-check">
                     <input className="form-check-input" type="checkbox" value={this.state.selectedActive} checked={this.state.selectedActive == 1} onChange={this.activeChange} />
                     <label className="form-check-label">
                        Active
                     </label>
                  </div>               
               </div>
            </div>   
            <div className="row">   
               <div className="col-xl-8">
                  <input type="text" className="form-control mt-2 p-2" value={this.state.selectedApiKey} onChange={this.handleApiKey} />
               </div>
               <div className="col-xl-2">
                  <i className="bi bi-check-circle user-profile-check" onClick={(e) => {this.saveApiKey();}}></i>
               </div> 
               <div className="col-xl-2">
                  <i className="bi bi-trash my-trash-icon user-profile-trash" onClick={(e) => {this.removeApiKey();}}></i>
               </div>                
            </div>
            {/*
            <div className="form-group">
               <button type="button" className="btn btn-success mt-2 p-2" onClick={(e) => {this.saveApiKey();}}>Save Api Key</button>
            </div> 
            */}           
            <hr />
            <strong className="text-primary">Change Password</strong>
            <div className="form-group">
                  <label>New Password</label>
                  <div className="input-group">
                     <input type={this.state.typePassword} className="form-control p-2" onChange={this.handlePassword} />
                     <button className="btn btn-outline-secondary p-2" type="button" onClick={this.eyeIconPassword}>
                        <i className={this.state.eyeIconPassword}></i>
                     </button>
                  </div>
            </div>              
            <div className="form-group">
                  <label>Confirm New Password</label>
                  <div className="input-group">
                     <input type={this.state.typePasswordConfirm} className="form-control p-2" onChange={this.handlePasswordConfirm} />
                     <button className="btn btn-outline-secondary p-2" type="button" onClick={this.eyeIconPasswordConfirm}>
                        <i className={this.state.eyeIconPasswordConfirm}></i>
                     </button>
                  </div>
            </div>
            <div className="form-group">
                  <button type="button" className="btn btn-primary mt-2 p-2" onClick={(e) => {this.changePassword();}}>Change Password</button>
            </div>
            <hr />
            <div className="form-group">
                  <button type="button" className="btn btn-danger p-2" onClick={(e) => {this.preDeleteAccount(); e.preventDefault();}}>Remove account</button>
            </div>
         </div>
      );    	
   }

}
