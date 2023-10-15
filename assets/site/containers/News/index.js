import React, { useState, useEffect } from 'react';
import axios from 'axios';
import NewsRow from '../../components/News/NewsRow';
import NewsPagination from '../../components/News/Pagination';
import { FailLoading, Loading } from '../../components/Loader';
import './index.scss';
import { NEWS } from '../../constants';

class Content extends React.Component {
   constructor(props) {
      super(props);

      this.state = {
         news: null,
         groupedNews: null,
         state: { error: null, isLoaded: false },
         itemsInRow: null,
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth,
         equalItems: null,
         currentPage: 1,
         limit: 6,
      };
   }

   handleResize = (e) => {
      this.setState({
         windowHeight: window.innerHeight,
         windowWidth: window.innerWidth
      });
   }

   componentWillUnmount() {
      window.removeEventListener('resize', this.handleResize)
   }

   componentDidMount() {
      window.addEventListener('resize', this.handleResize)
      this.getNews()
   }

   render() {
      if (this.state.state.error) {
         return <FailLoading />;
      } else if (!this.state.state.isLoaded) {
         return <Loading />;
      } else {
         this.checkWidthForMenu(this.state.windowWidth);
         this.state.groupedNews = this.groupNewsInRows(this.state.news.items);
         // this.state.groupedNews = this.groupNewsInRows(NEWS.items);

         return <div className='container news-container'>
            {this.getNewsRows()}
            <NewsPagination currentPage={this.state.news.page} totalPages={this.state.news.totalPages} paginate={this.paginate} next={this.nextPage} prev={this.prevPage} />
         </div>;
      }
   }

   paginate = pageNumber => {
      this.state.currentPage = pageNumber;
      this.getNews();
   }

   nextPage = () => {
      if (this.state.currentPage < this.state.news.totalPages) {
         this.state.currentPage++;
         this.getNews();
      }
   }

   prevPage = () => {
      if (this.state.currentPage > 1) {
         this.state.currentPage--;
         this.getNews();
      }
   }

   groupNewsInRows = items => {
      var groupedItems = [];
      for (let i = 0; i < items.length; i += this.state.itemsInRow)
         groupedItems.push(items.slice(i, i + this.state.itemsInRow));

      return groupedItems;
   }

   checkWidthForMenu = width => {
      this.state.itemsInRow = 3;
      this.state.equalItems = false;

      if (width > 1366) {
         this.state.equalItems = true;
      }
      if (width <= 1080) {
         this.state.itemsInRow = 2;
      }
      if (width <= 576) {
         this.state.itemsInRow = 1;
      }
   }

   getNewsRows = () => {
      var rows = [];
      for (let i = 0; i < this.state.groupedNews.length; i++) {
         rows.push(<NewsRow key={i} news={this.state.groupedNews[i]} equalItems={this.state.equalItems} />);
      }

      return rows;
   }

   getNews = () => {
      axios.get(`/api/news?page=${this.state.currentPage}&limit=${this.state.limit}`)
         .then((response) => {
            this.setState({ news: response.data });
            this.setState({ state: { error: null, isLoaded: true } });
         })
         .catch((error) => {
            this.setState({ state: { error: error, isLoaded: true } });
         })
   }
}

export default Content;
