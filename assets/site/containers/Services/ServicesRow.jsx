import React from 'react';
import Service from '../../components/ServiceInDepartment';
import { NavLink } from 'react-router-dom';

function ServicesRow({ services, departmentSlug }) {
   return (
      <div className='s-row'>
         {services
            && services.map((item, i) => (
               item.details &&
               <Service item={item} key={i} departmentSlug={departmentSlug} />
            ))}
         {/* {!services
            && <div className='s-reference'>
               <h3>Додаткова інформація за послугами обраного відділення відсутня, <br />зверніться до каталогу цін</h3>
               <p>Дякуємо, що обираєте нас!</p>
               <div className='s-btn-pricelist'>
                  <NavLink to={PRICE_LIST_URL} className='link'>
                     Перейти до листу цін &#8594;
                  </NavLink>
               </div>
            </div>} */}
      </div>
   )
}

export default ServicesRow;
