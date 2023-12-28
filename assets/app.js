import '@css/global.scss';

import {createApp} from 'vue';

const app = createApp({});

app.component('main-header', require('@js/components/MainHeader.vue').default);
app.component('main-page', require('@js/components/MainPage.vue').default);

//Product
app.component('product-index', require('@js/components/product/ProductIndex.vue').default);
app.component('product-show', require('@js/components/product/ProductShow.vue').default);
app.component('product-new', require('@js/components/product/ProductNew.vue').default);
app.component('product-edit', require('@js/components/product/ProductEdit.vue').default);

//User
app.component('user-register', require('@js/components/user/UserRegister.vue').default);
app.component('user-login', require('@js/components/user/UserLogin.vue').default);
app.component('user-edit', require('@js/components/user/UserEdit.vue').default);
app.mount('#app');



