import React from 'react';
import ReactDOM from "react-dom/client";
import axios from 'axios';
import Swal from 'sweetalert2';

class SettingsDialog extends React.Component {

   constructor(props) {
      super(props);

      this.makeSetting = this.makeSetting.bind(this);

      this.state = {
         topmodels: window.models,
         bottommodels: [],
         selectedTopModelId: null,
         selectedBottomModelId: null,
      }
   }

   componentDidMount() {     
      this.getStartBottomModels();
   }

   getStartBottomModels() {
      let topmodel = this.state.topmodels.filter((model) => model.active == 1); 
      let bottommodel = topmodel[0].bottommodels.filter((model) => model.active == 1); 

      this.setState({
         bottommodels: topmodel[0].bottommodels,
         selectedTopModelId: topmodel[0].id,
         selectedBottomModelId: bottommodel[0].id,
      });      
   }
  
   changeTopModel(id) {
      let self = this;

      let topmodels = this.state.topmodels;

      topmodels.map(function(topmodel, key) {
         if (topmodel.id == id) {
            topmodel.active = 1;
            let bottommodel = topmodel.bottommodels.filter((model) => model.active == 1); 
            self.setState({
               bottommodels: topmodel.bottommodels,  
               selectedBottomModelId: bottommodel[0].id, 
            });
         } else {
            topmodel.active = 0;
         }
      });
      
      //console.log(topmodels);

      this.setState({
         topmodels: topmodels, 
         selectedTopModelId: id,   
      }); 
   }

   changeBottomModel(id) {
      let self = this;

      let bottommodels = this.state.bottommodels;

      bottommodels.map(function(bottommodel, key) {
         if (bottommodel.id == id) {
            bottommodel.active = 1;  
         } else {
            bottommodel.active = 0;
         }
      });
      
      //console.log(bottommodels);

      this.setState({
         bottommodels: bottommodels,
         selectedBottomModelId: id,   
      }); 
   } 
   
   makeSetting() {
      let self = this;

      axios
       .post('/make-settings', {selectedTopModelId: this.state.selectedTopModelId, selectedBottomModelId: this.state.selectedBottomModelId})
         .then(function (resp) {
            console.log(resp.data);

            self.setState({
               topmodels: resp.data,
            }); 

            setTimeout(() => { //!!!
               self.getStartBottomModels();
            }, "500");            

            Swal.fire({
               icon: 'success',
               text: 'Settings were changing successful!',
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

   render() {
      return (
            <div>
               <div id="page-wrapper">
                  <div className="container-fluid pt-5">

                    <div className="row page-header">
                        <div className="col-lg-12">
                            <h3>Settings</h3>
                        </div>
                    </div>

                     <div className="row">
                        <div className="col-lg-6"> 
                           <form> 
                              {this.state.topmodels.map((topmodel, key) =>
                              <div className="form-check" key={key}>
                                 <input className="form-check-input" type="radio" name="topmodel" id={"topmodel" + topmodel.id} value={topmodel.id} checked={topmodel.active == 1} onChange={() => {this.changeTopModel(topmodel.id);}} />
                                 &nbsp;<label className="form-check-label" htmlFor={"topmodel" + topmodel.id}>
                                    {topmodel.model}
                                 </label>
                              </div>
                              )}
                           </form>
                        </div>
                        <div className="col-lg-6"> 
                           <form> 
                              {this.state.bottommodels.map((bottommodel, key) =>                              
                              <div className="form-check" key={key}>
                                 <input className="form-check-input" type="radio" name="bottommodel" id={"bottommodel" + bottommodel.id} value={bottommodel.id} checked={bottommodel.active == 1} onChange={() => {this.changeBottomModel(bottommodel.id);}} />
                                 &nbsp;<label className="form-check-label" htmlFor={"bottommodel" + bottommodel.id}>
                                    {bottommodel.model}
                                 </label>
                              </div>
                              )}
                           </form>
                        </div>                    
                     </div>

                     <div className="row">
                        <div className="col-lg-6"> 
                           <button type="button" className="btn btn-primary" onClick={this.makeSetting}>Submit</button>
                        </div>
                     </div>                                                
                   
                  </div>
               </div>
            </div>                       
      );    	
   }

}

const root = ReactDOM.createRoot(document.querySelector('.settings-container'));

root.render(<SettingsDialog />);


