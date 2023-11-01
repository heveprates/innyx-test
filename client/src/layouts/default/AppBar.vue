<template>
  <v-app-bar flat>
    <template v-slot:title>
      <v-icon icon="mdi-application-braces-outline" />
      Teste INNYX
    </template>
    <template v-slot:extension>
      <div class="flex-0-0-100">
        <v-tabs fixed-tabs align-tabs="start">
          <v-tab to="/product"> Product </v-tab>
          <v-tab to="/category"> Category </v-tab>
        </v-tabs>
      </div>
    </template>
  </v-app-bar>
</template>

<script lang="ts" setup></script>
