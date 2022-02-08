export default {
  // data() {
  //   return {
  //     paymentMethod: null
  //   }
  // },
  //
  // created() {
  //   this.getPaymentMethod()
  // },

  methods: {
    getClientSecret() {
      return new Promise((resolve, reject) => {
        axios.get('/api/payment/client_secret').then(response => {
          resolve(response.data.intent)
        }).catch(error => {
          console.log(error)
          reject(error)
        })
      })
    },

    // getPaymentMethod() {
    //   axios.get('/api/payment/method').then(response => {
    //     this.paymentMethod = response.data
    //   }).catch(error => {
    //     console.error(error)
    //   })
    // },
  },
}
