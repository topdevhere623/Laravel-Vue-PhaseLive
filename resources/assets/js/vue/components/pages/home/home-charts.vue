<template>
  <div>
    <div class="home-charts" v-if="chartItems">
      <div class="home-chart" v-for="(items, index) in chartItems" :key="index">
        <div class="chart-items">
          <div class="chart-item genre-name">
            <!-- <div
                            class="genre-overlay"
                            :style="
                                `background-image:url(${chartImage(index)})`
                            "
                        ></div> -->
            <circle-logo
              width="100px"
              height="100px"
              :invert="chartItemID(index) % 2 === 0 ? true : false"
            >
              <div style="font-size:11px;">Top 10 <br />{{ index }}s</div>
            </circle-logo>
            <!-- <span>
                            Top 10
                            <span>{{ index }}s</span>
                        </span> -->
          </div>
          <div v-for="item in items" :key="item.id">
            <router-link :to="getRouterObject(item)">
              <div
                class="chart-item"
                :style="
                  'background-image: url(' + item.image.files.original.url + ')'
                "
              >
                <!-- <overlay /> -->
              </div>
            </router-link>
          </div>
        </div>
        <div class="chart-viewall">
          <router-link :to="{ name: 'charts', query: { filter: index } }"
            >View All</router-link
          >
        </div>
      </div>
    </div>

    <!-- MOBILE -->
    <div class="home-charts-repsonsive" v-if="chartItems">
      <div class="home-chart" v-for="(items, index) in chartItems" :key="index">
        <div class="chart-items">
          <div class="chart-item genre-name">
           
            <span> Top 10 {{ index }}s</span>
          </div>
          <div v-for="item in items" :key="item.id" class="chart-item">
            <router-link :to="getRouterObject(item)">
              <div
                class="chart-item"
                :style="
                  'background-image: url(' + item.image.files.original.url + ')'
                "
              >
                <!-- <overlay /> -->
              </div>
            </router-link>
          </div>
        </div>
        <div class="chart-viewall">
          <router-link :to="{ name: 'charts', query: { filter: index } }"
            >View All</router-link
          >
        </div>
      </div>
    </div>

    <spinner
      v-if="chartItems.length <= 1"
      style="margin: 3em auto;"
      :animation-duration="1000"
      :size="80"
      color="black"
    />
  </div>
</template>

<script>
import { HalfCircleSpinner as Spinner } from "epic-spinners";
import Overlay from "../../global/overlay";
import CircleLogo from "global/circle-logo";

export default {
  name: "home-charts",
  props: ["chart-items"],
  components: {
    Spinner,
    Overlay,
    CircleLogo,
  },

  methods: {
    chartItemID(index) {
      switch (index) {
        case "album":
          return 1;
          break;
        case "single":
          return 2;
          break;
        case "ep":
          return 3;
          break;
        case "compilation":
          return 4;
          break;

        default:
        //
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.home-charts {
  @media (max-width: 768px) {
    display: none;
  }
  h1 {
    margin-top: 95px;
  }
  .home-charts {
    margin-bottom: 2em;
  }
  .home-chart,
  .chart-items {
    display: flex;
    justify-content: space-between;
  }
  .home-chart {
    margin: 8.3px 0;
    width: 100%;

    &:last-of-type {
      .genre-name > span > span {
        font-size: 9px;
        display: block;
      }
    }
  }
  .chart-items {
    display: grid;
    grid-template-columns: repeat(11, 1fr);
    width: 100%;
    grid-gap: 8.3px;
  }
  .chart-item {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center center;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    vertical-align: middle;
    position: relative;

    &.genre-name {
      font-weight: bold;
      text-transform: uppercase;
      font-size: 12px;
      color: #fff;

      > span {
        position: relative;
        z-index: 20;
        transform: rotate(-90deg);
      }

      .genre-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
      }
    }
  }
  .chart-viewall {
    text-transform: uppercase;
    transform-origin: top left;
    transform: rotate(-90deg) translateX(-100%);
    font-size: 12px;
    font-weight: bold;
    letter-spacing: 1px;
    width: 85px;
    height: 85px;
    text-align: center;
    padding-top: 20px;
    margin-right: -50px;
    a {
      text-decoration: none;
    }
  }
}

.home-charts-repsonsive {
  display: none;

  @media (max-width: 768px) {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .home-chart {
      width: calc(100% / 4 - 3.8px);
      @media (max-width: 450px) {
        width: calc(100% / 2 - 3.8px);
      }

      .chart-items {
        .chart-item {
          height: 100px;
          width: 100%;
          background-position: center;
          background-size: cover;
          background-repeat: no-repeat;
          margin-bottom: 3.8px;

          span {
            position: absolute;
            transform: translate(-50%, -50%);
            text-align: center;
            left: 50%;
            top: 50%;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            color: #fff;
          }

          &.genre-name {
            position: relative;

            .genre-overlay {
              position: absolute;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background-repeat: no-repeat;
              background-size: cover;
              background-position: center;
            }
          }
        }
      }

      .chart-viewall {
        text-transform: uppercase;
        font-size: 12px;
        font-weight: bold;
        letter-spacing: 1px;
        width: 85px;
        height: 85px;
        text-align: center;
        padding-top: 20px;
        margin-right: -50px;
        a {
          text-decoration: none;
        }
      }
    }
  }
}
</style>
