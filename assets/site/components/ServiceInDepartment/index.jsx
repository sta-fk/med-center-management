import React from 'react';
import { NavLink } from 'react-router-dom';
import parse from "html-react-parser";
import './index.scss';
import { PRICE_LIST_URL } from '../../routes';
import { TEXT_IMG_ALT_TEXT } from '../../translations';

const GO_TO_PRICE_BTN_TEXT = 'До листу цін';

function Service({ item, departmentSlug }) {
   const getImage = () => {
      try {
         return <img alt={TEXT_IMG_ALT_TEXT} id='s-img' src={require(`/assets/site/public/services/${item.slug}.png`)} />
      } catch {
         return <img alt={TEXT_IMG_ALT_TEXT} id='s-img' src={require(`/assets/site/public/departments/${departmentSlug}-01.png`)} />
      }
   }
   return (
      <div className='content service-item'>
         <div className='s-media'> {getImage()} </div>
         <h1>{item.name}</h1>
         <div className='s-desc'>{parse(item.details)}</div>
         <div className='s-btn--more'>
            <NavLink to={PRICE_LIST_URL} className='link'>
               {GO_TO_PRICE_BTN_TEXT} &#8594;
            </NavLink>
         </div>
      </div>
   )
}

export default Service;
