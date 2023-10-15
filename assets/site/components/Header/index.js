import React from 'react';
import axios from 'axios';
import { NavLink, Link } from 'react-router-dom';
import { FailLoading } from '../Loader';
import LocalStorage from '../LocalStorage';
import { HOME_URL, LOGIN_URL, NEWS_URL, PRICE_LIST_URL, SERVICE_DEPARTMENTS_URL, SPECIALISTS_BY_DEPARTMENTS_URL, PROFILE_URL, PROFILE_DECLARATION_URL } from '../../routes';
import './index.scss';

function Header() {
   return <header>
      <nav>
         <div className='items-management'>
            <div className='logo'>
               <NavLink to={HOME_URL} className='link'>
                  <div className='name'>NoName</div>
                  <div>clinic center</div>
               </NavLink>
            </div>
            <button className='js-main-dropdown-btn' onClick={showMainItems}>
               Меню
            </button>
         </div>
         <div id='js-id-main-dropdown' className='js-main-dropdown'>
            <div className='item'>
               <NavLink to={NEWS_URL} className='link'>Новини</NavLink>
            </div>
            <div className='item'>
               <NavLink to={SERVICE_DEPARTMENTS_URL} className='link'>Каталог</NavLink>
            </div>
            <div className='item'>
               <NavLink to={SPECIALISTS_BY_DEPARTMENTS_URL} className='link'>Спеціалісти</NavLink>
            </div>
            <div className='item'>
               <NavLink to={PRICE_LIST_URL} className='link'>Ціни</NavLink>
            </div>
            {LocalStorage.getUser()
               ? <div id='js-id-child-dropdown-btn' className='item' onClick={showChildItems}><span className='link'>Мій кабінет</span> </div>
               : <NavLink to={LOGIN_URL} className='item--login'>
                  Вхід
               </NavLink>
            }
            <div id='js-id-child-dropdown' className='js-child-dropdown'>
               <div className='item'>
                  <NavLink to={PROFILE_URL} className='link'>Профіль</NavLink>
               </div>
               <div className='item'>
                  <NavLink to={PROFILE_DECLARATION_URL} className='link'>Декларація</NavLink>
               </div>
               <div className='item'>
                  <Link to={HOME_URL} onClick={() => logoutUser()} className='link'> Вийти </Link>
               </div>
            </div>
         </div>
      </nav>
   </header>;
}

const showMainItems = () => {
   var x = document.getElementById('js-id-main-dropdown');
   var y = document.getElementById('js-id-child-dropdown');
   if (x.className === 'js-main-dropdown') {
      x.className += ' responsive';
   } else {
      x.className = 'js-main-dropdown';
      y.className = 'js-child-dropdown';
   }
}

const showChildItems = () => {
   var x = document.getElementById('js-id-child-dropdown');

   if (x.className === 'js-child-dropdown') {
      x.className += ' responsive';
   } else {
      x.className = 'js-child-dropdown';
   }
}

/**
 * <Link to={HOME_URL} onClick={() => logoutUser()} className='item--login'> Вийти </Link>
 */
const logoutUser = async () => {
   let response = await axios.get(`/api/logout`);

   if (response?.status === 200) {
      LocalStorage.removeUser();
      window.location.reload();
   } else {
      return <FailLoading />
   }
}

export default Header;
