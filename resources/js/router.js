import { createWebHistory, createRouter } from "vue-router";

// Auth
import Login from "./pages/auth/Login.vue";
import Register from "./pages/auth/Register.vue";
import Verify from "./pages/auth/Verify.vue";
import Email from "./pages/auth/password/Email.vue";
import Reset from "./pages/auth/password/Reset.vue";
import Confirm from "./pages/auth/password/Confirm.vue";

// Base Component
import AuthTemplate from "./layouts/AuthTemplate.vue";
import DashboardTemplate from "./layouts/DashboardTemplate.vue";

// Inner Page
import Dashboard from "./pages/Dashboard.vue";

// Outter Page
import Landing from "./pages/Landing.vue";

const routes = [
    /*
    * Auth Routes
    */
    {
        path: "/auth",
        component: AuthTemplate,
        children: [
            {
                name: 'login',
                path: 'login',
                component: Login,
                meta:{
                    requiresAuth: false,
                    title: `Login`
                }
            }, {
                name: 'register',
                path: 'register',
                component: Register,
                meta:{
                    requiresAuth: false,
                    title: `Register`
                }
            }, {
                name: 'password.email',
                path: 'email',
                component: Email,
                meta:{
                    requiresAuth: false,
                    title: `Forgot Password`
                }
            }, {
                name: 'password.reset',
                path: 'email/:token',
                component: Reset,
                meta:{
                    requiresAuth: false,
                    title: `Reset Password`
                }
            }, {
                name: 'password.confirm',
                path: 'confirm',
                component: Confirm,
                meta:{
                    requiresAuth: false,
                    title: `Confirm Password`
                }
            }, {
                name: 'verify',
                path: 'verify',
                component: Verify,
                meta:{
                    requiresAuth: false,
                    title: `Reset Password`
                }
            },
        ], 
    }, 
    
    /*
    * Front Page Routes
    */
    {
        path: "/",
        component: AuthTemplate,
        children: [
            {
                name: 'landing',
                path: '',
                component: Landing,
                meta:{
                    requiresAuth: false,
                    title: `Landing Page`
                }
            }, 
        ],
    }, 
    
    /*
    * Inner Page Routes
    */
    {
        path: "/dashboard",
        component: DashboardTemplate,
        children: [
            {
                name: 'dashboard',
                path: '',
                component: Dashboard,
                meta:{
                    requiresAuth: false,
                    title: `Dashboard`
                }
            }, 
        ],
       
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    // if (to.matched.some((record) => record.meta.requiresAuth)) {
    //   if (Store.getters["auth/getAuthenticated"]) {
    //     next();
    //     return;
    //   }
    //   next("/");
    // } else {
    //   next();
    // }
    // console.log("Hello World", this.$router.currentRoute.meta.title);
    
    document.title = `${to.meta.title}`;
    next();
  });

export default router;