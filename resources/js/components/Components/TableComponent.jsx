import React from 'react';
import DataTable from 'datatables.net-react';
//import DT from 'datatables.net-dt';
import DT from 'datatables.net-bs5';
import 'datatables.net-select-dt';
import 'datatables.net-responsive-dt';
//import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/css/bootstrap-grid.min.css';
import {store} from '../reducer';

export default class TableDialog extends React.Component {

   constructor(props) {
      super(props);

      this.state = {
 
         tableData: this.props.tableData,

         columns: this.props.columns,
      }
   }

   componentDidMount() {
      DataTable.use(DT); //https://datatables.net/manual/react    
      
      store.subscribe(() => this.handleStore(store.getState()));
   }

   handleStore(storeReducer) {
      if (storeReducer.tableDataReducer) this.handleTableData(storeReducer.tableDataReducer);
   } 
   
   handleTableData(tableData) {
       this.setState({
          tableData: tableData,  
       });
   }     

   render() {
      return (
            <DataTable
               slots={this.props.slots} 
               data={this.state.tableData} 
               columns={this.state.columns} 
               //className="display"
               className="table table-striped table-bordered"
               options={this.props.options}>

               {this.props.thead}

            </DataTable>                      
      );    	
   }

}
