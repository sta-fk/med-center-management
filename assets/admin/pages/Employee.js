import * as React from 'react';
import {
   List, Datagrid, Edit,
   Create, SimpleForm, DateField,
   TextField, EditButton, TextInput,
   DateInput, useRecordContext, BooleanField, NullableBooleanInput
} from 'react-admin';
import BookIcon from '@mui/icons-material/Book';
export const EmployeeIcon = BookIcon;

export const EmployeeList = () => (
   <List>
      <Datagrid>
         <TextField source='id' />
         <TextField source='firstName' />
         <TextField source='lastName' />
         <DateField source='startDate' />
         <EditButton />
      </Datagrid>
   </List>
);

const EmployeeTitle = () => {
   const record = useRecordContext();
   return <span>Post {record ? `'${record.title}'` : ''}</span>;
};

export const EmployeeEdit = () => (
   <Edit title={<EmployeeTitle />}>
      <SimpleForm>
         <TextInput disabled source='id' />
         <TextInput source='employeeType' />
         <TextInput multiline source='employeeInfo.aboutMyself' />
         {/* <BooleanField source='isActive' label='Працює' /> */}
         <DateInput source='startDate' />
      </SimpleForm>
   </Edit>
);

export const EmployeeCreate = () => (
   <Create title='Create a Post'>
      <SimpleForm>
         <TextInput source='title' />
         <TextInput source='teaser' options={{ multiline: true }} />
         <TextInput multiline source='body' />
         <TextInput label='Publication date' source='published_at' />
         <TextInput source='average_note' />
      </SimpleForm>
   </Create>
);
