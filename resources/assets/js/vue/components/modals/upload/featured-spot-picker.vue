<template>
    <div class="feature-date">
        <div class="date">
            <v-date-picker
                    ref="featuredDates"
                    v-model="date"
                    mode="multiple"
                    :available-dates="enabledDates"
                    :input-props="inputProps"
                    @input="updatePrice"
                    :masks="{input: 'DD/MM/YYYY'}"
            />
        </div>
        <span class="price">£{{ price }}</span>
    </div>
</template>

<script>
  import { ModalEvents } from '../../../event-bus'

  export default {
    name: 'featured-spot-picker',

    data() {
      return {
        datePicker: null,
        date: null,
        availableDates: {},
        inputProps: {
          placeholder: 'Select Date'
        },
        price: 0,
        dateData: {},
        pricePerSlot: 0,
      }
    },

    props: {
      featuredDates: {}
    },

    mounted() {
      this.getAvailableDates()
      if (this.featuredDates) {
        this.date = this.featuredDates
      }
      this.datePicker = this.$refs.featuredDates
    },

    computed: {
      enabledDates() {
        return Object.keys(this.availableDates).map(i => this.availableDates[i])
      },
    },

    methods: {
      updatePrice(selectedDates) {
        this.price = selectedDates.length * this.pricePerSlot
        ModalEvents.$emit('featuredDates', selectedDates)
        if (selectedDates.length === 2) {
          this.availableDates = selectedDates
        } else {
          this.getAvailableDates()
        }
      },

      getAvailableDates() {
        axios.get('/api/featured-dates')
          .then(response => {
            this.availableDates = response.data.availableDates
            this.dateData = response.data.datesWithAmount
            this.pricePerSlot = response.data.pricePerSlot
          })
      }
    },
  }
</script>

<style lang="scss" scoped>
    .feature-date {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 5px;
        .date {
            width: 70%;
        }
    }
</style>