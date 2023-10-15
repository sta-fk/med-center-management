import React from 'react';
import DepartmentItem from './DepartmentItem';
import './department-row-media.scss';

function DepartmentsRow({ departments }) {
   return <section className='content departments row'>
      {departments.map((item, i) => (
         <DepartmentItem item={item} key={i} />
      ))}
   </section>;
}

export default DepartmentsRow;
