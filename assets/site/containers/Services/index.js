import React, { useState } from 'react';
import ServicesContainer from './Services';
import SearchContainer from '../Search';
import LocalStorage from '../../components/LocalStorage';
import './index.scss';

function Content({ itemsInRow }) {
   const [department, setDepartment] = useState(LocalStorage.getReferrer());
   const [limit, setLimit] = useState(1);

   const updateLimit = value => {
      setLimit(value)
   }

   const [next, setNext] = useState(1);

   const handleMoreImage = () => {
      setNext(next + 1);
   };

   return <section className='content s-department container'>
      <SearchContainer title={department.name} isServiceSearch={true} isEmployeeSearch={false} departmentId={department.id} />
      <ServicesContainer services={department.items} itemsInRow={itemsInRow} next={next} updateLimit={updateLimit} departmentSlug={department.slug} />
      {next < limit
         && <button className='default btn--small' onClick={handleMoreImage}>
            <span className='btn__link'>
               Більше
            </span>
         </button>}
   </section>;
}

export default Content;
