<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-buttons slot="start">
          <ion-back-button default-href="/tabs/tab1"></ion-back-button>
        </ion-buttons>
        <ion-title>Edit Post</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content :fullscreen="true">
      <ion-list>
        <ion-item>
          <ion-label position="stacked">Judul</ion-label>
          <ion-input v-model="judul" placeholder="Masukkan judul" />
        </ion-item>

        <ion-item>
          <ion-label position="stacked">Deskripsi</ion-label>
          <ion-textarea v-model="deskripsi" :autoGrow="true" placeholder="Masukkan deskripsi" /> 
        </ion-item>

        <ion-item lines="none">
          <ion-button expand="block" color="success" @click="updatePost">
            V Simpan Perubahan
          </ion-button>
        </ion-item>

        <ion-item lines="none">
          <ion-button expand="block" color="medium" @click="router.push('/tabs/tab1')">
            X Batal
          </ion-button>
        </ion-item>
      </ion-list>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonButton,
  IonInput,
  IonItem,
  IonLabel,
  IonList,
  IonTextarea,
  IonBackButton,
  IonButtons
} from '@ionic/vue';
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const idpost = ref<number | null>(null);
const judul = ref('');
const deskripsi = ref('');

const apiGet = 'http://localhost/server_side/read-post.php'; // etching post by ID
const apiUpdate = 'http://localhost/server_side/update-post.php';

//  Get ID route
onMounted(async () => {
  idpost.value = Number(route.params.id); //  THIS is where read the ID
  console.log('Loaded post ID:', idpost.value);

  if (!idpost.value) {
    alert('Invalid post ID!');
    router.push('/tabs/tab1');
    return;
  }

  try {
    const response = await axios.get(`${apiGet}?idpost=${idpost.value}`);
    const post = response.data;

    if (post) {
      judul.value = post.judul;
      deskripsi.value = post.deskripsi;
    } else {
      alert('Post not found.');
      router.push('/tabs/tab1');
    }
  } catch (error) {
    console.error('Error loading post:', error);
  }
});

//  Update post
const updatePost = async () => {
  try {
    const response = await axios.post(apiUpdate, {
      idpost: idpost.value,
      judul: judul.value,
      deskripsi: deskripsi.value,
    });

    if (response.data.success) {
      alert('Post updated successfully!');
      router.push('/tabs/tab1');
    } else {
      alert('Failed to update post.');
    }
  } catch (error) {
    console.error('Error updating post:', error);
  }
};
</script>
