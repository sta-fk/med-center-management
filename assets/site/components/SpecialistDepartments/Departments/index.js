import React from 'react';
import DepartmentItem from './Department';
import './index.scss';

class DepartmentNavigation extends React.Component {
   constructor(props) {
      super(props);

      this.state = {
         data: this.props.data,
         choosenDepartment: null,
      };
   }

   componentDidMount() {
      if (this.state.data) {
         this.state.choosenDepartment = this.state.data[0].id
      }

      if (this.state.choosenDepartment !== null && this.state.data) {
         const i = this.state.choosenDepartment;
         const item = this.state.data[0];
         <span key={i}>
            {this.props.updateSpecialistList(item.items, item.id, item.slug, item.name)}
            <DepartmentItem key={i} id={i} name={item.name} active={item.id === this.state.choosenDepartment} />
         </span>
      }
   }

   render() {
      return <section className='content specialists departments'>
         <nav>
            {this.state.data
               && this.state.data.map((item, i) => (
                  <span key={i} onClick={() => this.getSpecialistList(item.items, item.slug, item.id, item.name)}>
                     <DepartmentItem key={i} id={i} name={item.name} active={item.id === this.state.choosenDepartment} />
                  </span>
               ))}
         </nav>
      </section >;
   }

   getSpecialistList = (items, slug, id, name) => {
      if (this.state.choosenDepartment !== id) {
         this.state.choosenDepartment = id;
         { this.props.updateSpecialistList(items, id, slug, name) }
      }
   }
}

export default DepartmentNavigation;
