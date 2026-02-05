import React from 'react'
import axios from 'axios'
import Swal from 'sweetalert2'
import {store} from '../reducer'

export default class UpdateProjectDialog extends React.Component {

   constructor(props) {
      super(props);

      this.handleTitleProject = this.handleTitleProject.bind(this);

      this.state = {
         id: null,
         titleProject: '',
      }
   }

   componentDidMount() {
      this.getProject();  
   } 

   handleTitleProject(event) {
      this.setState({
         titleProject: event.target.value, 
      }); 
   }

   getProject() {
         let self = this;

         axios
         .get('/projects/' + this.props.id)
            .then(function (resp) {
               console.log(resp.data);

               self.setState({
                  id: resp.data.id, 
                  titleProject: resp.data.title,                
               });
            })
            .catch(function (resp) {
               console.log(resp.response);

               Swal.fire({
                  icon: 'error',
                  text: resp.response.data.message,
               });
            });
   } 

   updateProject() {
         let self = this;

         axios
         .put('/projects/' + this.state.id, {titleProject: this.state.titleProject})
            .then(function (resp) {
               console.log(resp.data);

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
                  <label>Title of project</label>
                  <input className="form-control" onChange={this.handleTitleProject} value={this.state.titleProject} />
            </div>
            <div className="form-group pt-2">
               <button type="button" className="btn btn-primary" onClick={() => this.updateProject()}>Submit</button>
            </div>                                                                                 
         </div>
      );    	
   }

}
