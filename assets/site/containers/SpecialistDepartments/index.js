import React from 'react';
import SearchContainer from '../Search';
import SpecialistsContainer from './SpecialistDepartmentsContainer';
import './index.scss';

const SEARCH_HEADER = 'Відділення';

function Content() {
   return <section className='content sp-department container'>
      <SearchContainer title={SEARCH_HEADER} isServiceSearch={false} isEmployeeSearch={true} departmentId={null} />
      <SpecialistsContainer />
   </section>;
}

export default Content;
