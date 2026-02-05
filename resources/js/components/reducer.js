import { legacy_createStore as createStore } from 'redux';

const reducer = (store = null, action) => {  
  switch (action.type) {
    case 'CHANGE_MODAL_SHOW':  
      return {
        showModalReducer: action.showModalAfterChange
      };  
    case 'CHANGE_STATE_TABLEDATA':  
      return {
        tableDataReducer: action.tableDataAfterChange
      };                       
    //...other events... 
    default:
      return store;
  }
};

export const store = createStore(reducer);
