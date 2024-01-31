import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { 
            path: '/',
            component: () => import('../views/Landing.vue'),
            name: 'Landing', meta: { auth_required: false } 
        },
        { 
            path: '/register',
            component: () => import('../views/Register.vue'),
            name: 'Register', meta: { auth_required: false } 
        },
        { 
            path: '/login',
            component: () => import('../views/Login.vue'),
            name: 'Login', meta: { auth_required: false } 
        },
        { 
            path: '/feedback-form',
            component: () => import('../views/FeedbackForm.vue'),
            name: 'FeedbackForm',
            meta: { auth_required: true } 
        },
        { 
            path: '/feedback-list',
            component: () => import('../views/FeedbackList.vue'),
            name: 'FeedbackList',
            meta: { auth_required: true } 
        },
        { 
            path: '/feedback-details/:id',
            component: () => import('../views/FeedbackView.vue'),
            name: 'FeedbackView',
            meta: { auth_required: true } 
        },
        { 
            path: '/:catchAll(.*)',
            component: () => import('../views/Error.vue'),
            meta: { auth_required: false } 
        },
    ]
});

router.beforeEach((to, from, next) => {
    const isLoggedIn = localStorage.getItem('auth_sanctum_token') !== null;

    // If user is already logged in and trying to access login or register, redirect to home
    if (isLoggedIn && (to.name === 'Login' || to.name === 'Register')) {
        next('/feedback-form');
    } else if (to.meta.auth_required && !isLoggedIn) {
        // If authentication is required and user is not logged in, redirect to login
        next('/login');
    } else {
        // Allow access to the route
        next();
    }
});

export default router;
