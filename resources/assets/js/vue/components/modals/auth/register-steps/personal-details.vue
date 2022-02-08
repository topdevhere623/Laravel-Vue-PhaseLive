<template>
    <div>
        <div class="register-form-group">
            <h2>Personal Details</h2>
            <div
                class="register-form-inputs"
                v-if="selectedPlan.role.name === 'standard'"
            >
                <div class="full-width">
                    <div class="full-width">
                        <div class="input">
                            <div>
                                Username:
                            </div>
                            <div>
                                <input
                                    type="text"
                                    name="personal-username"
                                    v-model="data.personal.username"
                                    tabindex="1"
                                    :disabled="submitting"
                                    v-validate="'required|username|max:20'"
                                    data-vv-as="user name"
                                />
                              <p class="error-message">
                                {{ errors.first("personal-username") }}
                              </p>
                                <p
                                    class="error-message"
                                    v-show="
                                        validationErrors['personal.username']
                                    "
                                >
                                    The username has been taken
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-form-inputs">
                <div class="left">
                    <div class="input">
                        <div>
                            First Name:
                        </div>
                        <div>
                            <input
                                type="text"
                                name="personal-name"
                                v-model="data.personal.firstname"
                                tabindex="2"
                                :disabled="submitting"
                                v-validate="'required|username|max:255'"
                                data-vv-as="first name"
                            />
                            <p class="error-message">
                                {{ errors.first("personal-name") }}
                            </p>
                        </div>
                    </div>
                    <!-- <div class="input">
                        <div>
                            Username:
                        </div>
                        <div>
                            <input type="text" name="personal-username" v-model="data.personal.username"
                                   tabindex="4" :disabled="submitting" v-validate="'required|max:255'"
                                   data-vv-as="username"/>
                            <p class="error-message">{{ errors.first('personal-username') }}</p>
                            <p class="error-message" v-if="validationErrors">{{
                                validationErrors['personal.username'][0] | normalize }}</p>
                        </div>
                    </div> -->
                    <div class="input">
                        <div>
                            Password:
                        </div>
                        <div>
                            <input
                                type="password"
                                name="personal-password"
                                v-model="data.personal.password"
                                tabindex="6"
                                :disabled="submitting"
                                v-validate="{
                                    is: data.personal.password_confirmation,
                                    required: true,
                                    max: 255,
                                }"
                                data-vv-as="password"
                            />
                            <p class="error-message">
                                {{ errors.first("personal-password") }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="input">
                        <div>
                            Last Name:
                        </div>
                        <div>
                            <input
                                type="text"
                                name="personal-surname"
                                v-model="data.personal.surname"
                                tabindex="3"
                                :disabled="submitting"
                                v-validate="'required|username|max:255'"
                                data-vv-as="surname"
                            />
                            <p class="error-message">
                                {{ errors.first("personal-surname") }}
                            </p>
                        </div>
                    </div>
                    <div class="input">
                        <div>
                            Confirm Password:
                        </div>
                        <div>
                            <input
                                type="password"
                                name="personal-password-confirmation"
                                v-model="data.personal.password_confirmation"
                                tabindex="7"
                                :disabled="submitting"
                                v-validate="'required|max:255'"
                                data-vv-as="password confirmation"
                            />
                            <p class="error-message">
                                {{
                                    errors.first(
                                        "personal-password-confirmation"
                                    )
                                }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-form-inputs">
                <div class="full-width">
                    <div class="full-width">
                        <div class="input">
                            <div>
                                Email:
                            </div>
                            <div>
                                <input
                                    type="text"
                                    name="personal-email"
                                    v-model="data.personal.email"
                                    tabindex="8"
                                    :disabled="submitting"
                                    v-validate="'required|email|max:255'"
                                    data-vv-as="email address"
                                    ref="email"
                                />
                                <p class="error-message">
                                    {{ errors.first("personal-email") }}
                                </p>
                                <p
                                    class="error-message"
                                    v-show="validationErrors['personal.email']"
                                    style="bottom: -40px;"
                                >
                                    The email has been taken
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="register-form-group"
            v-if="
                selectedPlan.role.name === 'artist' ||
                    selectedPlan.role.name === 'pro'
            "
        >
            <h2>Artist / Producer / Label Details</h2>
            <div class="register-form-inputs">
                <div class="full-width">
                    <div class="input">
                        <div>
                            Name:
                        </div>
                        <div>
                            <input
                                type="text"
                                name="artist-name"
                                v-model="data.artist.username"
                                tabindex="9"
                                :disabled="submitting"
                                v-validate="'required|max:20'"
                                data-vv-as="name"
                            />
                            <p
                                class="error-message"
                                v-show="validationErrors['artist.username']"
                            >
                                The name has been taken
                            </p>
                        </div>
                    </div>
                    <div class="input">
                        <div>
                            Genres:
                        </div>
                        <div>
                            <!--<input type="text" name="artist-genres" />-->
                            <genre-select
                                @change="artistGenresChanged"
                                :min="2"
                                :max="4"
                                tabindex="10"
                                :disabled="submitting"
                            />
                            <input
                                type="hidden"
                                name="artist genre"
                                placeholder="Genre"
                                v-validate="'required'"
                                ref="artist_genre_input"
                            />
                            <p class="error-message">
                                {{ errors.first("artist genre") }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="register-form-group"
            v-if="
                selectedPlan.role.name === 'artist' ||
                    selectedPlan.role.name === 'pro'
            "
        >
            <h2 class="social-header">Social & Website Links</h2>
            <p class="social-error" v-if="submitted && !hasValidSocial">
                You must enter at least one social url
            </p>

            <div class="register-form-inputs">
                <div class="full-width">
                    <div class="input">
                        <div>
                            Website
                        </div>
                        <div>
                            <input
                                type="text"
                                name="social-website"
                                v-model="data.social.website"
                                tabindex="11"
                                :disabled="submitting"
                                v-validate="{ max:255, regex: /^((https?):\/\/)?(www.)?[a-z0-9]+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/ }"
                                data-vv-as="website"
                            />
                            <p class="error-message">
                                {{ errors.first("social-website") }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-form-inputs">
                <div class="left">
                    <div class="input">
                        <div>
                            Facebook
                        </div>
                        <div>
                            <input
                                type="text"
                                name="social-facebook"
                                v-model="data.social.facebook"
                                tabindex="12"
                                :disabled="submitting"
                                v-validate="{ max: 255, regex: /^(http(s)?:\/\/)?(www\.)?(m\.)?facebook\.com\/[A-z 0-9 _ .]*\/?$/ }"
                                data-vv-as="Facebook"
                            />
                            <p class="error-message">
                                {{ errors.first("social-facebook") }}
                            </p>
                        </div>
                    </div>
                    <div class="input">
                        <div>
                            Soundcloud
                        </div>
                        <div>
                            <input
                                type="text"
                                name="social-soundcloud"
                                v-model="data.social.soundcloud"
                                tabindex="14"
                                :disabled="submitting"
                                v-validate="{ max: 255, regex: /^(http(s)?:\/\/)?(www\.)?(m\.)?(soundcloud\.com|snd\.sc)\/(.*)$/ }"
                                data-vv-as="Soundcloud"
                            />
                            <p class="error-message">
                                {{ errors.first("social-soundcloud") }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="input">
                        <div>
                            Twitter
                        </div>
                        <div>
                            <input
                                type="text"
                                name="social-twitter"
                                v-model="data.social.twitter"
                                tabindex="13"
                                :disabled="submitting"
                                v-validate="{ max: 255, regex: /^(http(s)?:\/\/)?(www\.)?(mobile\.)?twitter\.com\/[A-z 0-9 _]{1,15}\/?$/ }"
                                data-vv-as="Twitter"
                            />
                            <p class="error-message">
                                {{ errors.first("social-twitter") }}
                            </p>
                        </div>
                    </div>
                    <div class="input">
                        <div>
                            YouTube
                        </div>
                        <div>
                            <input
                                type="text"
                                name="social-youtube"
                                v-model="data.social.youtube"
                                tabindex="15"
                                :disabled="submitting"
                                v-validate="{ max: 255, regex: /(https?:\/\/)?(www\.)?(m\.)?youtube\.com\/(channel|user|c|u)\/[\w-]+/ }"
                                data-vv-as="Youtube"
                            />
                            <p class="error-message">
                                {{ errors.first("social-youtube") }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="register-form-group">
            <h2>Music Interests</h2>
            <div class="register-form-inputs">
                <div class="full-width">
                    <div class="input">
                        <div>
                            Genres:
                        </div>
                        <div>
                            <genre-select
                                @change="interestGenresChanged"
                                :min="2"
                                :max="4"
                                tabindex="16"
                                :disabled="submitting"
                            />
                            <input
                                type="hidden"
                                name="interest genre"
                                placeholder="Genre"
                                v-validate="'required'"
                                ref="interest_genre_input"
                            />
                            <p class="error-message">
                                {{ errors.first("interest genre") }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="register-form-inputs">
                <div class="full-width">
                    <div class="input">
                        <div>Sign up to newsletter:</div>
                        <div>
                            <input
                                type="checkbox"
                                :name="`${selectedPlan.role.name}_newsletter`"
                                v-model="data.newsletter"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <ph-button
                size="large"
                :loading="submitting"
                @click.native.prevent="registerUser"
            >
                Submit
            </ph-button>
        </div>
    </div>
</template>

<script>
    import GenreSelect from "../../upload/genre-select";
    import Cookies from 'js-cookie';

    export default {
        name: "personal-details",

        props: {
            selectedPlan: {
                required: true,
                type: Object,
            },
        },

        data() {
            return {
                artistGenresString: "",
                interestGenresString: "",
                validationErrors: "",
                submitting: false,
                submitted: false, // If a submission was attempted
                data: {
                    personal: {
                        username: "",
                        firstname: "",
                        surname: "",
                        email: "",
                        password: "",
                        password_confirmation: "",
                        mobile:"",
                    },
                    artist: {
                        username: "",
                        genres: [],
                    },
                    social: {
                        website: "",
                        facebook: "",
                        twitter: "",
                        soundcloud: "",
                        youtube: "",
                    },
                    interests: {
                        genres: [],
                    },
                    newsletter: false,
                },
            };
        },

        computed: {
            /** Determine if any of the values in the social data are valid */
            hasValidSocial() {
                return !!Object.entries(this.data.social).filter(([_, value]) => !!value).length;
            }
        },

        methods: {
            artistGenresChanged(genres) {
                this.artistGenresString = "";
                this.data.artist.genres = genres;
                for (let i = 0; i < genres.length; i++) {
                    this.artistGenresString += genres[i].name;
                }
                this.$refs.artist_genre_input.value = this.artistGenresString;
                this.$validator.validate();
            },
            interestGenresChanged(genres) {
                this.interestGenresString = "";
                this.data.interests.genres = genres;
                for (let i = 0; i < genres.length; i++) {
                    this.interestGenresString += genres[i].name;
                }
                this.$refs.interest_genre_input.value = this.interestGenresString;
                this.$validator.validate();
            },
            registerUser() {
                this.submitted = true;
                this.$validator.validate().then((passes) => {
                    if (!this.hasValidSocial && this.selectedPlan.title !== 'Standard') return;

                    const transferCart = this.$route.query.transferCart;
                    let guestCart = null;
                    if (transferCart === 'true') {
                      guestCart = Cookies.getJSON('phase_cart');
                    }

                    if (passes) {
                        this.validationErrors = "";
                        this.submitting = true;
                        axios
                            .post(
                                "/api/auth/register/" +
                                    this.selectedPlan.role.name,
                                {
                                  ...this.data,
                                  guestCart,
                                }
                            )
                            .then((response) => {
                                this.submitting = false;
                                this.$store.commit(
                                    "app/setTempUser",
                                    response.data
                                );
                                this.$emit("next-step");
                            })
                            .catch((error) => {
                                this.submitting = false;
                                this.validationErrors =
                                    error.response.data.errors;
                            });
                    }
                });
            },
        },

        filters: {
            normalize: function(value) {
                if (!value) return "";
                value = value.replace(/personal./g, "");
                return value;
            },
        },

        components: {
            GenreSelect,
        },
    };
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    form.register-form {
        margin-top: 100px;
        padding: 0;
        width: 100%;
    }

    .register-form-group {
        padding: 20px 50px;

        @media (max-width: 1000px) {
            padding: 20px 20px;
        }

        @media (max-width: 768px) {
            padding: 5px 10px;
        }

        &:nth-of-type(2n - 1) {
            background: $color-grey;
        }

        h2 {
            color: $color-blue;

            @media (max-width: 390px) {
                font-size: 20px;
            }
        }
    }

    .register-form-inputs {
        display: flex;
        justify-content: space-between;

        @media (max-width: 840px) {
            flex-direction: column;
        }
    }

    .left,
    .right {
        flex-basis: 48%;
    }

    .full-width {
        flex-basis: 100%;
    }

    .input {
        flex: 1;
        display: flex;
        margin: 1.8em 0;

        @media (max-width: 500px) {
            flex-direction: column;
            margin: 1.4em 0;
        }

        @media (max-width: 420px) {
            margin: 1.2em 0;
        }

        @media (max-width: 390px) {
            margin: 1em 0;
        }

        & > div:first-of-type {
            width: 125px;
            display: flex;
            align-items: center;
        }

        & > div:last-of-type {
            flex: 1;
            position: relative;
        }
    }

    .error-message {
        font-size: 12px;
        position: absolute;
        bottom: -25px;
        color: red;
    }

    .register-form-inputs input {
        padding: 10px !important;
        box-sizing: border-box;
        font-size: 17px !important;
        border: 1px solid $color-grey4 !important;
        border-radius: 3px;
    }

    .social-header {
        margin-bottom: 8px;
    }

    .social-error {
        color: red;
        font-size: 12px;
    }
</style>
