import { createRouter, createWebHistory } from 'vue-router';


import Home from '@views/Home.vue';
import About from '@views/About.vue';
import Prize from '@views/Prize.vue';
import Faq from '@views/Faq.vue';
import Login from '@views/Login.vue';
import Register from '@views/Register.vue';
import AdminConcours from '@views/AdminConcours.vue';
import AdminPrize from '@views/AdminPrize.vue';
import AdminUsers from '@views/AdminUsers.vue';
import AdminShowUser from '@views/AdminShowUser.vue';
import MyAccount from '@views/MyAccount.vue';
import MyAccountEdit from '@views/MyAccountEdit.vue';
import MyPrize from '@views/MyPrize.vue';
import Ticket from '@views/Ticket.vue';
import AdminEditPrize from '@views/AdminEditPrize.vue';
import AdminShowPrize from '@views/AdminShowPrize.vue';
import AdminShowConcours from '@views/AdminShowConcours.vue';
import AdminEditConcours from '@views/AdminEditConcours.vue';
import MentionLegal from '@views/MentionLegal.vue';
import Page404 from '@views/Page404.vue';



const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/about', name: 'about', component: About },
  { path: '/prize', name: 'prize', component: Prize },
  { path: '/faq', name: 'faq', component: Faq },
  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/admin/concours', name: 'adminconcours', component: AdminConcours },
  { path: '/admin/concours/create', name: 'adminconcourscreate', component: AdminEditConcours },
  { path: '/admin/concours/edit/:id', name: 'adminconcoursedit', component: AdminEditConcours },
  { path: '/admin/concours/show/:id', name: 'adminconcoursshow', component: AdminShowConcours },
  { path: '/admin/prize', name: 'adminprize', component: AdminPrize },
  { path: '/admin/prize/create', name: 'adminprizecreate', component: AdminEditPrize },
  { path: '/admin/prize/edit/:id', name: 'adminprizeedit', component: AdminEditPrize },
  { path: '/admin/prize/show/:id', name: 'adminprizeshow', component: AdminShowPrize },
  { path: '/admin/users', name: 'adminusers', component: AdminUsers },
  { path: '/admin/users/show/:id', name: 'adminusersshow', component: AdminShowUser },
  { path: '/myaccount', name: 'myaccount', component: MyAccount },
  { path: '/myaccount/edit', name: 'myaccountedit', component: MyAccountEdit },
  { path: '/myprize', name: 'myprize', component: MyPrize },
  { path: '/admin/ticket', name: 'ticket', component: Ticket },
  { path: '/legalNotice', name: 'mentionlegal', component: MentionLegal },
  { path: '/:pathMatch(.*)*', name: 'page404', component: Page404 },
  
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
});

export default router;
