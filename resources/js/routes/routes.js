import Vue from 'vue';
import VueRouter from 'vue-router';
//Views
import Home from '../views/Home';
import Products from '../views/Products';
import Categories from '../views/Categories';
import Manufacturers from '../views/Manufacturers';
import Suppliers from '../views/Suppliers';
import Customers from '../views/Customers';
import Sales from '../views/Sales';
import Purchases from '../views/Purchases';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/products',
    name: 'Products',
    component: Products,
  },
  {
    path: '/categories',
    name: 'Categories',
    component: Categories,
  },
  {
    path: '/manufacturers',
    name: 'Manufacturers',
    component: Manufacturers,
  },
  {
    path: '/suppliers',
    name: 'Suppliers',
    component: Suppliers,
  },
  {
    path: '/customers',
    name: 'Customers',
    component: Customers,
  },
  {
    path: '/sales',
    name: 'Sales',
    component: Sales,
  },
  {
    path: '/purchases',
    name: 'Purchases',
    component: Purchases,
  },
  // {
  //   path: '/about',
  //   name: 'About',
  //   // route level code-splitting
  //   // this generates a separate chunk (about.[hash].js) for this route
  //   // which is lazy-loaded when the route is visited.
  //   component: () => import(/* webpackChunkName: "about" */ '../views/About.vue'),
  // },
];

const router = new VueRouter({
  routes,
});

export default router;
