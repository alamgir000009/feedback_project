import { createApp } from 'vue/dist/vue.esm-bundler.js';
import App from './App.vue';
import router from './router';
import axios from 'axios'
import moment from 'moment';
import VueAxios from 'vue-axios'

const app = createApp(App);

app.use(router);
app.use(VueAxios, axios);

const token = window.localStorage.getItem('auth_sanctum_token');

var baseUrl = window.location.origin;
axios.defaults.baseURL = baseUrl + '/api/';

axios.interceptors.request.use(function (config) {
    let auth_sanctum_token = window.localStorage.getItem('auth_sanctum_token');
    if (auth_sanctum_token) {
        config.headers['Authorization'] = 'Bearer ' + auth_sanctum_token;
    }
    return config;
}, function (error) {
    return Promise.reject(error);
});

app.config.globalProperties.$laravelErrors = function (error) {
    const flattenedErrors = {};
    if (error.response.status === 422) {
        for (const field in error.response.data.message) {

            if (Array.isArray(error.response.data.message[field])) {
                flattenedErrors[field] = error.response.data.message[field][0];

                const elements = document.querySelectorAll(`[name="${field}"]`);

                elements.forEach(element => {
                    element.classList.add('is-invalid');
                });
            }
        }
    }
    else if (error.response.status === 421) {
        flattenedErrors['message'] = error.response.data.message;
    }
    return flattenedErrors;
}

app.config.globalProperties.$formatWithLaravelDate = function (date) {
    // Convert the date from Laravel to a moment.js object
    const dateObject = moment(date, 'YYYY-MM-DD HH:mm:ss');

    // Format the date in the desired format
    return dateObject.format('MM-DD-YYYY, hh:MM:SS A');
}

app.mount('#app');

