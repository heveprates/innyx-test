<script setup lang="ts">
import CategoryForm, {
  CategoryFormProps,
} from "@/components/Category/CategoryForm.vue";

const handleSubmit = () => {
  // let values: CategoryFormProps;
  // alert(JSON.stringify(values, null, 2));
};

const handleReset = () => {};

const handleGoBack = () => {
  window.history.back();
};
</script>
<template>
  <form @submit.prevent="() => handleSubmit()" class="mt-8">
    <CategoryForm />
    <v-row justify="center">
      <v-col cols="auto">
        <v-btn class="me-4" type="submit"> Salvar </v-btn>
        <v-btn class="me-4" @click="() => handleReset()"> Limpar </v-btn>
        <v-btn @click="() => handleGoBack()"> Voltar </v-btn>
      </v-col>
    </v-row>
  </form>
</template>
