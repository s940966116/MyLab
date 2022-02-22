import Vue from 'vue';
import VueRouter from 'vue-router';
import $ from 'jquery';

//登入
import Login from './components/login.vue';
//首頁
import Home from './components/home.vue';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: Login,
        name: 'login',
    },
    {
        path: '/home',
        component: Home,
        name: 'home',
    }
];

const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    axios.get('checkLoginSession')
        .then((response) => {
            if(response.data.ok){
                if(to.name == 'login'){
                    next({ name: 'home' });
                } else {
                    next();
                }
            }else{
                if(to.name == 'login'){
                    next();
                } else {
                    next({ name: 'login' });
                }
            }
        }).catch((err) => {

        })
})

export default router;