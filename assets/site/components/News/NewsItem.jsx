import React from 'react';
import parse from "html-react-parser";
import { TEXT_IMG_ALT_TEXT } from '../../translations';
import { NavLink } from 'react-router-dom';
import { HOME_URL } from '../../routes';

function NewsItem({ first, news }) {
   return (
      <div className='card' id={first ? 'first' : ''}>
         <div className='header'>
            <h3>{news.name}</h3>
            <span className='media'>
               <img alt={TEXT_IMG_ALT_TEXT} id='icon' src={require(`/assets/site/public/news/${news.icon}.png`)} />
            </span>
         </div>
         <div className='body'>
            <div className='content'>{parse(news.body)}</div>
         </div>
         {/* <div className='btn'>
            <NavLink to={HOME_URL} className='link'>
               Деталі &#8594;
            </NavLink>
         </div> */}
      </div>
   )
}

export default NewsItem;
