import '../styles/app.css';

const imagesContext = require.context('../img/', false, /\.(png|jpe?g|svg)$/);
imagesContext.keys().forEach(imagesContext);

import { createApp } from 'vue'
import App from '../vue/App.vue'

createApp(App).mount('#app')