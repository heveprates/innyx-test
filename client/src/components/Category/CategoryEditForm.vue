<script lang="ts" setup>
import { ref, onBeforeMount } from "vue";
import { useRouter, useRoute } from "vue-router";

import CategoryForm, {
  CategoryFormProps,
} from "@/components/Category/CategoryForm.vue";
import { CategoryNotFoundError } from "@/error/CategoryError.js";
import { CategoryAPIFetch } from "@/services/categoryAPI";
import { useNotification } from "@/composables/useNotification";

const notification = useNotification();
const router = useRouter();
const categoryId = useRoute().params.id as string;
const isLoadedFull = ref(false);
const isSubmit = ref(false);
const formRef = ref<InstanceType<typeof CategoryForm> | null>(null);

onBeforeMount(() =>
  CategoryAPIFetch.show(categoryId)
    .then((category) => {
      categoryAPIData.name = category.name;
      setFormData(categoryAPIData);
    })
    .catch((error) => {
      if (error instanceof CategoryNotFoundError) {
        notification.show(error.message, "error");
        router.push("/category");
        return;
      }
      notification.show("Erro desconhecido ao carregar categoria", "error");
      router.push("/category");
      return;
    })
    .finally(() => (isLoadedFull.value = true))
);

const setFormData = (value: CategoryFormProps) => {
  if (!formRef.value) {
    throw new Error("Form ref is null");
  }
  formRef.value.setData(value);
};

const getFormData = (): CategoryFormProps => {
  if (!formRef.value) {
    throw new Error("Form ref is null");
  }
  return formRef.value.getData();
};

const handleGoBack = () => {
  router.back();
};

const handleSubmit = () => {
  const formData = getFormData();
  if (!formData.name) {
    notification.show("Verifique se o campo 'Nome' esta preenchido", "warning");
    return;
  }
  if (formData.name === categoryAPIData.name) {
    router.push("/category");
    return;
  }
  isSubmit.value = true;
  CategoryAPIFetch.update(categoryId, { name: formData.name })
    .then(() => router.push("/category"))
    .catch(() => notification.show("Erro ao salvar categoria", "error"))
    .finally(() => (isSubmit.value = false));
};
</script>
<script lang="ts">
const categoryAPIData: CategoryFormProps = {
  name: "",
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
    <CategoryForm ref="formRef" />
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
