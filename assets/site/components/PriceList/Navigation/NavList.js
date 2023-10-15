import React from 'react';
import NavRoot from './NavRoot';
import NavParent from './NavParent';
import NavChild from './NavChild';
import './nav-list-media.scss';

class NavigationPriceList extends React.Component {
   constructor(props) {
      super(props);

      this.state = {
         data: this.props.menu,
         displayParent: null,
         displayChild: null,
         displayExtraChild: null,
         displayLastChild: null,
         updatedRow: null,
         row: null
      };
   }

   componentDidMount() {
      try {
         if (this.state.data) {
            this.expandChild(0, this.state.data[0].items[0].items);
            this.setState({ displayParent: 0, displayChild: 0 });
         }
      } catch (error) {
         console.log(error);
      }
   }

   render() {
      return (
         <section className='content price-list'>
            <nav>
               {this.state.data.map((item, i) => (
                  <span key={i} onClick={() => this.expandParent(i)}>
                     <NavRoot key={i} id={i} name={item.name} items={item.items}
                        active={i === this.state.displayParent} changeArrow={typeof item.items[0].items !== 'undefined'} />
                     {i === this.state.displayParent &&
                        item.items &&
                        this._renderParent(item.items)}
                  </span>
               ))}
            </nav>
         </section>
      );
   }

   _renderParent = items => {
      const result = items.map((item, i) => {
         return <span key={i} onClick={() => this.expandChild(i, item.items)}>
            {item.items[0]
               && <NavParent key={i} id={i} name={item.name} items={item.items}
                  active={i === this.state.displayChild} changeArrow={typeof item.items[0].items !== 'undefined'} />}
            {(i === this.state.displayChild
               && item.items)
               && this._renderChild(item.items)}
         </span>;
      });

      return result;
   };

   _renderChild = items => {
      const result = items.map((item, i) => {
         return <span key={i}>
            {(typeof item.items !== 'undefined')
               && <span onClick={() => this.expandExtraChild(i, item.items)}>
                  <NavChild key={i} id={i} name={item.name} items={item.items}
                     active={i === this.state.displayExtraChild} changeArrow={typeof item.items[0].items !== 'undefined'} />
                  {i === this.state.displayExtraChild
                     && item.items
                     && this._renderLastChild(item.items)
                  }
               </span>
            }
         </span>
      });

      return result;
   };


   _renderLastChild = items => {
      const result = items.map((item, i) => {
         return <span key={i}>
            {(typeof item.items !== 'undefined')
               && <span onClick={() => this.expandLastChild(i, item.items)}>
                  <NavChild key={i} id={i} name={item.name} items={item.items}
                     active={i === this.state.displayLastChild} changeArrow={typeof item.items[0].items !== 'undefined'} />
               </span>
            }
         </span>
      });

      return result;
   };

   needsRowUpdate = item => {
      this.setState({
         row: item
      }, () => {
         { this.props.updatePriceList(this.state.row) }
      });
   }

   expandParent = id => {
      if (this.state.displayParent !== id) {
         this.setState({
            displayChild: null,
            displayExtraChild: null,
            displayLastChild: null,
         });
         { this.props.resetPriceList() }
      }

      this.setState({
         displayParent: id,
      });
   };

   expandChild = (id, items) => {
      if (this.state.displayChild !== id) {
         this.setState({
            displayExtraChild: null,
            displayLastChild: null,
         });
         { this.props.resetPriceList() }
      }

      this.setState({
         displayChild: id,
      }, () => {
         items.map((item, i) => {
            if (typeof item.items === 'undefined') {
               this.needsRowUpdate(items)
            }
         });
      })
   };

   expandExtraChild = (id, items) => {
      if (this.state.displayExtraChild !== id) {
         this.setState({
            displayLastChild: null,
         });
         { this.props.resetPriceList() }
      }

      this.setState({
         displayExtraChild: id,
      }, () => {
         items.map((item, i) => {
            if (typeof item.items === 'undefined') {
               this.needsRowUpdate(items)
            }
         });
      })
   };

   expandLastChild = (id, items) => {
      this.setState({
         displayLastChild: id
      }, () => {
         items.map((item, i) => {
            if (typeof item.items === 'undefined') {
               this.needsRowUpdate(items)
            } else {
               this._renderLastChild(items);
            }
         });
      })
   };
}

export default NavigationPriceList;
