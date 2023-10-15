import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/Services';
import BackgroundResolver from '../../components/Background';
import LocalStorage from '../../components/LocalStorage';

class Services extends React.Component {
   constructor(props) {
      super(props);

      this.state = {
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth,
      };
   }

   handleResize = (e) => {
      this.setState({
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth
      });
   }

   checkWidthForMenu = (width) => {
      this.state.itemsInRow = 4;

      if (width <= 1366) {
         this.state.itemsInRow = 3;
      }

      if (width <= 976) {
         this.state.itemsInRow = 2;
      }
   }

   componentWillUnmount() {
      window.removeEventListener('resize', this.handleResize)
   }

   componentDidMount() {
      window.addEventListener('resize', this.handleResize)
   }

   render() {
      this.checkWidthForMenu(this.state.windowWidth);
      return (
         <div>
            <Helmet title={`Послуги - ${LocalStorage.getReferrer().name} | КЦ NoName`} />
            <Header />
            <Content itemsInRow={this.state.itemsInRow} />
            <Footer />
            <BackgroundResolver />
         </div>
      )
   }
}
export default Services;
