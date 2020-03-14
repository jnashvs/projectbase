import Cliente from './components/backoffice/Cliente.vue';
import Fornecedor from './components/backoffice/Fornecedor.vue';
import Dash from './components/backoffice/Dash.vue';
import Servico from './components/backoffice/Servico.vue';
import Produto from './components/backoffice/Produto.vue';


//import Login from './components/backoffice/auth/Login.vue';


/*import Login from './components/backoffice/auth/Login'
import Logout from './components/backoffice/auth/Logout'
import Register from './components/backoffice/auth/Register'

meta: {
      requiresVisitor: true,
    }
    meta: {
      requiresAuth: true,
    }
*/

// 2. criar e declarar router
let routes = [
  { path: '/cliente', component: Cliente },
  { path: '/fornecedor', component: Fornecedor },
  { path: '/servico', component: Servico },
  { path: '/produtos', component: Produto },
  { path: '/home/', component: Dash },
  //{ path: '/login', component: Login }

]

export default routes
