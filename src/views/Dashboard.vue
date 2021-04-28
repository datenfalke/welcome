<template>
	<div id="htmlwidget-widget">
		<span v-if="loading" class="icon icon-loading" />
		<div class="html-content" v-html="contentHtml" />
	</div>
</template>

<script>
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

export default {
	name: 'Dashboard',

	components: {
	},

	props: {
		title: {
			type: String,
			required: true,
		},
	},

	data() {
		return {
			loading: true,
			content: '',
		}
	},

	computed: {
	},

	beforeMount() {
		this.getContent()
	},

	mounted() {
	},

	methods: {
		getContent() {
			const url = generateUrl('/apps/htmlwidget/widget-content')
			axios.get(url).then((response) => {
				this.contentHtml = response.data.contentHtml
				console.debug('"' + this.contentHtml + '"')
			}).catch((error) => {
				console.debug(error)
			}).then(() => {
				this.loading = false
			})
		},
	},
}
</script>
