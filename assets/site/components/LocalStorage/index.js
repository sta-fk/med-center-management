import React from 'react';

class LocalStorage {
   static setUser = (id) => {
      localStorage.setItem('user', id)
   }

   static getUser = () => {
      return localStorage.getItem('user')
   }

   static removeUser = () => {
      return localStorage.removeItem('user');
   }

   static getReferrer = () => {
      return JSON.parse(localStorage.getItem('referrer'));
   }

   static setReferrer = (info) => {
      return localStorage.setItem('referrer', JSON.stringify(info));
   }
}

export default LocalStorage;
