import React from 'react';
import NewsItem from './NewsItem';

function NewsRow({ news, equalItems }) {
   var items = [];
   for (let i = 0; i < news.length; i++) {
      items.push(<NewsItem key={i} news={news[i]} first={(i === 0 && equalItems) ?? true} />);
   }

   return <section className='content news row'>
      {items}
   </section>;
}

export default NewsRow;
