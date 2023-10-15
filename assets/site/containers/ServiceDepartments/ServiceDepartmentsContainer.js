import React from 'react';
import DepartmentsRow from '../../components/ServiceDepartments/DepartmentsRow';

function DepartmentsContainer({ departments, itemsInRow }) {
   const groupDepartmentRows = items => {
      var groupedItems = [];
      for (let i = 0; i < items.length; i += itemsInRow)
         groupedItems.push(items.slice(i, i + itemsInRow));

      var rows = [];
      for (let i = 0; i < groupedItems.length; i++) {
         rows.push(<DepartmentsRow key={i} departments={groupedItems[i]} />);
      }

      return rows;
   }

   return <div className='departments-block'>
      {groupDepartmentRows(departments)}
   </div>;
}

export default DepartmentsContainer;
