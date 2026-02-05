import React from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import {store} from '../reducer';

export default class ModalDialog extends React.Component {

   constructor(props) {
      super(props);

      this.state = {
          show: false,
      }
   }

   componentDidMount() {
      this.handleShow(true);

      store.subscribe(() => this.handleStore(store.getState()));
   }

   handleStore(storeReducer) {
      this.handleShow(storeReducer.showModalReducer);
   }   

   handleShow(show) {
      this.setState({
         show: show,
      }); 

      if (show == false) this.props.reset();
   } 

   render() {
      return (
               <Modal show={this.state.show}>
                  <Modal.Header>
                     <Button variant="secondary" onClick={() => this.handleShow(false)}>Close</Button>
                  </Modal.Header>        
                  <Modal.Body>

                     {this.props.component}
                                                                   
                  </Modal.Body>                 
               </Modal>
      );    	
   }

}
