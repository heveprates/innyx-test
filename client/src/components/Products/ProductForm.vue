<script setup lang="ts">
import { useField, useForm } from "vee-validate";
import { useCurrencyInput } from "vue-currency-input";

import HInputDatepicker from "@/components/HInputDatepicker.vue";

defineProps<{
  categoryList: { id: string; name: string }[];
}>();

const a = [
  { id: "1", name: "Quarto" },
  { id: "2", name: "Cozinha" },
  { id: "3", name: "Sala" },
  { id: "4", name: "Banheiro" },
];

const { inputRef, formattedValue } = useCurrencyInput(currencyConfig);
const name = useField<ProductFormProps["name"]>("name");
const description = useField<ProductFormProps["description"]>("description");
const price = useField<ProductFormProps["price"]>("price");
const expirationDate =
  useField<ProductFormProps["expirationDate"]>("expirationDate");
const categoryId = useField<ProductFormProps["categoryId"]>("categoryId");
const image = useField<ProductFormProps["image"]>("image");
</script>
<script lang="ts">
const currencyConfig = {
  currency: "BRL",
  hideCurrencySymbolOnFocus: false,
  hideGroupingSeparatorOnFocus: false,
  precision: 2,
  valueRange: { min: 0 },
};

export type ProductFormProps = {
  name: string;
  description: string;
  price: number;
  expirationDate: Date;
  categoryId: string;
  image: File;
};
</script>

<template>
  <v-row justify="center">
    <v-col cols="12" sm="5">
      <v-text-field
        label="Nome"
        v-model="name.value.value"
        :counter="50"
        :error-messages="name.errorMessage.value"
      />

      <v-text-field
        label="Descrição"
        v-model="description.value.value"
        :counter="200"
        :error-messages="description.errorMessage.value"
      />

      <v-text-field
        label="Preço"
        v-model="formattedValue"
        :error-messages="price.errorMessage.value"
        ref="inputRef"
      />

      <h-input-datepicker
        :text-field="{
          label: 'Data de Validade',
          placeholder: 'dd/mm/aaaa',
          errorMessages: expirationDate.errorMessage.value,
        }"
        :date-picker="{ min: new Date() }"
        v-model="expirationDate.value.value"
      />

      <v-file-input
        label="Imagem do produto"
        prepend-icon=""
        append-inner-icon="mdi-paperclip"
        :error-messages="image.errorMessage.value"
      />

      <v-select
        v-model="categoryId.value.value"
        :items="a"
        item-title="name"
        item-value="id"
        :error-messages="categoryId.errorMessage.value"
        label="Categoria"
      ></v-select>
    </v-col>
  </v-row>
</template>
