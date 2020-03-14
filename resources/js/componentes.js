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

//------ pageadress -----
import PageAdress from './components/backoffice/PageAdress.vue';
Vue.component('page-adress', PageAdress);

//------ ViewServico -----
import ViewServico from './components/backoffice/ViewServico.vue';
Vue.component('view-service', ViewServico);

//----- dropdown-notifications -------
import Navbar from './components/backoffice/Navbar.vue';
Vue.component('dropdown-notifications', Navbar);


//------------ Fire -----------
window.Fire =  new Vue();

//------- vuelidate p/ validacao
import Vuelidate from "vuelidate";
Vue.use(Vuelidate);




