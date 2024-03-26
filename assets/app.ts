import {createApp} from 'vue';

const app = createApp({});

app.component('main-page', require('@js/components/MainPage.vue').default);
app.component('main-header', require('@js/components/partials/MainHeader.vue').default);

app.mount('#app');
