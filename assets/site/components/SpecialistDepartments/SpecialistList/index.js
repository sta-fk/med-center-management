import React from 'react';
import SpecialistRow from './SpecialistRow';
import './index.scss';

class SpecialistList extends React.Component {
   constructor(props) {
      super(props);

      this.state = {
         groupedSpecialists: [],
         currentDepartment: null,
         itemsInRow: null,
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth,
         scrollPosition: 0,
      };
   }

   handleResize = (e) => {
      this.setState({
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth
      });
   }

   handleScroll = () => {
      const position = window.pageYOffset;
      this.setState({
         scrollPosition: position,
      });
   };

   componentDidMount() {
      window.addEventListener('resize', this.handleResize)
      window.addEventListener('scroll', this.handleScroll, { passive: true })
   }

   componentWillUnmount() {
      window.removeEventListener('resize', this.handleResize)
      window.removeEventListener('scroll', this.handleScroll)
   }

   render() {
      this.checkWidthForMenu(this.state.windowWidth);
      return <section className='content specialists list'>
         {this.props.specialists
            && this.groupItemsInRows(this.props.specialists, this.props.departmentId)}
         {this.state.groupedSpecialists
            && this.state.groupedSpecialists.map((item, i) => (
               <SpecialistRow key={i} data={item} departmentSlug={this.props.departmentSlug} departmentId={this.props.departmentId} departmentName={this.props.departmentName} />
            ))}
         {this.state.scrollPosition > 600
            && <div className='to-top' onClick={() => this.handleClick()}>&#8593;</div>}
      </section>;
   }

   handleClick = () => {
      window.scrollTo({
         top: 0,
         left: 0,
         behavior: "smooth"
      });
   }

   groupItemsInRows = (items, id) => {
      if (this.state.currentDepartment !== id) {
         this.state.currentDepartment = id;
         this.state.groupedSpecialists = [];
      }

      for (let i = 0; i < items.length; i += this.state.itemsInRow)
         this.state.groupedSpecialists.push(items.slice(i, i + this.state.itemsInRow));
   }

   checkWidthForMenu = (width) => {
      this.state.itemsInRow = 3;
      if (width <= 1366) {
         this.state.itemsInRow = 2;
      }

      if (width <= 1000) {
         this.state.itemsInRow = 1;
      }

      this.state.groupedSpecialists = [];
   }
}

export default SpecialistList;
