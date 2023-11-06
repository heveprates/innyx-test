<script setup lang="ts">
import { ref, onBeforeMount } from "vue";
import { useRouter } from "vue-router";

import ProductForm, {
  ProductFormProps,
} from "@/components/Products/ProductForm.vue";
import { FormDataError } from "@/error/FormDataError";
import { ProductAPIFetch } from "@/services/productAPI";
import { CategoryAPIFetch } from "@/services/categoryAPI";
import { validFormData, notififyError } from "@/tools/form";

const router = useRouter();

const isSubmit = ref(false);
const formRef = ref<InstanceType<typeof ProductForm> | null>(null);
const categoryList = ref<{ id: string; name: string }[]>([]);

onBeforeMount(() =>
  CategoryAPIFetch.all().then((categories) => {
    categoryList.value = categories;
  })
);

const getFormData = (): ProductFormProps => {
  if (!formRef.value) {
    throw new Error("Form ref is null");
  }
  return formRef.value.getData();
};

const handleSubmit = () => {
  let values;
  try {
    values = validFormData(getFormData());
  } catch (error) {
    if (error instanceof FormDataError) {
      notififyError(error.message);
    } else {
      notififyError("Verifique os campos obrigatórios");
    }
    return;
  }

  isSubmit.value = true;
  ProductAPIFetch.store({
    name: values.name,
    description: values.description,
    price: values.price,
    valid: values.expirationDate,
    category: values.categoryId,
    imageFile: values.image,
  })
    .then(() => router.push("/product"))
    .catch(() => notififyError("Erro ao salvar produto"))
    .finally(() => (isSubmit.value = false));
};

const handleGoBack = () => {
  router.back();
};
</script>
<template>
  <form @submit.prevent="() => handleSubmit()" class="mt-8">
    <ProductForm ref="formRef" :categoryList="categoryList" />
    <v-row justify="center">
      <v-col cols="auto">
        <v-btn class="me-4" type="submit" :loading="isSubmit"> Salvar </v-btn>
        <v-btn @click="() => handleGoBack()" :disabled="isSubmit">
          Voltar
        </v-btn>
      </v-col>
    </v-row>
  </form>
</template>
