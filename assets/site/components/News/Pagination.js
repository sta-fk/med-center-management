import React from 'react';

function NewsPagination({ currentPage, totalPages, paginate, next, prev }) {
   var pageNumbers = [];
   for (let i = 1; i <= totalPages; i++) {
      pageNumbers.push(i);
   }
   return <div className='content news-pagination'>
      <div className='btn' onClick={() => prev()}>&#8592;</div>&emsp;
      {totalPages >= 5
         ? pageNumbers.map(number => (
            (number <= (currentPage + 2) && number >= (currentPage - 2))
            && <div key={number} className={currentPage === number ? 'btn active' : 'btn'} onClick={() => paginate(number)}>{number}&emsp;</div>
         ))
         : pageNumbers.map(number => (
            <div key={number} className={currentPage === number ? 'btn active' : 'btn'} onClick={() => paginate(number)}>{number}&emsp;</div>
         ))}
      <div className='btn' onClick={() => next()}>&#8594;</div>&emsp;
   </div>;
}

export default NewsPagination;
