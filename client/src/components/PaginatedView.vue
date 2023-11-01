<template>
  <v-row justify="end">
    <v-col cols="4">
      <v-text-field
        density="compact"
        variant="solo"
        label="Pesquisar"
        prepend-inner-icon="mdi-magnify"
        single-line
        hide-details
        clearable
      ></v-text-field>
    </v-col>
    <v-col cols="auto">
      <v-btn icon="mdi-plus" to="/product/add"></v-btn>
    </v-col>
  </v-row>
  <v-row>
    <v-col cols="12">
      <slot />
    </v-col>
  </v-row>
  <v-row justify="space-between">
    <v-col cols="4" class="d-flex align-center" height="100">
      <strong> Mostrando 5 de 25 resultados </strong>
    </v-col>
    <v-col cols="6">
      <v-pagination v-model="page" :length="25" rounded="circle"></v-pagination>
    </v-col>
  </v-row>
</template>

<script lang="ts" setup>
const page = 1;

function add() {
  console.log("Hello World");
}
</script>
