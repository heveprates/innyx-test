<script setup lang="ts">
import { useField } from "vee-validate";
import * as yup from "yup";
import { defineProps } from "vue";

import HInputDatepicker from "@/components/HInputDatepicker.vue";
import { useFieldCurrency } from "@/composables/useFieldCurrency";

defineProps<{
  categoryList: { id: string; name: string }[];
}>();

defineExpose({
  getData: (): ProductFormProps => ({
    name: name.value.value,
    description: description.value.value,
    price: price.value.value,
    expirationDate: expirationDate.value.value,
    categoryId: categoryId.value.value,
    image: image.value.value ? image.value.value[0] : null,
  }),
  setData: (value: Partial<ProductFormProps>) => {
    if (value.name !== undefined) {
      name.value.value = value.name;
    }
    if (value.description !== undefined) {
      description.value.value = value.description;
    }
    if (value.price !== undefined) {
      setValue(value.price);
    }
    if (value.expirationDate !== undefined) {
      expirationDate.value.value = value.expirationDate;
    }
    if (value.categoryId !== undefined) {
      categoryId.value.value = value.categoryId;
    }
    if (value.image !== undefined) {
      if (value.image === null) {
        image.value.value = null;
      } else {
        image.value.value = [value.image];
      }
    }
  },
});

const name = useField<ProductFormProps["name"]>(
  "name",
  yup.string().required().max(50)
);
const description = useField<ProductFormProps["description"]>(
  "description",
  yup.string().required().max(200)
);
const {
  field: price,
  setValue,
  inputRef,
  formattedValue,
} = useFieldCurrency<ProductFormProps["price"]>(
  ["price", yup.number().required().moreThan(0)],
  [currencyConfig]
);

const expirationDate = useField<ProductFormProps["expirationDate"]>(
  "expirationDate",
  yup.date().required().min(new Date())
);
const categoryId = useField<ProductFormProps["categoryId"]>(
  "categoryId",
  yup.string().required()
);
const image = useField<NonNullable<ProductFormProps["image"]>[] | null>(
  "image",
  yup
    .mixed<ProductFormProps["image"][]>()
    .required()
    .test({
      message: `A imagem deve ter no máximo ${MAX_FILE_SIZE / 1024 / 1024}MB`,
      test: (file) => {
        if (file.length == 0) {
          return false;
        }
        if (file[0] === null) {
          return;
        }
        const isValid = file[0]?.size < MAX_FILE_SIZE;
        return isValid;
      },
    })
    .test({
      message: `O tipo de arquivo não é suportado, por favor envie uma imagem`,
      test: (file) => {
        if (file.length == 0) {
          return false;
        }
        if (file[0] === null) {
          return;
        }
        return file[0]?.type.startsWith("image/");
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
  name: string | null;
  description: string | null;
  price: number | null;
  expirationDate: Date | null;
  categoryId: string | null;
  image: File | null;
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
        :model-value="formattedValue"
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
        class="file-input-produto"
        label="Imagem do produto"
        v-model="image.value.value"
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

<style>
.file-input-produto .v-field__input {
  overflow: hidden;
}
</style>
