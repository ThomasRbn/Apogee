import '@css/global.scss';

import {createApp} from 'vue';
import MainHeader from "@js/components/MainHeader.vue";
import MainPage from "@js/components/MainPage.vue";
import ProductIndex from "@js/components/product/ProductIndex.vue";
import ProductShow from "@js/components/product/ProductShow.vue";
import ProductNew from "@js/components/product/ProductNew.vue";

const app = createApp({});

app.component('main-header', MainHeader);
app.component('main-page', MainPage);
app.component('product-index', ProductIndex);
app.component('product-show', ProductShow);
app.component('product-new', ProductNew)
app.mount('#app');



