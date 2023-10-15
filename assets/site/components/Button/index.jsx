import React from 'react';
import { Link } from 'react-router-dom';
import './index.scss';

export function DefaultButton({ path, text }) {
   return (
      <button className='default btn'>
         <Link to={path} className='btn__link'>
            {text}
         </Link>
      </button>
   )
}

export function DefaultSmallButton({ path, text }) {
   return (
      <button className='default btn--small'>
         <Link to={path} className='btn__link'>
            {text}
         </Link>
      </button>
   )
}
