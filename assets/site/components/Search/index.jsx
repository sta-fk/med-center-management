import React, { useState } from 'react';
import { TEXT_IMG_ALT_TEXT } from '../../translations';
import { FailLoading, Loading } from '../Loader';
import { Link } from 'react-router-dom';
import axios from 'axios';
import LocalStorage from '../LocalStorage';
import './index.scss';

function Search({ overlayHeight, isServiceSearch, isEmployeeSearch, departmentId }) {
   const SEARCH_TITLE = 'Введіть запит...';
   const DETAILS = 'Деталі';
   const [searchResult, setSearchResult] = useState([]);

   const getImage = (item) => {
      try {
         return <img id='img' alt={TEXT_IMG_ALT_TEXT}
            src={require(`/assets/site/public/specialists/${item.employeeSlug}.png`)} />
      } catch {
         return <img alt={TEXT_IMG_ALT_TEXT} id='sp__img'
            src={require(`/assets/site/public/specialist_mock.png`)} />
      }
   }

   const handleChangeSearch = async (event) => {
      switch (true) {
         case isServiceSearch:
            handleSearch('services', 'serviceName', event.target.value)
            break
         case isEmployeeSearch:
            handleSearch('employees', 'employeeName', event.target.value)
            break
      }
   }

   const handleSearch = async (typeSearch, key, value) => {
      try {
         let department = departmentId ? `&departmentId=${departmentId}` : '';
         const response =
            await axios.get(
               `/api/search/${typeSearch}?${key}=${value}${department}`
            );

         if (!response) {
            return <Loading />;
         }
         setSearchResult(response.data);
      } catch (error) {
         if (!error?.response) {
            return <FailLoading />
         }
      };
   }

   return <section className='content'>
      {searchResult.length > 0 && <div className='overlay' style={{ height: overlayHeight }} onClick={() => { setSearchResult([]) }}></div>}
      {/* {searchResult.length > 0 && <div className='overlay' onClick={() => { setSearchResult([]) }}></div>} */}
      <div className='search'>
         <input className='search__input' type='text' placeholder={SEARCH_TITLE} onChange={e => handleChangeSearch(e)} />
         <div className='search__icon'>
            <img alt={TEXT_IMG_ALT_TEXT} id='search__img' src={require('/assets/site/public/search-icon.png')} />
         </div>
         {searchResult.length > 0 && <div className='result'>
            {isServiceSearch && <div className='item__service'>
               <div className='header name'>Назва</div>
               <div className='header price'>Ціна</div>
            </div>}
            {isServiceSearch && searchResult.map((item, i) => (
               <div key={i} className='item__service'>
                  <div className='name'>{item.name}</div>
                  <div className='price'>{item.price} грн</div>
               </div>
            ))}
            {isEmployeeSearch && searchResult.map((item, i) => (
               <div key={i} className='item__specialist'>
                  <div className='media'>
                     {getImage(item)}
                  </div>
                  <div className='info'>
                     <div className='fullname'>{item.firstName}&nbsp;{item.lastName}</div>
                     <div className='brief'>{item.brief}</div>
                     <Link to={`/specialists/${item.departmentSlug}/${item.employeeSlug}`}
                        className='link'
                        onClick={() => LocalStorage.setReferrer({ specialistId: item.employeeId, departmentId: item.departmentId, departmentName: item.departmentName, specialistName: (item.firstName + ' ' + item.lastName) })}
                        onMouseDown={() => LocalStorage.setReferrer({ specialistId: item.employeeId, departmentId: item.departmentId, departmentName: item.departmentName, specialistName: (item.firstName + ' ' + item.lastName) })}
                        onFocus={() => LocalStorage.setReferrer({ specialistId: item.employeeId, departmentId: item.departmentId, departmentName: item.departmentName, specialistName: (item.firstName + ' ' + item.lastName) })}>
                        {DETAILS}&nbsp;&#8594;
                     </Link>
                  </div>
               </div>
            ))}
         </div>
         }
      </div>
   </section>;
}
export default Search;
