import React from 'react';
import DepartmentNavigation from '../../components/SpecialistDepartments/Departments';
import SpecialistList from '../../components/SpecialistDepartments/SpecialistList';
import axios from 'axios';
import { SPECIALISTS_MOCK } from '../../constants';
import { FailLoading, Loading } from '../../components/Loader';

const RES_DATA = SPECIALISTS_MOCK;

class SpecialistsContainer extends React.Component {
   constructor(props) {
      super(props);

      this.state = {
         choosenDepartment: null,
         choosenDepartmentSlug: null,
         choosenDepartmentName: null,
         needsSpecialists: null,
         employees: null,
         state: { error: null, isLoaded: false },
      };
   }

   getEmployeesByDepartments = () => {
      axios.get(`/api/employees`)
         .then((response) => {
            this.setState({ employees: response.data });
            this.setState({ state: { error: null, isLoaded: true } });
         })
         .catch((error) => {
            this.setState({ state: { error: error, isLoaded: true } });
         })
   }

   componentDidMount() {
      this.getEmployeesByDepartments();
   }

   update = (specialists, departmentId, departmentSlug, departmentName) => {
      this.setState({
         needsSpecialists: specialists,
         choosenDepartment: departmentId,
         choosenDepartmentSlug: departmentSlug,
         choosenDepartmentName: departmentName,
      })
   }

   render() {
      if (this.state.state.error) {
         return <FailLoading />;
      } else if (!this.state.state.isLoaded) {
         return <Loading />;
      } else {
         return <div className='sp-department-block'>
            <DepartmentNavigation data={this.state.employees} updateSpecialistList={this.update} />
            <SpecialistList departmentName={this.state.choosenDepartmentName} departmentSlug={this.state.choosenDepartmentSlug} departmentId={this.state.choosenDepartment} specialists={this.state.needsSpecialists} />
         </div>
      }
   };
}

export default SpecialistsContainer;
