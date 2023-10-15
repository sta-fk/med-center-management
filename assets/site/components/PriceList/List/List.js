import React from 'react';
import ListItem from './ListItem';
import './list-media.scss';

const HEADER = { name: 'Перелік послуг', code: 'Код', price: 'Ціна ' };

function PriceList(props) {
   return <section className='content price-list list'>
      <ListItem row={HEADER} isHeader={true} />
      {props.width > 810
         && props.rows
         && props.rows.map((item, i) => (
            <ListItem row={item} key={i} />
         ))}
      {props.width <= 810
         && props.rows
         && props.rows.map((item, i) => (
            <ListItem row={item} key={i} isCategory={item.items && true} isRootCategory={true} />
         ))}
   </section>;
}

export default PriceList;
