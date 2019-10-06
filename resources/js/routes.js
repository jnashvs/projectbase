import Cliente from './components/Cliente.vue';
import Funcionario from './components/Funcionario.vue';
import Home from './components/Home.vue';
import Passport from './components/Passport.vue';

/*import Login from './components/auth/Login'
import Logout from './components/auth/Logout'
import Register from './components/auth/Register'

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
  { path: '/funcionario', component: Funcionario },
  { path: '/passport', component: Passport },
  { path: '/home', component: Home }
]

export default routes
