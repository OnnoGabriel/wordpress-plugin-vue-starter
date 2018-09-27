import Vue from 'vue'
import App from './App.vue'

// Prevent the production tip on Vue startup.
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
	el: '#vue-frontend-app',
	render: h => h(App)
})
