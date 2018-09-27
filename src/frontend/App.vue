<template>
    <div id="vue-frontend-app">
        <h2>Your Vue frontend app</h2>
		<div class="message-wrapper">
			<div class="description">Message from settings page:</div>
			<div class="message">{{ message }}</div>
		</div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
	name: 'App',
	data () {
		return {
			message: 'loading...'
		}
	},
	mounted () {
		// Perform API call
		axios
			// Call REST API endpoint (local URL)
			.get('?rest_route=/plugin-vue-starter/v1/message')
			.then(response => {
				// Read message string from response's data JSON
				this.message = JSON.parse(response.data).message
			})
			.catch(err => console.log(err))
	}
}
</script>

<style lang="scss" scoped>
	// Styles in SASS format and scoped to this component

	#vue-frontend-app {
		border: 1px dotted red;

		.message-wrapper {
			background-color: #eee;

			.description {
				font-style: italic;
				display: inline;
			}

			.message {
				font-weight: bold;
				display: inline;
			}

		}
	}

</style>
