require('./bootstrap');

// import VueRouter from 'vue-router';


window.Vue = require('vue');

window.Fire = new Vue();
import moment from 'moment';


import VueRouter from 'vue-router'
Vue.use(VueRouter);

import swal from 'sweetalert2';
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MM-DD-YYYY')
    }
});
Vue.component('table-component', require('./components/TableComponent.vue').default);


let routes = [

    // { path: '/admin/', name: 'home', component: require('./components/Index.vue').default },
    // { path: 'admin/book/edit/:id', name: 'edit', component: require('./components/Edit.vue').default },
    // { path: '/admin/book/create', name: 'create', component: require('./components/Create.vue').default },
    // { path: '/admin/book/:id', name: 'detail', component: require('./components/Detail.vue').default },
    // { path: '/admin/external-books/', name: 'external', component: require('./components/ExternalBook.vue').default },

    { path: '/admin/', name: 'home', component: require('./components/Index.vue').default },
    { path: 'admin/task/edit/:id', name: 'edit', component: require('./components/Edit.vue').default },
    { path: '/admin/task/create', name: 'create', component: require('./components/Create.vue').default },
    { path: '/admin/task/:id', name: 'detail', component: require('./components/Detail.vue').default },
]


const router = new VueRouter({
    routes,
    mode: 'history'
})

const app = new Vue({
    el: '#app',
    router
});
