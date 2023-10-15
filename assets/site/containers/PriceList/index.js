import React from 'react';
import SearchContainer from '../Search';
import PriceListContainer from './PriceListContainer';
import './index.scss';

const SEARCH_HEADER = 'Вартість послуг';

function Content() {
   return <section className='content price-list container'>
      <SearchContainer title={SEARCH_HEADER} isServiceSearch={true} isEmployeeSearch={false} departmentId={null} />
      <PriceListContainer />
   </section>;
}

export default Content;
