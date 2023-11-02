<script setup lang="ts">
import ProductForm, {
  ProductFormProps,
} from "@/components/Products/ProductForm.vue";

const handleSubmit = () => {
  // let values: ProductFormProps;
  // alert(JSON.stringify(values, null, 2));
};

const handleReset = () => {};

const handleGoBack = () => {
  window.history.back();
};
</script>
<template>
  <form @submit.prevent="() => handleSubmit()" class="mt-8">
    <ProductForm
      :categoryList="[
        { id: '1', name: 'Quarto' },
        { id: '2', name: 'Cozinha' },
        { id: '3', name: 'Sala' },
        { id: '4', name: 'Banheiro' },
      ]"
    />
    <v-row justify="center">
      <v-col cols="auto">
        <v-btn class="me-4" type="submit"> Salvar </v-btn>
        <v-btn class="me-4" @click="() => handleReset()"> Limpar </v-btn>
        <v-btn @click="() => handleGoBack()"> Voltar </v-btn>
      </v-col>
    </v-row>
  </form>
</template>
