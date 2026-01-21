import { legacy_createStore as createStore } from 'redux';

const reducer = (store = null, action) => {  
  switch (action.type) {
    case 'CHANGE_STATE_PROMPTS':
      return {
        promptsReducer: action.promptsAfterChange
      };
    case 'CHANGE_STATE_PROJECTS':  
      return {
        projectsReducer: action.projectsAfterChange
      }; 
    case 'CHANGE_STATE_DESCRIPTION':  
      return {
        descriptionReducer: action.descriptionAfterChange
      };           
    //...other events... 
    default:
      return store;
  }
};

export const store = createStore(reducer);
