import React from 'react';
import ReactDOM from "react-dom/client";

import ModalDialog from '../Components/ModalComponent';

import DataDialog from './DataComponent';

class ProfileDialog extends React.Component {

   constructor(props) {
      super(props);

      this.reset = this.reset.bind(this);

      this.state = {
         variant: null,
      }
   }

   componentDidMount() {
      //...        
   }

   showProfile() {
      this.setState({
         variant: 'show',   
      });
   }  
 
   reset() { //???
      this.setState({
         variant: null,
      }); 
   }

   render() {
      return (
         <span>
            {this.state.variant == 'show' &&
            (
            <ModalDialog reset={this.reset} component={<DataDialog />} /> 
            )}           
            <span onClick={(e) => {this.showProfile(); e.preventDefault();}}>User Profile</span>                   
         </span>
      );    	
   }

}

const root = ReactDOM.createRoot(document.querySelector('.user-profile'));

root.render(<ProfileDialog />);


