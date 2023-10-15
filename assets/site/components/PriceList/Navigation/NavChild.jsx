import React from 'react';
import './nav-child-media.scss';

function NavChild(props) {
   return <div className={props.active ? 'child active' : 'child'}>
      <span className='name'>
         {props.name}
      </span>
      <span className='arrow'>
         &nbsp;{(props.changeArrow && props.active) ? '↓' : '→'}
      </span>
   </div>;
}

export default NavChild;
