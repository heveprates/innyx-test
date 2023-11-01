<template>
  <v-app :theme="theme">
    <default-bar class="bg-deep-orange-lighten-1" />
    <default-view />
  </v-app>
</template>

<script lang="ts" setup>
import { ref } from "vue";

import DefaultBar from "./AppBar.vue";
import DefaultView from "./View.vue";

const theme = ref<"light" | "dark">("dark");
</script>
