/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default
import 'vx-easyui/dist/themes/metro/easyui.css'
import 'vx-easyui/dist/themes/icon.css'
import 'vx-easyui/dist/themes/vue.css'
import '../css/app.css'
import '../js/main.js'
import VueRouter from 'vue-router'
import EasyUI from 'vx-easyui'
Vue.use(VueRouter).use(EasyUI)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// ============= START COMPONENTS APP =====================
Vue.component('dark-mode-switcher-component', require('./components/app/DarkModeSwitcher.vue').default);
Vue.component('main-color-switcher-component', require('./components/app/MainColorSwitcher.vue').default);
Vue.component('mobile-menu-component', require('./components/app/MobileMenu.vue').default);
Vue.component('top-bar-component', require('./components/app/TopBar.vue').default);
// ============= END COMPONENTS APP =======================

// ============= START COMPONENTS USER ====================
Vue.component('user-datagrid-component', require('./components/user/UserDatagrid.vue').default);
Vue.component('addview-user-component', require('./components/user/AddView.vue').default);
Vue.component('editview-user-component', require('./components/user/EditView.vue').default);
// ============= END COMPONENTS USER ======================

const Users = require('./pages/User.vue').default
const About = require('./pages/About.vue').default

const routes = [
    {
        path: '/user',
        component: Users
    },
    {
        path: '/about',
        component: About
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
