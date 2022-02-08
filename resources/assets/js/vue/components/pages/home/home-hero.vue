<template>
    <div class="hero">
        <overlay />
        <div class="hero-content">
            <h1>Connecting People Through Music.</h1>
            <div class="hero-buttons">
                <ph-button
                    color="inverted"
                    size="giant"
                    @click.native="showAuthModal()"
                >
                    <p>Join For Free</p>
                </ph-button>
            </div>
        </div>
    </div>
</template>

<script>
    import Overlay from "../../global/overlay";

    export default {
        name: "home-hero",
        components: {
            Overlay
        },
        methods: {
            showAuthModal: function() {
                this.$modal.show("modal-auth-register");
            }
        }
    };
</script>

<style lang="scss" scoped>
    .hero-content {
        z-index: 20;
    }
    /*#99e8db*/
    /*#366efe*/
    .button.giant {
        padding: 15px 0px;
        border-width: 2px;
        p {
            font-size: 28.9px;
        }
    }

    .hero {
        margin: -80px calc(-50vw + 50%) 0 0;
    }
</style>
