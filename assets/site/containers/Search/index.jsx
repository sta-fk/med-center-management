import React from 'react';
import Search from '../../components/Search';
import './index.scss';

const SEARCH_BLOCK_TITLE = 'Обери відділення послуг або здійсни пошук';

class SearchContainer extends React.Component {
   constructor(props) {
      super(props);

      this.state = {
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth,
         overlayHeight: document.body.scrollHeight > window.innerHeight ? document.body.scrollHeight : window.innerHeight,
      };
   }

   componentWillUnmount() {
      window.removeEventListener('resize', this.handleResize)
   }

   componentDidMount() {
      window.addEventListener('resize', this.handleResize)
   }

   handleResize = (e) => {
      this.setState({
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth,
         overlayHeight: document.body.scrollHeight > window.innerHeight ? document.body.scrollHeight : window.innerHeight,
      });
   }

   render() {
      return <div className='container search-container'>
         <h1>{this.props.title ? this.props.title : SEARCH_BLOCK_TITLE}</h1>
         <Search overlayHeight={this.state.overlayHeight} isServiceSearch={this.props.isServiceSearch} isEmployeeSearch={this.props.isEmployeeSearch} departmentId={this.props.departmentId} />
      </div>;
   }
}

export default SearchContainer;
