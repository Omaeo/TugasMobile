<template>
  <ion-page>
    <navbar></navbar>
    <ion-content :fullscreen="true">
      <ion-card style="width: 70%; height: 50%; margin: 2rem auto; padding: 20px;">
        <ion-card-header>
          <ion-card-title
            style="font-size: 30px; font-weight: bold; text-align: center;"
          >Login</ion-card-title>
        </ion-card-header>

        <ion-card-content style="display: flex; flex-direction: column;">
          <ion-item>
            <ion-input
              label="Username"
              label-placement="stacked"
              placeholder="Enter your username"
              v-model="username"
            ></ion-input>
          </ion-item>

          <ion-item>
            <ion-input
              label="Password"
              label-placement="stacked"
              placeholder="Enter your password"
              type="password"
              v-model="password"
            ></ion-input>
          </ion-item>

          <p v-if="errorMessage" style="margin-top: 10px; text-align: center; color: red">
            {{ errorMessage }}
          </p>

          <ion-button
            expand="block"
            @click="handleLogin"
            style="margin-top: 50px; width: 100%;"
            :disabled="isLoggingIn"
          >
            <ion-spinner v-if="isLoggingIn" name="crescent"></ion-spinner>
            {{ isLoggingIn ? 'Logging in...' : 'Login' }}
          </ion-button>
        </ion-card-content>
      </ion-card>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import {
  IonPage, IonContent, IonCard, IonCardHeader, IonCardTitle, IonCardContent,
  IonItem, IonInput, IonButton, IonSpinner
} from '@ionic/vue';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { Preferences } from '@capacitor/preferences';

const router = useRouter();
const username = ref('');
const password = ref('');
const errorMessage = ref('');
const isLoggingIn = ref(false);
const api = 'http://localhost/server_side/login.php';

const handleLogin = async () => {
  errorMessage.value = '';
  isLoggingIn.value = true;

  if (!username.value || !password.value) {
    errorMessage.value = 'Please enter both username and password.';
    isLoggingIn.value = false;
    return;
  }

  try {
    const response = await axios.post(api, {
      username: username.value,
      password: password.value
    });

    if (response.data.success) {
      const token = response.data.token;

      console.log(' JWT Token:', token);

      // simpan token di Preferences agar bisa dibaca guard
      await Preferences.set({ key: 'token', value: token });

      // redirect ke tab utama
      await router.replace('/tabs/tab1');
    } else {
      errorMessage.value = response.data.message || 'Login failed. Please try again.';
    }
  } catch (error) {
    console.error('Login error:', error);
    errorMessage.value = 'An error occurred. Please try again later.'; 
  } finally {
    isLoggingIn.value = false;
  }
};
</script>
