<template>
  <div class="p-chart">
    <h2>
      {{ name }} <small>from {{ this.data[0][0] }} to Today</small>
    </h2>
    <div class="chart-container">
      <canvas id="chart" ref="chart" height="195"></canvas>
    </div>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  props: {
    name: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      default: "line",
    },
    dataType: {
      type: String,
      default: "integer", // 'integer', 'currency'
    },
    data: {
      type: Array,
      required: true,
    },
    xLabel: {
      type: String,
      required: true,
    },
    yLabel: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      chart: null,
      variables: window.variables,
    };
  },
  updated() {
    this.renderChart();
  },
  mounted() {
    this.renderChart();
  },
  methods: {
    renderChart() {
      this.chart = new Chart(this.$refs.chart, {
        type: this.type,
        responsive: true,
        // The data for our dataset
        data: {
          labels: this.data[0],
          datasets: [
            {
              label: this.name,
              //backgroundColor: this.variables.colors.colorBlue,
              borderColor: this.variables.colors.colorBlue,
              data: this.data[1],
              lineTension: 0,
            },
          ],
        },
        options: {
          scales: {
            xAxes: [
              {
                scaleLabel: {
                  display: true,
                  fontSize: 18,
                  fontStyle: "bold",
                  labelString: this.xLabel,
                },
              },
            ],
            yAxes: [
              {
                scaleLabel: {
                  display: true,
                  fontSize: 18,
                  fontStyle: "bold",
                  labelString: this.yLabel,
                },
                ticks: {
                  // Only show whole numbers on y-axix
                  callback: (value, index, values) => {
                    return this.getTicks(value, index, values);
                  },
                },
              },
            ],
          },
        },
      });
    },
    getTicks(value, index, values) {
      switch (this.dataType) {
        case "integer":
          if (Math.floor(value) === value) {
            return value;
          }
          return;
        case "currency":
          return "£" + (value / 100).toFixed(2);
      }
    },
  },
  components: {},
};
</script>

<style lang="scss" scoped>
.p-chart {
    padding: 20px 0;
}
.chart-container {
  @media (min-width: 761px) {
    margin: 20px 0;
  }

  #chart {
    max-width: 100%;
  }
}
</style>
