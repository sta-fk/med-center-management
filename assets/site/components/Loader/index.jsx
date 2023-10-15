import React from 'react';
import './index.scss';

export function Loading() {
   return <div className='loading'>
      <div className='proccess'></div>
   </div>;
}

export function FailLoading() {
   return <div className='loading'>
      <h1 className='error'>Вибачте, сервер втомився</h1>
   </div>;
}
