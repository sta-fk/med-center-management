import React from 'react';
import PriceList from '../../components/PriceList/List/List';
import NavigationPriceList from '../../components/PriceList/Navigation/NavList';
import axios from 'axios';
import { FailLoading, Loading } from '../../components/Loader';
import { MENU_MOCK } from '../../constants';

const RES_DATA = MENU_MOCK;

class PriceListContainer extends React.Component {
   state = {
      rows: null,
      priceList: null,
      windowHeight: window.innerHeight,
      windowWidth: window.innerWidth,
      state: { error: null, isLoaded: false },
   };

   getPriceList = () => {
      axios.get(`/api/price-list`)
         .then((response) => {
            this.setState({ priceList: response.data });
            this.setState({ state: { error: null, isLoaded: true } });
         })
         .catch((error) => {
            this.setState({ state: { error: error, isLoaded: true } });
         })
   }

   handleResize = (e) => {
      this.setState({
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth
      }, () => {
         if (this.state.windowWidth > 810) {
            this.reset();
         };
      });
   }

   componentDidMount() {
      window.addEventListener('resize', this.handleResize)
      this.getPriceList()
   }

   componentWillUnmount() {
      window.removeEventListener('resize', this.handleResize)
   }

   update = (value) => {
      this.setState({
         rows: value
      })
   }

   reset = () => {
      this.setState({
         rows: null
      })
   }


   render() {
      if (this.state.state.error) {
         return <FailLoading />;
      } else if (!this.state.state.isLoaded) {
         return <Loading />;
      } else {
         this.checkWidthForMenu(this.state.windowWidth);
         return <div className='price-list block'>
            {this.state.windowWidth > 810
               && <NavigationPriceList menu={this.state.priceList} updatePriceList={this.update} resetPriceList={this.reset} />
            }

            <PriceList rows={this.state.rows} width={this.state.windowWidth} />
         </div >;
      }
   }

   checkWidthForMenu = (width) => {
      if (width <= 810) {
         this.state.rows = this.state.priceList;
      }
   }
}

export default PriceListContainer;
