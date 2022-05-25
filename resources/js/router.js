import { createWebHistory, createRouter } from "vue-router";

// Data Store
import { authState } from './store/authState.js';

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
                name: 'password.request',
                path: 'password/request',
                component: Email,
                meta:{
                    requiresAuth: false,
                    title: `Forgot Password`
                }
            }, {
                name: 'password.reset',
                path: 'password/reset/:token/:email',
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
                    requiresAuth: true,
                    title: `Confirm Password`
                }
            }, {
                name: 'verification.notice',
                path: 'email/verify',
                component: Verify,
                meta:{
                    requiresAuth: true,
                    title: `Email Verification`
                }
            }, {
                name: 'verification.verify',
                path: 'email/verify/confirm',
                component: Verify,
                meta:{
                    requiresAuth: true,
                    title: `Email Verification`
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
            {
                name: 'home',
                path: 'home',
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
                    requiresAuth: true,
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
    document.title = `${to.meta.title}`;
    const store = authState();
    
    // Route that required authenticated
    if (to.meta.requiresAuth && !store.isLoggedIn) {
        return next({name: "login"});
    }

    // Route do not visit after login
    if (store.isLoggedIn && ['login', 'register'].includes(to.name)) {
        return next({name: "dashboard"});
    }
    
    // Route that user need verify their account
    if (store.isLoggedIn && !store.auth.hasVerifiedEmail && to.name == 'verification.verify') {
        return next();
    }

    // Route if user not verified
    if (store.isLoggedIn && !store.auth.hasVerifiedEmail && !['verification.notice'].includes(to.name)) {
        return next({name: "verification.notice"});
    }

    return next();
  });

export default router;