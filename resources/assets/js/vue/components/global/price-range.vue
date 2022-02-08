<template>
	<div class="price-range">
		<div class="price-range-slider">
			<input type="range" :min="min" :max="max" :name="name" v-model="localValue" @input="valueChanged" :step="step || 100" />
			<div class="price-range-labels">
				<div>&pound;{{ pounds(min) }}</div>
				<div>&pound;{{ pounds(max) }}</div>
			</div>
		</div>
		<div class="price-range-value">
			<ph-button @click.native.prevent="">&pound;{{ pounds(localValue) }}</ph-button>
		</div>
	</div>
</template>

<script>
//import Component from '../';
import PhButton from "./ph-button";

export default {
	props: ["min", "max", "value", "name", "step"],
	data() {
		return {
			localValue: 0,
		};
	},
	watch: {
		value: function(value) {
			this.localValue = value;
		},
	},
	created: function() {
		if (this.value) {
			// If value prop is set and not 0
			this.localValue = this.value;
		} else {
			this.localValue = this.min;
			this.$emit("update:value", this.localValue);
		}
	},
	methods: {
		pounds: function(value) {
			return (value / 100).toFixed(2);
		},
		valueChanged: function() {
			this.$emit("update:value", this.localValue);
		},
	},
	components: {
		PhButton,
	},
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";
.price-range {
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.price-range-slider {
	flex: 1;

	input {
		width: 100%;
		box-sizing: border-box;
	}
}
.price-range-labels {
	display: flex;
	align-items: center;
	justify-content: space-between;
	color: $color-grey2;
	font-size: 10px;
}
.price-range-value {
	padding: 0 0 0 10px;

	button {
		width: 60px;
	}
}
</style>
