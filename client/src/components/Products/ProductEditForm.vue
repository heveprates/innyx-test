<script setup lang="ts">
import { ref } from "vue";
import ProductForm, {
  ProductFormProps,
} from "@/components/Products/ProductForm.vue";
import { ProductAPI } from "@/services/productAPI";
import router from "@/router";

const formRef = ref<InstanceType<typeof ProductForm> | null>(null);

const getFormData = (): ProductFormProps => {
  if (!formRef.value) {
    throw new Error("Form ref is null");
  }
  return formRef.value.getData();
};

const handleSubmit = () => {
  const values = getFormData();
  ProductAPI.fetchStoreProduct({
    name: values.name,
    description: values.description,
    price: values.price,
    valid: values.expirationDate,
    category: values.categoryId,
    imageFile: values.image,
  }).then((product) => {
    router.push("/product");
  });
};

const handleReset = () => {};

const handleGoBack = () => {
  router.back();
};
</script>
<template>
  <form @submit.prevent="() => handleSubmit()" class="mt-8">
    <v-row justify="center">
      <v-col cols="auto">
        <v-btn class="me-4" type="submit"> Salvar </v-btn>
        <v-btn class="me-4" @click="() => handleReset()"> Limpar </v-btn>
        <v-btn @click="() => handleGoBack()"> Voltar </v-btn>
      </v-col>
    </v-row>
  </form>
</template>
