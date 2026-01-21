import React from 'react'
import axios from 'axios'
import Swal from 'sweetalert2'
import {store} from '../reducer'

export default class AddProjectDialog extends React.Component {

   constructor(props) {
      super(props);

      this.handleTitleProject = this.handleTitleProject.bind(this);

      this.state = {
         titleProject: '',
      }
   }

   componentDidMount() {
      //...  
   } 

   handleTitleProject(event) {
      this.setState({
         titleProject: event.target.value, 
      }); 
   }

   addProject() {
         let self = this;

         axios
         .post('/projects', {titleProject: this.state.titleProject})
            .then(function (resp) {
               console.log(resp.data);

               //store.dispatch({ type: 'CHANGE_STATE_PROJECTS', projectsAfterChange: resp.data });

               location.href = '/project/' + resp.data + '/list-prompts';
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
                  <label>Title of Project</label>
                  <input className="form-control" onChange={this.handleTitleProject} />
            </div>
            {/* 
            <div className="form-group">
                  <label>File input</label>
                  <input type="file" />
            </div> 
            */} 
            <div className="form-group pt-2">
               <button type="button" className="btn btn-primary" onClick={() => this.addProject()}>Submit</button>
            </div>                                                                                 
         </form>
      );    	
   }

}
