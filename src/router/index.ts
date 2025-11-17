import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';
import TabsPage from '../views/TabsPage.vue';
import { Preferences } from '@capacitor/preferences';
import { jwtDecode } from 'jwt-decode';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    redirect: '/login' // arahkan langsung ke login
  },
  {
    path: '/login',
    component: () => import('@/views/Login.vue')
  },
  {
    path: '/tabs/',
    component: TabsPage,
    children: [
      {
        path: '',
        redirect: '/tabs/tab1'
      },
      {
        path: 'tab1',
        component: () => import('@/views/Tab1Page.vue')
      },
      {
        path: 'tab2',
        component: () => import('@/views/Tab2Page.vue')
      },
      {
        path: 'tab3/:id',
        component: () => import('@/views/Tab3Page.vue')
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

//  Route Guard
router.beforeEach(async (to, from, next) => {
  const publicPages = ['/login']; // hanya /login yg bebas
  const authRequired = !publicPages.includes(to.path);

  const { value: token } = await Preferences.get({ key: 'token' });

  if (!authRequired) {
    next();
    return;
  }

  if (!token) {
    next('/login');
    return;
  }

  try {
    const decoded: any = jwtDecode(token);
    const now = Date.now() / 1000;

    if (decoded.exp && decoded.exp > now) {
      next();
    } else {
      await Preferences.remove({ key: 'token' });
      next('/login');
    }
  } catch (err) {
    console.error('Invalid token:', err);
    await Preferences.remove({ key: 'token' });
    next('/login');
  }
});

export default router;
