import * as React from "react";
import { render } from 'react-dom';
import { Admin, Resource } from 'react-admin';
import restProvider from 'ra-data-simple-rest';
import { EmployeeList, EmployeeCreate, EmployeeEdit, EmployeeIcon } from './admin/pages/Employee';
import './admin/styles/styles.scss';

render(
   <Admin dataProvider={restProvider('/admin')}>
      <Resource name="employees" list={EmployeeList} edit={EmployeeEdit} create={EmployeeCreate} icon={EmployeeIcon} />
   </Admin>,
   document.getElementById('admin')
);
