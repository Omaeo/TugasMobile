import { createApp } from 'vue'
import App from './App.vue'
import router from './router';

import { IonicVue } from '@ionic/vue';

/* Core CSS required for Ionic components to work properly */
import '@ionic/vue/css/core.css';

/* Basic CSS for apps built with Ionic */
import '@ionic/vue/css/normalize.css';
import '@ionic/vue/css/structure.css';
import '@ionic/vue/css/typography.css';

/* Optional CSS utils that can be commented out */
import '@ionic/vue/css/padding.css';
import '@ionic/vue/css/float-elements.css';
import '@ionic/vue/css/text-alignment.css';
import '@ionic/vue/css/text-transformation.css';
import '@ionic/vue/css/flex-utils.css';
import '@ionic/vue/css/display.css';

/**
 * Ionic Dark Mode
 * -----------------------------------------------------
 * For more info, please see:
 * https://ionicframework.com/docs/theming/dark-mode
 */

/* @import '@ionic/vue/css/palettes/dark.always.css'; */
/* @import '@ionic/vue/css/palettes/dark.class.css'; */
import '@ionic/vue/css/palettes/dark.system.css';

/* Theme variables */
import './theme/variables.css';

const app = createApp(App)
  .use(IonicVue)
  .use(router);

router.isReady().then(() => {
  app.mount('#app');
});


//cek token + redirect to login if token is invalid
import { Preferences } from '@capacitor/preferences';
import { jwtDecode } from 'jwt-decode';

async function checkToken() {
  const { value } = await Preferences.get({ key: 'token' });
  
  if (!value) {
    router.push('/tabs/login');
    return;
  }

  try {
    const decoded = jwtDecode(value);
    const now = Date.now() / 1000;

    // pastikan exp ada di token
    if (!decoded.exp || decoded.exp < now) {
      await Preferences.remove({ key: 'token' });
      router.push('/tabs/login');
    }
  } catch (err) {
    console.error("Invalid token:", err);
    router.push('/tabs/login');
  }
}

checkToken();


