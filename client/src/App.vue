<template>
  <router-view />
  <v-snackbar
    v-model="snackbar.isShown.value"
    :timeout="snackbar.showTimeout.value"
    :close-on-back="false"
    :multi-line="true"
    :color="snackbar.color.value"
  >
    {{ snackbar.message.value }}

    <template v-slot:actions>
      <v-btn variant="text" @click="() => (snackbar.isShown.value = false)">
        Fechar
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script lang="ts" setup>
import { useNotification } from "@/composables/useNotification";

const { displayData: snackbar } = useNotification();
</script>
