<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Tab 2</ion-title>
      </ion-toolbar>
    </ion-header>
<ion-content :fullscreen="true">
      <ion-card style="width: 70%; height: 50%; margin: 2rem auto; padding: 20px;">
        <ion-card-header>
          <ion-card-title style="font-size: 30px; font-weight: bold; text-align: center;">Post Artikel</ion-card-title>
        </ion-card-header>

        <ion-card-content style="display: flex; flex-direction: column; ">
          <ion-item>
            <ion-input label="judul" label-placement="stacked" placeholder="judul" v-model="judul"></ion-input>
          </ion-item>
          <ion-item>
            <ion-textarea label="deskripsi" label-placement="stacked" placeholder="deskripsi"
              v-model="deskripsi"></ion-textarea>
          </ion-item>

          <p v-if="errorMessage" style="margin-top: 10px; text-align: center; color: red">{{ errorMessage }}</p>

          <ion-button expand="block" @click="handlePost" style="margin-top: 50px; width: 100%;"
            :disabled="isPosting || deskripsi.length === 0 || judul.length === 0">
            <ion-spinner v-if="isPosting" name="crescent"></ion-spinner>
            {{ isPosting ? 'Posting...' : 'Post' }}
          </ion-button>

        </ion-card-content>
      </ion-card>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent, IonTextarea, IonItem, IonButton, IonSpinner, IonInput, alertController } from '@ionic/vue';

const router = useRouter();

// State untuk formulir
const judul = ref('');
const deskripsi = ref('');
const errorMessage = ref('');
const isPosting = ref(false);

const insertApiUrl = 'http://localhost/server_side/post.php'; // Ganti URL API Anda

const currentUserId = localStorage.getItem('user_token');

const showAlert = async (header: string, message: string) => {
  const alert = await alertController.create({
    header,
    message,
    buttons: ['OK'],
  });
  await alert.present();
};

const handlePost = async () => {
  errorMessage.value = '';
  isPosting.value = true;

  if (!currentUserId) {
    await showAlert("Error", "Anda harus login untuk memposting.");  
    router.replace('tabs/login');
    isPosting.value = false;
    return;
  }

  // VAlIDASI TAMBAHAN: Cek judul
  if (judul.value.trim().length === 0) {
    errorMessage.value = 'Judul artikel tidak boleh kosong.';
    isPosting.value = false;
    return;
  }

  // VALIDASI AWAL ANDA: Cek deskripsi
  if (deskripsi.value.trim().length === 0) {
    errorMessage.value = 'Isi artikel tidak boleh kosong.';
    isPosting.value = false;
    return;
  }

  try {
    const response = await axios.post(insertApiUrl, {
      user_id: currentUserId,
      judul: judul.value, // <-- KIRIMKAN judul
      deskripsi: deskripsi.value
    });

    if (response.data.success) {
      await showAlert("Sukses", "Artikel berhasil diposting!");
      // BERSIHKAN KEDUA FIELD setelah sukses
      judul.value = '';
      deskripsi.value = '';
      router.replace('/tabs/home');
    } else {
      errorMessage.value = response.data.message || 'Gagal menyimpan artikel.';
    }

  } catch (error) {
    if (axios.isAxiosError(error) && error.response) {
      errorMessage.value = error.response.data.message || 'Terjadi kesalahan pada server.';
    } else {
      errorMessage.value = 'Gagal terhubung ke server. Periksa koneksi Anda.';
    }
  } finally {
    isPosting.value = false;
  }
};
</script>
