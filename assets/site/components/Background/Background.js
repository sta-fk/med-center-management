class Background {
   static getHomeBackground = (id) => {
      document.body.className = 'base';
   }

   static getBaseBackground = () => {
      document.body.className = 'home-page';
   }
}

export default Background;
