//----- format date - moment --------
import moment from 'moment';
Vue.filter('dateConversor',function(created){
  return moment(created).format('MMMM Do YYYY');
});

//--------- form e alertas
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

// ---------- senas d TOAST alertas
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2) //fazer toast ficar global

//------------ progress bar
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})

//------------ pagination --------
Vue.component('pagination', require('laravel-vue-pagination'));

//---------- passaport -----------
Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default
);
