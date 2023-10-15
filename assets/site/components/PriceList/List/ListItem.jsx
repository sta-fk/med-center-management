import React from 'react';
import PriceList from './List';
import './list-item-media.scss';

function ListItem(props) {

   return <div className={PriceListItemClass(props)}>
      <div className={props.isCategory ? 'name category' : 'name'}>{props.row.name}</div>
      {props.row.code
         && <div className='code'>{props.row.code}</div>}
      {props.row.price
         && <div className='price'>{props.row.price} {(!props.isHeader && !props.isCategory) && 'грн'}</div>}

      {props.row.items
         && props.row.items.map((item, i) => (
            <ListItem row={item} key={i} isCategory={typeof props.row.items[0].items !== 'undefined'} />
         ))}
   </div>;
}

function PriceListItemClass(props) {
   if (props.isHeader) {
      return 'row item header';
   }

   if (props.isRootCategory) {
      return 'row item root-category';
   }

   return 'row item';
}

export default ListItem;
