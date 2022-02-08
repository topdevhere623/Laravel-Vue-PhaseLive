:<template>
  <modal
    name="modal-comment"
    width="700px"
    height="auto"
    scrollable
    @before-open="beforeOpen"
  >
    <div class="modal modal-comment">
      <div class="modal-header">
        <close-icon class="float-right" @click.native="onHide" />
      </div>
      <div class="modal-content">
        <div class="release-header">
          <!-- <div>
                        <avatar
                            :src="commentable ? commentable.image.files.medium.url : null"
                            :size="150"
                            :tile="true"
                            :center="false"
                        />
                    </div> -->
          <div v-if="commentable && commentable.type === 'news'">
            <h2>News</h2>
            <h3>{{ commentable.title }}</h3>
            <div>{{ commentable.content }}</div>
          </div>
          <div
            v-else-if="commentable && commentable.type === 'release'"
            class="release-content"
          >
            <h2>{{ commentable.name }}</h2>
            <p>{{ commentable.description }}</p>
          </div>
        </div>
        <add-text
          type="comment"
          :addTextAble="commentable"
          @success="onCommentAdded"
        />
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "global/close-icon";
import Avatar from "global/avatar";
import AddText from "global/add-text/add-text";
import { SocialEvents } from "events";
import { UserEvents } from "events";

export default {
  components: {
    CloseIcon,
    AddText,
    Avatar,
  },

  data() {
    return {
      commentable: null,
    };
  },

  methods: {
    beforeOpen({ params }) {
      this.commentable = params.commentable;
    },

    onHide() {
      this.$modal.hide("modal-comment");
    },

    onCommentAdded(d) {
      SocialEvents.$emit('commented', this.commentable);
      this.$notify({
        group: "main",
        type: "success",
        title: "Comment added",
      });
      this.onHide();
    },
  },
};
</script>

<style lang="scss" scoped>
.release-header {
  margin-bottom: 30px;
  display: flex;
  flex-direction: row;
  padding-right: 50px; // Prevents content flowing under close icon
}

.release-content {
  margin-left: 20px;
}
</style>
