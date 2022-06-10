import { createWebHistory, createRouter } from "vue-router";

// Data Store
import { authState } from './src/store/authState.js';

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

// Dashboard
import Dashboard from "./pages/dashboard/Dashboard.vue";

// Manage Account
import Profile from "./pages/account/Profile.vue";
import ChangePassword from "./pages/account/ChangePassword.vue";
import SocialLink from "./pages/account/SocialLink.vue";

// Manage Post
import MyPost from "./pages/post/MyPost.vue";
import Post from "./pages/post/Post.vue";
import PostCreate from "./pages/post/Create.vue";

// Outter Page
import Landing from "./pages/landing/Landing.vue";

const routes = [
    /*
    * Auth Routes
    */
    {
        path: "/auth",
        component: AuthTemplate,
        redirect: { name: 'login' },
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
        name: 'home',
        component: AuthTemplate,
        children: [
            {
                name: 'landing',
                path: '',
                alias: ['/home', '/landing'],
                component: Landing,
                meta:{
                    requiresAuth: false,
                    title: `Landing Page`
                }
            },
        ],
    }, 
    
    /*
    * Dashboard Routes
    */
    {
        path: "/dashboard",
        redirect: { name: 'dashboard' },
        component: DashboardTemplate,
        children: [
            {
                name: 'dashboard',
                path: 'index',
                component: Dashboard,
                meta:{
                    requiresAuth: true,
                    title: `Dashboard`
                }
            }, 
        ],
       
    },

    /*
    * Post Routes
    */
    {
        path: "/mypost",
        component: DashboardTemplate,
        redirect: { name: 'mypost' },
        children: [
            {
                name: 'mypost',
                path: 'index',
                component: MyPost,
                meta:{
                    requiresAuth: true,
                    title: `My Post`
                }
            }, 
        ],
       
    },

    /*
    * Manage Account Routes
    */
    {
        path: "/manage/account",
        name: 'account',
        component: DashboardTemplate,
        redirect: { name: 'account.profile' },
        children: [
            {
                name: 'account.profile',
                path: 'profile',
                component: Profile,
                meta:{
                    requiresAuth: true,
                    title: `Profile`
                }
            }, 
            {
                name: 'account.password',
                path: 'password',
                component: ChangePassword,
                meta:{
                    requiresAuth: true,
                    title: `Change Password`
                }
            }, 
            {
                name: 'account.social',
                path: 'social',
                component: SocialLink,
                meta:{
                    requiresAuth: true,
                    title: `Social Link`
                }
            }, 
        ],
    },

    /*
    * Manage Post Routes
    */
    {
        path: "/manage/post",
        name: 'post',
        component: DashboardTemplate,
        redirect: { name: 'post.index' },
        children: [
            {
                name: 'post.index',
                path: 'index',
                component: Post,
                meta:{
                    requiresAuth: true,
                    title: `Manage Post`
                }
            }, 
            {
                name: 'post.create',
                path: 'create',
                component: PostCreate,
                meta:{
                    requiresAuth: true,
                    title: `Create Post`
                }
            }, 
            {
                name: 'post.update',
                path: 'update/:id',
                component: Post,
                meta:{
                    requiresAuth: true,
                    title: `Update Post`
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