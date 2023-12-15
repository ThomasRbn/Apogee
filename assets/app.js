import '@css/global.scss';

import { createApp } from 'vue';
import MainHeader from "@js/components/MainHeader.vue";
import MainPage from "@js/components/MainPage.vue";

const app = createApp({});
app.component('main-header', MainHeader);
app.component('main-page', MainPage);
app.mount('#app');



