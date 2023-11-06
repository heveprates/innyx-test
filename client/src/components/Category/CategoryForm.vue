<script setup lang="ts">
import { useField } from "vee-validate";
import * as yup from "yup";

const name = useField<CategoryFormProps["name"]>(
  "name",
  yup.string().required().max(100)
);

defineExpose({
  getDate: (): CategoryFormProps => ({
    name: name.value.value,
  }),
  setData: (value: CategoryFormProps) => {
    name.value.value = value.name;
  },
});
</script>

<script lang="ts">
export type CategoryFormProps = {
  name: string | null;
};
</script>

<template>
  <v-row justify="center">
    <v-col cols="12" sm="4">
      <v-text-field
        label="Nome"
        v-model="name.value.value"
        :counter="100"
        :error-messages="name.errorMessage.value"
      />
    </v-col>
  </v-row>
</template>
