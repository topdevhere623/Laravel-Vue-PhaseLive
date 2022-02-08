import Cookies from 'js-cookie';

import store from 'store';

function CartManager()
{
    /**
     * Check the server and the cookie to see if there is any cart data.
     *
     * @returns {Promise<any>}
     */
    this.load = () =>
    {
        return new Promise((resolve, reject) => {
            // Try first to load from server
            this.loadFromServer()
                .then(data => {
                    resolve(data)
                })
                // Empty data received from server, check cookie
                .catch(() => {
                    this.loadFromCookie()
                        .then(data => {
                            resolve(data);
                        })
                        .catch(() => {
                            reject();
                        });
                });
        });

    };

    /**
     * Set the phase_cart cookie to store
     */
    this.saveCookie = () =>
    {
        setTimeout(() => {
            let storeItems = store.state.cart.items;
            let toSave = [];
            for(let i = 0; i < storeItems.length; i++) {
                toSave.push({
                    id: storeItems[i].id,
                    type: storeItems[i].type,
                    format: (storeItems[i].format ? storeItems[i].format : 'mp3'),
                })
            }
            Cookies.set('phase_cart', toSave);
        }, 0);
    };

    /**
     * Add an item to a logged in users cart.
     *
     * @param item
     */
    this.saveItemToServer = (item) => {
        axios.post('/api/cart/item/add', {
            type: item.type,
            id: item.id,
            format: item.format,
        });
    };

    /**
     * Check the server for logged in users cart information
     *
     * @returns {Promise<any>}
     */
    this.loadFromServer = () => {
        return new Promise((resolve, reject) => {
            axios.get('/api/cart/item/list').then(response => {
                if(response.data) {
                    resolve(this.setFormatProperly(response.data));
                } else {
                    reject();
                }
            });
        });
    };

    /**
     * Check the cookie for cart data and query the server to get item information
     *
     * @returns {Promise<any>}
     */
    this.loadFromCookie = () => {
        let cart = Cookies.getJSON('phase_cart');
        return new Promise((resolve, reject) => {
            if(cart) {
                axios.post('/api/cart/guest/details', { items: cart }).then(response => {
                    // Loop through the cookie data and response data and set the format correctly on the server data
                    // according the the cookie
                    for(let i = 0; i < response.data.length; i++) {
                        for(let x = 0; x < cart.length; x++) {
                            if(response.data[i].id === cart[x].id && response.data[i].type === cart[x].type) {
                                response.data[i].format = cart[x].format;
                            }
                        }
                    }
                    resolve(response.data);
                });
            } else {
                reject()
            }
        });
    };

    /**
     * Update the saved format of an item in the cart (mp3/wav)
     *
     * @param item
     * @param format
     */
    this.changeItemFormat = (item, format) => {
        // Update item on server
        axios.post('/api/cart/item/change', {
            id: item.id,
            type: item.type,
            format: format,
        });
        // Update item in cookie
        this.saveCookie();
    };

    /**
     * Data from the server returns the format as a sub-property of a 'pivot' property. Move it to the correct place in the
     * object
     * @param data
     * @returns {*}
     */
    this.setFormatProperly = (data) => {
        for(let i = 0; i < data.length; i++) {
            if(data[i].pivot) {
                data[i].format = data[i].pivot.download_format
                data[i].pivot = undefined;
            }
        }
        return data;
    };

    /**
     * Remove the cart cookie
     */
    this.reset = () => {
        Cookies.remove('phase_cart')
    }
}
export default new CartManager();