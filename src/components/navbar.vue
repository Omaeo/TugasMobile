<template>
  <ion-header>
    <ion-toolbar color="primary">
      <ion-title>My App</ion-title>
      <ion-buttons slot="end">
        <ion-button @click="logout">
          <ion-icon name="log-out-outline"></ion-icon>
          Logout
        </ion-button>
      </ion-buttons>
    </ion-toolbar>
  </ion-header>
</template>

<script setup lang="ts">
import { IonHeader, IonToolbar, IonTitle, IonButtons, IonButton, IonIcon } from '@ionic/vue';
import { Preferences } from '@capacitor/preferences';
import { useRouter } from 'vue-router';

const router = useRouter();

const logout = async () => {
  await Preferences.remove({ key: 'token' }); // hapus token JWT
  localStorage.removeItem('isLoggedIn'); // kalau kamu pakai ini juga
  router.push('/login'); // redirect ke login
};
</script>
