import React from 'react';
import './nav-root-media.scss';

function NavRoot(props) {
   return (
      <div className={props.active ? 'root active' : 'root'}>
         <span className='name'>
            {props.name}
         </span>
         <span className='arrow'>
            &nbsp;{(props.changeArrow && props.active) ? '↓' : '→'}
         </span>
      </div>
   )
}

export default NavRoot;
