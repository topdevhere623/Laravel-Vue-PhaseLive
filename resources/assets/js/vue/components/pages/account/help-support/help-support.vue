<template>
  <div class="page-content-padded page-help-support">
    <!-- MAIN CONTENT -->
    <div class="page-main">
      <div class="help-hero">
        <div class="help-search">
          <div class="search-button">
            <span v-show="!searching">
              <i class="fas fa-search"></i>
            </span>
            <spinner
              style="margin: 3em auto"
              v-show="searching"
              :animation-duration="1000"
              :size="40"
              :color="variables.colors.colorBlue"
            />
          </div>
          <div class="search-input-container">
            <input
              type="text"
              placeholder="HOW CAN WE HELP?"
              v-model="searchTerm"
            />
          </div>
          <div class="search-results" v-show="searchResults.length">
            <div
              class="search-result"
              v-for="faqResult in searchResults"
              @click="showFaqModal(faqResult)"
            >
              <div class="question-icon">
                <i class="fas fa-question-circle"></i>
              </div>
              <div>
                {{ faqResult.question }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="faq-categories" v-if="loaded">
        <div
          class="faq-category"
          v-for="category in categories"
          :key="category.id"
          @click="selectCategory(category)"
          :class="{ active: isCategoryActive(category) }"
        >
          <div class="category-icon">
            <i :class="category.icon"></i>
          </div>
          <div>{{ category.name }}</div>
        </div>
      </div>
      <spinner
        style="margin: 3em auto"
        v-else
        :animation-duration="1000"
        :size="60"
        :color="'black'"
      />
      <div class="faqs" v-if="categories.length">
        <div class="faq" v-for="faq in faqs">
          <div class="question" @click="toggleFaq(faq)">
            <div class="question-icon">
              <i class="fas fa-question-circle"></i>
            </div>
            <div class="question-text">
              {{ faq.question }}
            </div>
          </div>
          <div class="answer" :class="{ active: isFaqActive(faq) }">
            <div class="answer-icon">
              <i class="fas fa-check-circle"></i>
            </div>
            <p class="answer-text" v-html="faq.answer.nl2br()"></p>
          </div>
        </div>
      </div>
      <contact-form v-if="selectedCategory && selectedCategory.id === 5" />
    </div>
    <!-- <aside class="sidebar-right">
            <div class="right-content-wrap" style="" v-if="selectedCategory">
                <p class="sidebar-title">FAQS</p>
                <p v-text="selectedCategory.name"></p>
                <div class="faqs" v-if="categories.length">
                <div class="faq" v-for="faq in faqs">
                    <div class="question" @click="toggleFaq(faq)">
                        <div class="question-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div class="question-text">
                            {{ faq.question }}
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </aside> -->
  </div>
</template>

<script>
import { HalfCircleSpinner as Spinner } from "epic-spinners";
import SubNav from "../account-menu";
import ContactForm from "./contact-form";
import { UserEvents } from "events";

export default {
  data() {
    return {
      variables: window.variables,
      loaded: false,
      categories: [],
      selectedCategory: null,
      selectedFaq: null,
      searching: false,
      searchTerm: "",
      searchResults: [],
    };
  },
  computed: {
    faqs() {
      return this.selectedCategory ? this.selectedCategory.faqs : [];
    },
  },
  watch: {
    searchTerm: function () {
      this.search();
    },
  },
  mounted() {
    this.fetchFaqs();
    UserEvents.$emit("updateTitle", "Help & Support");
  },
  methods: {
    fetchFaqs() {
      this.loaded = false;
      axios.get("/api/help/faq/list").then((response) => {
        this.loaded = true;
        this.categories = response.data;
        this.selectCategory(this.categories[0]);
      });
    },
    selectCategory(category) {
      this.selectedCategory = category;
    },
    isCategoryActive(category) {
      if (!this.selectedCategory) {
        return false;
      }
      return category.id === this.selectedCategory.id;
    },
    toggleFaq(faq) {
      if (this.selectedFaq === faq) {
        this.selectedFaq = null;
      } else {
        this.selectedFaq = faq;
      }
    },
    isFaqActive(faq) {
      if (!this.selectedFaq) {
        return false;
      }
      return faq.id === this.selectedFaq.id;
    },
    search() {
      this.searchResults = [];
      if (this.searchTerm === "") return;
      let faq = null;
      for (let i = 0; i < this.categories.length; i++) {
        for (let x = 0; x < this.categories[i].faqs.length; x++) {
          faq = this.categories[i].faqs[x];
          if (
            faq.question
              .toLowerCase()
              .includes(this.searchTerm.toLowerCase()) ||
            faq.answer.toLowerCase().includes(this.searchTerm.toLowerCase())
          ) {
            this.searchResults.push(faq);
          }
        }
      }
    },
    showFaqModal(faq) {
      this.$modal.show("modal-faq", { faq: faq });
    },
  },
  components: {
    Spinner,
    SubNav,
    ContactForm,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

::placeholder {
  opacity: 1 !important;
  color: #000 !important;
}
.page-help-support {
  padding-top: 0;
}

.sidebar-group-title {
  color: #3300ff;
}
.sidebar-right {
  margin-top: 40px;

  .right-content-wrap {
    border-left: 6px solid #9eefe1;
    padding: 10px;

    .sidebar-title {
      color: #3300ff;
      font-weight: bold;
      font-size: 25px;
      margin-bottom: 20px;
    }

    .faqs {
      margin: 20px 0;

      .question-text {
        font-size: 16px;
      }
    }
  }
}
.help-hero {
  background-image: url("/img/help_support.jpg");
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  box-shadow: inset 0 0 0 4000px rgba(0, 0, 0, 0.4);
  width: 100%;
  height: 400px;
  padding: 50px;
  box-sizing: border-box;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  color: white;

  @media (max-width: 768px) {
    padding: 10px;
  }
}
h1 {
  text-align: center;
  margin-top: 0;
}
.help-search {
  display: flex;
  position: relative;
  margin: 0 auto;
  background: white;
  width: 80%;
  height: 75px;

  @media (max-width: 600px) {
    width: 97%;
    height: 50px;
  }
}
.search-button {
  width: 75px;
  height: 75px;
  color: $color-blue;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 29px;
  border-right: 1px solid $color-2;

  @media (max-width: 600px) {
    width: 50px;
    height: 50px;

    .svg-inline--fa.fa-w-16 {
      width: 0.7em;
    }
  }
}
.search-input-container {
  flex: 1;

  display: flex;
  align-items: center;

  padding: 0 25px;

  @media (max-width: 600px) {
    padding: 0 10px;
  }

  input {
    width: 100%;
    font-size: 20px;
    border: none;
    box-sizing: border-box;

    @media (max-width: 600px) {
      font-size: 18px;
    }

    &::placeholder {
      color: $color-grey;
    }

    &:focus {
      outline: none;
    }
  }
}
.search-results {
  position: absolute;
  top: 100%;
  right: 0;
  width: calc(100% - 75px);
  color: black;
  background: white;
  box-sizing: border-box;
  border-top: 1px solid $color-2;
}
.search-result {
  display: flex;
  align-items: center;
  padding: 10px;
  cursor: pointer;

  &:hover {
    background: $color-grey;
  }
}

// Categories --------------------------------------
.faq-categories {
  display: flex;
  justify-content: space-between;

  @media (max-width: 700px) {
    display: grid;
    grid-template-columns: 2fr 2fr;
  }
}
.faq-category {
  text-align: center;
  cursor: pointer;

  &.active {
    text-decoration: underline;
  }
}
.category-icon {
  background: $color-2;
  color: white;
  font-size: 70px;
  width: 120px;
  height: 120px;
  margin: 40px auto;
  border-radius: 100%;

  display: flex;
  justify-content: center;
  align-items: center;
}

// Questions & Answers -----------------------------
.faqs {
  margin: 50px 0;
}
.question,
.answer {
  display: flex;
  align-items: center;
  padding: 10px 0;
  font-size: 20px;
  cursor: pointer;
}
.answer {
  display: none;
  align-items: flex-start;
  font-size: 16px;
  cursor: default;

  &.active {
    display: flex;
  }
}
.question-icon,
.answer-icon {
  width: 30px;
  color: $color-blue;
  font-size: 30px;
  margin-right: 15px;
}
.answer-icon {
  color: $color-2;
}
.answer-text {
  line-height: 25px;
}
</style>
