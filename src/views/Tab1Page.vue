<template>
  <ion-page>
    <navbar></navbar>
    <ion-content>
      <div style="text-align: center; margin-top: 3rem;">
        <h1 style="font-size: 40px;">Posts</h1>
      </div>

      <ion-buttons slot="end" style="display: flex; justify-content: center;">
        <ion-button color="primary" style="margin-top: 2rem;" @click="() => router.push('/tabs/tab2')">
          ➕ Post Artikel
        </ion-button>
      </ion-buttons>

      <ion-card v-for="post in posts" :key="post.idpost" style="margin: 2rem; padding: 1rem;">
        <ion-card-header>
          <ion-card-title style="font-size: 1.7rem; font-weight: bold;">{{ post.judul }}</ion-card-title>
        </ion-card-header>

        <ion-card-content>
          <div class="truncate">{{ post.deskripsi }}</div>
        </ion-card-content>

        <div style="display: flex; justify-content: flex-end; gap: 10px; padding-right: 1rem;">
          <!-- Edit -->
          <ion-button color="success" @click="() => router.push(`/tabs/tab3/${post.idpost}`)">Edit</ion-button>

          <!-- Delete -->
          <ion-button color="danger" @click="() => confirmDelete(post.idpost)">Delete</ion-button>
        </div>
      </ion-card>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { IonPage, IonContent, IonCard, IonCardHeader, IonCardTitle, IonButton, IonButtons } from '@ionic/vue';
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import navbar from '@/components/navbar.vue';

interface Post {
  idpost: number;
  judul: string;
  deskripsi: string;
}

const router = useRouter();
const posts = ref<Post[]>([]);
const api = 'http://localhost/server_side/read-post.php';

// Load posts
onMounted(async () => {
  await fetchPosts();
});

const fetchPosts = async () => {
  try {
    const response = await axios.get(api);
    posts.value = response.data;
  } catch (error) {
    console.error('Error fetching posts data:', error);
  }
};

// Delete onfirm

const deletePost = async (idpost: number) => {
  const confirmDelete = window.confirm("Are you sure you want to delete this post?");
  if (!confirmDelete) return;

  try {
    const response = await axios.post('http://localhost/server_side/delete-post.php', {
      idpost: idpost
    });

    if (response.data.success) {
      // Remove deleted post from the local array
      posts.value = posts.value.filter(post => post.idpost !== idpost);
      alert("Post deleted successfully!");
    } else {
      alert(response.data.message || "Failed to delete post.");
    }
  } catch (error) {
    console.error("Error deleting post:", error);
    alert("Failed to connect to the server.");
  }
};

const confirmDelete = (idpost: number) => {
  deletePost(idpost);
};
</script>
