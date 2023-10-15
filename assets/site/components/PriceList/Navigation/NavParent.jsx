import React from 'react';
import './nav-parent-media.scss';


function NavParent(props) {
   return <div className={props.active ? 'parent active' : 'parent'}>
      <span className='name'>
         {props.name}
      </span>
      <span className='arrow'>
         &nbsp;{(props.changeArrow && props.active) ? '↓' : '→'}
      </span>
   </div>;
}

export default NavParent;
