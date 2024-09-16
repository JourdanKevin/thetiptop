import './styles/style.scss';

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');


import { createApp } from 'vue';
import App from '@/App.vue';
import Router from '@js/routes.js'



createApp(App)
  .use(Router)
  .mount('#app');