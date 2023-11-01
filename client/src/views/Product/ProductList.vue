<template>
  <v-container fluid>
    <PaginatedView>
      <CardView />
    </PaginatedView>
  </v-container>
</template>

<script lang="ts" setup>
import PaginatedView from "@/components/PaginatedView.vue";
import CardView from "@/components/CadView.vue";
</script>
