import React from 'react';

function DepartmentItem(props) {
   return <div className={props.active ? 'department item active' : 'department item'}>
      <span className='name'>
         {props.name}
      </span>
      <span className='arrow'>
         &nbsp;&#8594;
      </span>
   </div>;
}

export default DepartmentItem;
