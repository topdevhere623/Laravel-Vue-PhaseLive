<template>
  <div v-if="card">
    <div id="current-card">
      <div class="card-brand">
        <img :src="`/img/cards/${card.card.brand}.png`">
      </div>
      <div class="card-details">
        <p>Ending with {{ card.card.last4 }}</p>
        <p>Expires {{ card.card.exp_month }}/{{ card.card.exp_year }} - Last updated {{ lastUpdated }}</p>
      </div>
<!--                <div class="card-actions">-->
<!--                    <a class="" href="#" @click.prevent="editCard">Edit</a>-->
<!--                    <a class="remove" href="#" @click.prevent="removeCard">Remove</a>-->
<!--                </div>-->
    </div>
  </div>
</template>

<script>
export default {
  props: ['card'],

  computed: {
    lastUpdated() {
      return moment.unix(this.card.created).format('Do MMM YYYY')
    }
  }
}
</script>

<style lang="scss">
  #current-card {
    display: flex;
    margin-bottom: 1rem;
    padding: 1rem;
    background-color: #fdfdfd;
    border-radius: 5px;

    .card-brand {
      padding-right: 1rem;
      img {
        width: 40px
      }
    }

    .card-details {
      font-size: 14px;

      p {
        &:first-child {
          margin-bottom: .5rem;
          font-weight: bold;
        }
      }
    }

    .card-actions {
      align-self: center;
      flex: 1;
      text-align: right;

      .remove {
        color: #ff6e6e;
        text-decoration: none;
      }
    }
  }
</style>