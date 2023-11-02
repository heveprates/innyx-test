<script setup lang="ts">
import { useField } from "vee-validate";
import * as yup from "yup";
import { useCurrencyInput } from "vue-currency-input";

import HInputDatepicker from "@/components/HInputDatepicker.vue";

defineProps<{
  categoryList: { id: string; name: string }[];
}>();

const { inputRef, formattedValue } = useCurrencyInput(currencyConfig);
const name = useField<ProductFormProps["name"]>(
  "name",
  yup.string().required().max(50)
);
const description = useField<ProductFormProps["description"]>(
  "description",
  yup.string().required().max(200)
);
const price = useField<ProductFormProps["price"]>(
  "price",
  yup.number().required().moreThan(0)
);
const expirationDate = useField<ProductFormProps["expirationDate"]>(
  "expirationDate",
  yup.date().required().min(new Date())
);
const categoryId = useField<ProductFormProps["categoryId"]>(
  "categoryId",
  yup.string().required()
);
const image = useField<ProductFormProps["image"]>(
  "image",
  yup
    .mixed<File>()
    .required()
    .test({
      message: `A imagem deve ter no máximo ${MAX_FILE_SIZE / 1024 / 1024}MB`,
      test: (file) => {
        const isValid = file?.size < MAX_FILE_SIZE;
        return isValid;
      },
    })
    .test({
      message: `O tipo de arquivo não é suportado, por favor envie uma imagem`,
      test: (file) => {
        return file.type.startsWith("image/");
      },
    })
);
</script>
<script lang="ts">
const SIX_MEGA_BYTES = 1024 * 1024 * 6;
const MAX_FILE_SIZE = SIX_MEGA_BYTES;
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
        :items="$props.categoryList"
        item-title="name"
        item-value="id"
        :error-messages="categoryId.errorMessage.value"
        label="Categoria"
      ></v-select>
    </v-col>
  </v-row>
</template>
