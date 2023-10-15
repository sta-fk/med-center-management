import React from 'react';
import SpecialistItem from './Specialist';

function SpecialistRow({ data, departmentSlug, departmentId, departmentName }) {
   return <div className='specialists-row'>
      {data
         && data.map((item, i) => (
            <SpecialistItem key={i} specialist={item} departmentSlug={departmentSlug} departmentId={departmentId} departmentName={departmentName} />
         ))}
   </div>
}

export default SpecialistRow;

