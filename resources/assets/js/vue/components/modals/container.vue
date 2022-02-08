<template>
    <div>
        <cart/>
        <checkout/>
        <upload/>
        <auth/>
        <change-avatar/>
        <change-banner/>
        <report/>
        <share/>
        <comment/>
        <faq/>
        <create-event/>
        <update-event/>
        <upload-video/>
        <video-player/>
        <create-merch/>
        <featured-dates-payment/>
        <mailing-list/>
        <delete-confirm />
        <edit-comment />
    </div>
</template>

<script>
  import Cart from './cart/cart'
  import Checkout from './cart/checkout'
  import Upload from './upload'
  import Auth from './auth'
  import ChangeAvatar from './change-avatar'
  import ChangeBanner from './change-banner'
  import Report from './report'
  import Share from './share'
  import Comment from './comment'
  import Faq from './faq'
  import CreateEvent from './create-event'
  import UploadVideo from './upload-video/upload-video'
  import VideoPlayer from './video-player'
  import CreateMerch from './create-merch'
  import FeaturedDatesPayment from './featured-dates-payment'
  import MailingList from './mailing-list'
  import DeleteConfirm from './delete-confirm'
  import EditComment from './edit-comment'
  import UpdateEvent from './update-event';


  export default {
    data() {
      return {}
    },
    created: function () {

    },
    components: {
      MailingList,
      FeaturedDatesPayment,
      Cart,
      Checkout,
      Upload,
      Auth,
      ChangeAvatar,
      ChangeBanner,
      Report,
      Share,
      Comment,
      Faq,
      CreateEvent,
      UpdateEvent,
      UploadVideo,
      VideoPlayer,
      CreateMerch,
      DeleteConfirm,
      EditComment
    },
  }
</script>

<style lang="scss">
    @import "~styles/helpers/_variables.scss";

    .v--modal {
        margin: 20px 0;
    }

    .modal {
        width: 100%;
        height: 100%;

        font-family: $font-comfortaa;

        .modal-logo {
            padding-top: 3em;
        }
    }

    .modal-header {
        position: relative;

        .close-icon {
            position: absolute;
            top: 0;
            right: 0;
        }
    }

    .modal-content {
        padding: 2em;

        @media(max-width: 400px){
            padding: 1em;
        }

        &.full-width {
            padding: 2em 0;
        }
    }
</style>
