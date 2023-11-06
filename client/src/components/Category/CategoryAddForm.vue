<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";

import CategoryForm, {
  CategoryFormProps,
} from "@/components/Category/CategoryForm.vue";
import { useNotification } from "@/composables/useNotification";
import { CategoryAPIFetch } from "@/services/categoryAPI";

const router = useRouter();
const notification = useNotification();
const isSubmit = ref(false);
const formRef = ref<InstanceType<typeof CategoryForm> | null>(null);

const getFormData = (): CategoryFormProps => {
  if (!formRef.value) {
    throw new Error("Form ref is null");
  }
  return formRef.value.getData();
};

const handleSubmit = () => {
  let values;
  try {
    values = getFormData();
  } catch {
    notification.show("Não conseguimos obter os dados inseridos", "error");
    return;
  }

  if (!values.name) {
    notification.show('O campo "Nome" é obrigatório', "warning");
    return;
  }

  isSubmit.value = true;
  CategoryAPIFetch.store({
    name: values.name,
  })
    .then(() => router.push("/category"))
    .catch(() => notification.show("Erro ao salvar categoria", "error"))
    .finally(() => (isSubmit.value = false));
};

const handleGoBack = () => {
  router.back();
};
</script>
<template>
  <form @submit.prevent="() => handleSubmit()" class="mt-8">
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
