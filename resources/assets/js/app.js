/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Componentes Vue
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('create-category', require('./components/category/CreateCategory.vue'));

Vue.component('category-list', require('./components/category/CategoryList.vue'));

const app = new Vue({
    el: '#inventory'
});