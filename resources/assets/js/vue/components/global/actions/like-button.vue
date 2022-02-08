<template>
    <div
        class="like-button"
        v-if="app.user.loggedin"
        @click="toggleLike"
        :class="{ liked: this.likeable.is_liked }"
    >
        <span>
            <i class="fa fa-heart"></i>
        </span>
    </div>
</template>

<script>
//import Component from '../';
import { mapState } from "vuex";
import { UserEvents } from "events";

export default {
    props: {
        likeable: {
            // This is the object e.g. 'track', 'release', 'article'
            type: Object,
            required: true
        }
    },
    data() {
        return {};
    },
    computed: mapState(["app"]),
    methods: {
        toggleLike: function() {
            if (!this.likeable.is_liked) {
                this.like();
            } else {
                this.unlike();
            }
        },
        like: function() {
            axios.post(
                "/api/social/like/" +
                    this.likeable.type +
                    "/" +
                    this.likeable.id
            );
            this.likeable.is_liked = true;
            this.$emit("like");
            UserEvents.$emit("globalLike", this.likeable);
        },
        unlike: function() {
            axios.post(
                "/api/social/unlike/" +
                    this.likeable.type +
                    "/" +
                    this.likeable.id
            );
            this.likeable.is_liked = false;
            this.$emit("unlike");
            UserEvents.$emit("globalUnlike", this.likeable);
        },
        postData: function() {}
    },
    components: {}
};
</script>

<style lang="scss" scoped>
.like-button {
    display: inline-block;
    cursor: pointer;
}
.liked {
    color: red;
    animation: liked;
    animation-duration: 0.5s;
    animation-timing-function: ease-in;
}

@keyframes liked {
    0% {
        transform: skewX(9deg) scale(1);
    }
    10% {
        transform: skewX(-8deg);
    }
    20% {
        transform: skewX(7deg) scale(1.5);
    }
    30% {
        transform: skewX(-6deg) scale(1);
    }
    40% {
        transform: skewX(5deg);
    }
    50% {
        transform: skewX(-4deg) scale(1.1);
    }
    60% {
        transform: skewX(3deg);
    }
    70% {
        transform: skewX(-2deg);
    }
    80% {
        transform: skewX(1deg);
    }
    90% {
        transform: skewX(0deg);
    }
    100% {
        transform: skewX(0deg) scale(1);
    }
}
</style>
