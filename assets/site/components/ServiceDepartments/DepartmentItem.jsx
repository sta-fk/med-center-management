import React from 'react';
import { Link } from 'react-router-dom';
import { TEXT_IMG_ALT_TEXT } from '../../translations';
import LocalStorage from '../LocalStorage';
import './department-item-media.scss';

function DepartmentItem({ item }) {
   return (
      <Link className='card'
         to={`/departments/${item.slug}/services`}
         state={item}
         onClick={() => LocalStorage.setReferrer(item)}
         onMouseDown={() => LocalStorage.setReferrer(item)}
         onFocus={() => LocalStorage.setReferrer(item)}>
         <div className="cd__body">
            <img alt={TEXT_IMG_ALT_TEXT} id='cd__img' src={require(`/assets/site/public/departments/${item.slug}-01.png`)} />
         </div>
         <div className="cd__title">
            <p>{item.name}
            </p>
         </div>
      </Link>
   )
}

export default DepartmentItem;
