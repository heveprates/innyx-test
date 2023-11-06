<script setup lang="ts">
import { ref, onBeforeMount } from "vue";
import { useRouter, useRoute } from "vue-router";

import ProductForm, {
  ProductFormProps,
} from "@/components/Products/ProductForm.vue";
import { FormDataError } from "@/error/FormDataError";
import { ProductAPI } from "@/services/productAPI";
import { CategoryAPIFetch } from "@/services/categoryAPI";
import { validFormData, notififyError } from "@/tools/form";

const router = useRouter();
const productId = useRoute().params.id as string;
const isLoadedFull = ref(false);
const isSubmit = ref(false);
const formRef = ref<InstanceType<typeof ProductForm> | null>(null);
const categoryList = ref<{ id: string; name: string }[]>([]);

onBeforeMount(() => {
  const fetchInitials = [];
  let fetch = CategoryAPIFetch.all().then((categories) => {
    categoryList.value = categories;
  });
  fetchInitials.push(fetch);

  fetch = ProductAPI.fetchShowProduct(productId).then((product) => {
    productData.name = product.name;
    productData.description = product.description;
    productData.price = product.price;
    productData.expirationDate = product.valid;
    productData.categoryId = product.categoryId;
    productData.image = new File([""], product.imageUrl, { type: "image/*" });

    setFormData(productData);
  });
  fetchInitials.push(fetch);
  Promise.all(fetchInitials).finally(() => (isLoadedFull.value = true));
});

const getFormData = (): ProductFormProps => {
  if (!formRef.value) {
    throw new Error("Form ref is null");
  }
  return formRef.value.getData();
};

const setFormData = (value: Partial<ProductFormProps>) => {
  if (!formRef.value) {
    throw new Error("Form ref is null");
  }
  formRef.value.setData(value);
};

const handleSubmit = () => {
  const valuesToPost: Partial<
    ProductFormProps & { valid: ProductFormProps["expirationDate"] }
  > = {};
  try {
    const formData = getFormData();
    Object.keys(formData).forEach((keyInput) => {
      const key = keyInput as keyof ProductFormProps;
      if (formData[key] !== productData[key]) {
        valuesToPost[key] = formData[key] as any;
      }
    });
    if (valuesToPost["expirationDate"] !== undefined) {
      valuesToPost["valid"] = valuesToPost["expirationDate"];
    }
    validFormData(valuesToPost);
  } catch (error) {
    if (error instanceof FormDataError) {
      notififyError(error.message);
    } else {
      notififyError("Verifique os campos obrigatórios");
    }
    return;
  }

  isSubmit.value = true;
  ProductAPI.fetchUpdateProduct(productId, valuesToPost)
    .then(() => router.push("/product"))
    .catch(() => notififyError("Erro ao salvar produto"))
    .finally(() => (isSubmit.value = false));
};

const handleGoBack = () => {
  router.back();
};
</script>
<script lang="ts">
const productData: ProductFormProps = {
  name: null,
  description: null,
  price: null,
  expirationDate: null,
  categoryId: null,
  image: null,
};
</script>
<template>
  <v-row v-show="!isLoadedFull" justify="center" align="center">
    <v-col cols="auto" class="mt-5">
      <v-progress-circular indeterminate color="primary" />
    </v-col>
  </v-row>
  <form
    v-show="isLoadedFull"
    @submit.prevent="() => handleSubmit()"
    class="mt-8"
  >
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
