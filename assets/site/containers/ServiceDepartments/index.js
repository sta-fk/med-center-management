import React from 'react';
import axios from 'axios';
import SearchContainer from '../Search';
import DepartmentsContainer from './ServiceDepartmentsContainer';
import { FailLoading, Loading } from '../../components/Loader';
import './index.scss';

class Content extends React.Component {
   constructor(props) {
      super(props);

      this.state = {
         limit: 5,
         departments: [],
         state: { error: null, isLoaded: false },
         page: 1,
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth,
         totalPages: 1,
      };
   }

   handleResize = (e) => {
      this.setState({
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth
      });
   }

   getLimitsByWidth = (width) => {
      this.state.itemsInRow = 5;

      if (width <= 976) {
         this.state.itemsInRow = 4;
      }

      if (width <= 576) {
         this.state.itemsInRow = 2;
      }
   }

   componentWillUnmount() {
      window.removeEventListener('resize', this.handleResize)
   }

   componentDidMount() {
      window.addEventListener('resize', this.handleResize)
      this.getDepartments()
   }

   getDepartments = () => {
      axios.get(`/api/departments/services?page=${this.state.page}&limit=${this.state.limit}`)
         .then((response) => {
            this.setState({ departments: [...this.state.departments, ...response.data.items] });
            this.setState({ totalPages: response.data.totalPages });
            this.setState({ state: { error: null, isLoaded: true } });
         })
         .catch((error) => {
            this.setState({ state: { error: error, isLoaded: true } });
         })
   }

   render() {
      if (this.state.state.error) {
         return <FailLoading />;
      } else if (!this.state.state.isLoaded) {
         return <Loading />;
      } else {
         this.getLimitsByWidth(this.state.windowWidth);
         return (
            <div className='container departments-container'>
               <SearchContainer isServiceSearch={true} isEmployeeSearch={false} departmentId={null} />
               <DepartmentsContainer departments={this.state.departments} itemsInRow={this.state.itemsInRow} />
               {this.state.totalPages !== this.state.page
                  && <button className='default btn--small' onClick={() => this.setState({ page: this.state.page + 1 }, () => { this.getDepartments() })}>
                     <span className='btn__link'>
                        {!this.state.state.isLoaded ? <Loading /> : 'Більше'}
                     </span>
                  </button>}
            </div>
         );
      }
   }
}

export default Content;
