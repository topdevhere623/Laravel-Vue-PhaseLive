<template>
  <a :href="event.url" target="_blank" class="p-item">
    <div class="p-item-image">
      <avatar :size="130" :src="event.image.files.medium.url" :tile="true" />
    </div>
    <div class="p-item-main">
      <div class="p-item-detail">
        <div class="p-item-title">
          <span>{{ event.name }}</span>
        </div>
      </div>
      <div class="event-date-location">
        <div>
          <i class="far fa-fw fa-calendar"></i>
          {{ moment(event.date).format("MMMM Do YYYY, h:mma") }}
        </div>
        <div>
          <i class="fa fa-fw fa-map-marker-alt"></i> {{ event.location }}
        </div>
      </div>
      <div v-if="app.user.id === event.user.id">
        <a
          href=""
          @click.prevent="$modal.show('modal-update-event', { event: event })"
        >
          <i class="fa fa-pen"></i> Edit
          
        </a>
        <a  @click.prevent="$modal.show('modal-delete-confirm', { deleteable: event })">
          <i class="fa fa-trash"></i> Delete
        </a>
      </div>
    </div>
  </a>
</template>

<script>
import {mapState} from 'vuex'

import Actions from "global/actions/actions";
import ActionMenu from "global/actions/action-menu";
import Avatar from "global/avatar";

export default {
  props: {
    event: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      moment: window.moment,
    };
  },
  created: function () {},
  methods: {},
  components: {
    Actions,
    ActionMenu,
    Avatar,
  },
  computed: mapState(['app'])
};
</script>

<style lang="scss" scoped>
a {
  text-decoration: none;
}
.event-date-location {
  margin-top: 0.5em;
  flex: 1;

  div {
    margin: 10px 0;
  }
}
</style>