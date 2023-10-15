import React from 'react';
import { useEffect } from 'react';
import { useState } from 'react';
import ServicesRow from './ServicesRow';

function ServicesContainer({ services, itemsInRow, next, updateLimit, departmentSlug }) {
   useEffect(() => {
      updateLimit(groupDepartmentRows(services).length);
   });

   const groupDepartmentRows = items => {
      items = items.filter((value) => {
         return value.details !== null;
      });
      var groupedItems = [];
      for (let i = 0; i < items.length; i += itemsInRow)
         groupedItems.push(items.slice(i, i + itemsInRow));

      return groupedItems;
   }

   const getRows = items => {
      var rows = [];
      for (let i = 0; i < next; i++) {
         rows.push(<ServicesRow key={i} services={items[i]} departmentSlug={departmentSlug} />);
      }

      return rows;
   }

   return <div className='s-department-block'>
      {getRows(groupDepartmentRows(services))}
   </div>;
}

export default ServicesContainer;
