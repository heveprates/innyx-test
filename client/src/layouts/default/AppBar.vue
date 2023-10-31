<template>
  <v-app-bar flat>
    <template v-slot:title>
      <v-icon icon="mdi-application-braces-outline" />
      Teste INNYX
    </template>
    <template v-slot:extension>
      <v-tabs
        fixed-tabs
        align-tabs="title"
      >
        <v-tab to="/product">
          Product
        </v-tab>
        <v-tab to="/category">
          Category
        </v-tab>
      </v-tabs>
    </template>
  </v-app-bar>
</template>

<script lang="ts" setup>
  import { ref } from 'vue'

  // const tab = ref<string|null>(null)
</script>
