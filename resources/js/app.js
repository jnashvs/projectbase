
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'

import _ from 'lodash'
Vue.use(VueRouter)

//-------- vuetify -------------
import Vuetify from 'vuetify'

Vue.use(Vuetify)
//const opts = {}

require('./componentes'); // ------- txoma td componentes

// 1. importar rotas to vue
import routes from './routes'

// 2. registar router
const router = new VueRouter({
  mode: 'history',
  routes
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// import { store } from './store/store'

const app = new Vue({
  el: '#app',
  //store: store,
  data: {
    unreads: '',
    userId: ''
  },
  router,
  //render: app => app(App)
  vuetify: new Vuetify(),

});

export default app;
