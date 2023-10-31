<template>
  <v-app :theme="theme">
    <default-bar />
    <default-view />
    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script lang="ts" setup>
  import { ref } from 'vue'

  import DefaultBar from './AppBar.vue'
  import DefaultView from './View.vue'

  const theme = ref<'light'|'dark'>('dark')
</script>
