<template>
	<modal name="modal-create-merch" width="800px" height="auto" scrollable adaptive @before-open="beforeOpen">
		<div class="modal modal-create-event">
			<div class="modal-header">
				<close-icon class="float-right" @click.native="$modal.hide('modal-create-merch')"></close-icon>
			</div>
			<div class="modal-content">
				<h2>Create a new merch item</h2>
				<p>
					Use this form to create links to your merch.
				</p>
				<div class="event-options">
					<div class="event-image">
						<image-select v-model="data.image" v-validate="'required|min-dimensions:300,300'" name="image" />
						<span class="error-msg">{{ errors.first("image") }}</span>
					</div>
					<div class="event-info">
						<form>
							<table>
								<tr>
									<td>Title</td>
									<td>
										<input type="text" name="title" v-model="data.title" v-validate="'required|max:255'" />
										<span class="error-msg">{{ errors.first("title") }}</span>
									</td>
								</tr>
								<tr>
									<td style="vertical-align: top;">Description</td>
									<td>
										<textarea type="text" name="description" v-model="data.description" v-validate="'required|max:255'"></textarea>
										<span class="error-msg">{{ errors.first("description") }}</span>
									</td>
								</tr>
								<tr>
									<td>Links</td>
									<td>
										<div style="padding-bottom: 5px;" v-for="(link, index) in data.links" :key="index">
											<select :name="`links[shop][${index}]`" v-model="link.shop">
												<option v-for="(option, index) in shopOptions" :key="index" :value="option.value">
													{{ option.title }}
												</option>
											</select>
											<input required style="width: 85%; margin-top: 5px;" type="text" :name="`links[link][${index}]`" placeholder="Link" v-model="link.link" v-validate="'required|url'" data-vv-as="link" />
											<span @click="removeLink(index)" v-if="data.links.length > 1">
												<i class="link fas fa-minus"></i>
											</span>
											<div style="margin-left: 20px;">
												<span class="error-msg">{{ errors.first(`links[link][${index}]`) }}</span>
											</div>
										</div>
										<span v-if="data.links.length <= shopOptions.length - 1" @click="addLink">
											<i class="link fas fa-plus"></i>
										</span>
									</td>
								</tr>
							</table>
						</form>
						<ph-button @click.native="submit" size="medium" :loading="submitting">Submit</ph-button>
					</div>
				</div>
			</div>
		</div>
	</modal>
</template>

<script>
import CloseIcon from "global/close-icon";
import ImageSelect from "global/image-select";
import { UserEvents } from "events";

export default {
	data() {
		return {
			data: {
				image: null,
				title: "",
				description: "",
				links: [
					{
						shop: "",
						link: "",
					},
				],
				validationErrors: "",
			},
			shopOptions: [
				{
					title: "Shopify",
					value: "shopify",
				},
				{
					title: "WooCommerce",
					value: "woocommerce",
				},
				{
					title: "BigCartel",
					value: "bigcartel",
				},
				{
					title: "Magneto",
					value: "magneto",
				},
				{
					title: "BigCommerce",
					value: "bigcommerce",
				},
			],
			submitting: false,
		};
	},
	created: function() {},
	mounted: function() {},
	methods: {
		beforeOpen(event) {},
		submit() {
			this.$validator.validateAll().then((passes) => {
				if (!passes) return;
				let data = new FormData();
				data.append("image", this.data.image[0]);
				data.append("title", this.data.title);
				data.append("description", this.data.description);
				this.data.links.forEach(function(link, index) {
					data.append(`links[${index}][shop]`, link.shop);
					data.append(`links[${index}][link]`, link.link);
				});

				this.submitting = true;
				axios
					.post("/api/merch", data)
					.then((response) => {
						UserEvents.$emit("merch-added");
						this.$modal.hide("modal-create-merch");
						this.$notify({
							group: "main",
							type: "success",
							title: "Merch created successfully",
						});
					})
					.catch((error) => {
						this.validationErrors = error.response.data.errors;
					})
					.finally(() => {
						this.submitting = false;
					});
			});
		},
		addLink() {
			this.data.links.push({ shop: "", link: "" });
		},
		removeLink(index) {
			this.data.links.splice(index, 1);
		},
	},
	components: {
		CloseIcon,
		ImageSelect,
	},
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";
h2 {
	margin-bottom: 0;
}
p {
	margin: 1em 0;
}
.event-options {
	display: flex;

	@media (max-width: 655px) {
		flex-direction: column;
	}
}
.event-info {
	margin-left: 20px;
	flex: 1;

	@media (max-width: 655px) {
		margin-left: 0px;
	}
}
form {
	padding-left: 0;
	width: 100%;
	margin-bottom: 1em;
}
table {
	width: 100%;
}
tr {
	@media (max-width: 414px) {
		display: flex;
		flex-direction: column;
	}
}
td {
	padding: 0.8em 10px;

	@media (max-width: 655px) {
		padding: 0.8em 3px;
	}
}
input,
textarea {
	border: 1px solid $color-grey2;
	padding: 5px;
	border-radius: 2px;

	@media (max-width: 655px) {
		width: 85%;
	}
}
select {
	width: 85%;
}
.error-msg {
	position: absolute;
	font-size: 12px;
	color: red;
	padding-top: 4px;
}
.link {
	cursor: pointer;
	&.fa-plus {
		color: green;
	}
	&.fa-minus {
		color: red;
	}
}
</style>
