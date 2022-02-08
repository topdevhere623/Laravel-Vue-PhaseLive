export default {
    methods: {
        getClientToken() {
            return new Promise((resolve, reject) => {
                axios.get('/api/braintree/client_token').then(response => {
                    resolve(response.data.token);
                }).catch(error => {
                    console.log(error);
                    reject(error);
                });
            });
        }
    }
}