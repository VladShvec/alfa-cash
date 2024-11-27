import { createApp } from 'vue';
import App from './App.vue';
import cors from 'cors'
const app = createApp(App);
app.use(cors);
app.mount('#app');
