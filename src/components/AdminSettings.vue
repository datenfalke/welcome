<template>
	<div id="htmlwidget_prefs" class="section">
		<h2>
			<a class="icon icon-htmlwidget" />
			{{ t('htmlwidget', 'HtmlWidget') }}
		</h2>
		<div class="grid-form">
			<label for="htmlwidget-widget-title">
				<span class="icon icon-tag" />
				{{ t('htmlwidget', 'Widget Title') }}
			</label>
			<input id="htmlwidget-widget-title"
				v-model="state.widgetTitle"
				type="text"
				:class="{ 'icon-loading-small': saving }"
				@input="onWidgetTitleChange">
			<label for="htmlwidget-content-html">
				<span class="icon icon-timezone" />
				{{ t('htmlwidget', 'HTML') }}
			</label>
			<input id="htmlwidget-content-html"
				v-model="state.contentHtml"
				type="text"
				:class="{ 'icon-loading-small': saving }"
				@input="onContentHtmlChange">
			<div />
		</div>
	</div>
</template>

<script>
import { loadState } from '@nextcloud/initial-state'
import { generateUrl, generateOcsUrl } from '@nextcloud/router'
import axios from '@nextcloud/axios'
import { getCurrentUser } from '@nextcloud/auth'
import { showSuccess, showError } from '@nextcloud/dialogs'

import { delay } from '../utils'

export default {
	name: 'AdminSettings',

	components: {
	},

	props: [],

	data() {
		return {
			state: loadState('htmlwidget', 'admin-config'),
			saving: false,
			currentUser: getCurrentUser(),
			query: '',
			loadingUsers: false,
			suggestions: [],
		}
	},

	computed: {
	},

	watch: {
	},

	mounted() {
	},

	methods: {
		saveOptions(values) {
			this.saving = true
			const req = {
				values,
			}
			const url = generateUrl('/apps/htmlwidget/admin-config')
			axios.put(url, req)
				.then((response) => {
					showSuccess(t('htmlwidget', 'HtmlWidget admin options saved'))
				})
				.catch((error) => {
					showError(
						t('htmlwidget', 'Failed to save htmlwidget admin options')
						+ ': ' + (error.response?.request?.responseText ?? '')
					)
					console.debug(error)
				})
				.then(() => {
					this.saving = false
				})
		},
		asyncFind(query) {
			this.query = query
			if (query === '') {
				this.suggestions = []
				return
			}
			this.loadingUsers = true
			console.debug(query)
			const url = generateOcsUrl('core/autocomplete/get', 2).replace(/\/$/, '')
			axios.get(url, {
				params: {
					format: 'json',
					search: query,
					itemType: ' ',
					itemId: ' ',
					shareTypes: [],
				},
			}).then((response) => {
				console.debug(response)
				this.suggestions = response.data.ocs.data
			}).catch((error) => {
				console.error(error)
			}).then(() => {
				this.loadingUsers = false
			})
		},
		onContentHtmlChange() {
			delay(() => {
				this.saveOptions({ contentHtml: this.state.contentHtml })
			}, 2000)()
		},
		onWidgetTitleChange() {
			delay(() => {
				this.saveOptions({ widgetTitle: this.state.widgetTitle })
			}, 2000)()
		},
	},
}
</script>

<style scoped lang="scss">
#htmlwidget_prefs .icon {
	display: inline-block;
	width: 32px;
}

#htmlwidget_prefs .grid-form .icon {
	margin-bottom: -3px;
}

.grid-form label {
	line-height: 38px;
}

.grid-form input {
	width: 100%;
}

.grid-form {
	max-width: 500px;
	display: grid;
	grid-template: 1fr / 1fr 1fr;
	margin-left: 30px;

	> div {
		display: flex;
	}

	button {
		display: flex;
		width: 44px;
		span {
			margin-bottom: 0 !important;
		}
	}

	.support-user-name {
		line-height: 40px;
		margin: 0 10px 0 10px;
	}

	.settings-hint {
		margin: 0;
	}
}

::v-deep .support-avatar-option {
	margin-right: 10px;
}

.icon-htmlwidget {
	background-image: url(./../../img/app-dark.svg);
	background-size: 23px 23px;
	height: 23px;
	margin-bottom: -4px;
}

body.theme--dark .icon-htmlwidget {
	background-image: url(./../../img/app.svg);
}

</style>
