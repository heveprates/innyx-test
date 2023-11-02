<template>
  <v-container fluid>
    <ProductAddForm />
  </v-container>
</template>

<script lang="ts" setup>
import { useForm } from "vee-validate";

import ProductForm from "@/components/Products/ProductForm.vue";
import ProductAddForm from "@/components/Products/ProductAddForm.vue";

const { handleSubmit, handleReset } = useForm<{
  name: string;
  desc: string;
  date: Date;
}>({
  validationSchema: {
    name(value: string) {
      if (value?.length <= 50) return true;

      return "Name needs to be until 50 characters.";
    },
    desc(value: string) {
      if (value?.length <= 200) return true;

      return "Desc needs to be ultil 200 characters.";
    },
    preco(value: string) {
      if (/^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true;

      return "Must be a valid e-mail.";
    },
    select(value: string) {
      if (value) return true;

      return "Select an item.";
    },
  },
});

const submit = handleSubmit((values) => {
  alert(JSON.stringify(values, null, 2));
});

const handleGoBack = () => {
  window.history.back();
};
</script>
