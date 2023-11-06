<template>
  <v-row>
    <v-col
      cols="12"
      sm="6"
      md="4"
      lg="3"
      v-for="product in productsList"
      :key="'product-card' + product.id"
    >
      <v-card class="mx-auto" min-width="180">
        <v-img
          class="align-end text-white"
          height="188"
          :src="product.imageUrl"
          cover
        >
        </v-img>
        <v-card-title>{{ product.name }}</v-card-title>
        <v-card-subtitle class="mt-n2">
          {{ product.description }}
        </v-card-subtitle>

        <v-card-text>
          <div class="text-subtitle-1">{{ printMoney(product.price) }}</div>

          <div class="text-grey text-caption">
            Válido até {{ printDate(product.valid) }}
          </div>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-btn color="green" :to="'/product/edit/' + product.id">
            Editar
          </v-btn>

          <v-btn color="red" @click="() => $emit('delete-product', product)">
            Excluir
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script lang="ts" setup>
defineProps<{
  productsList: Product[];
}>();

defineEmits<{
  (event: "delete-product", input: Product): void;
}>();

const printMoney = (value: number) => {
  return value.toLocaleString("pt-BR", {
    style: "currency",
    currency: "BRL",
  });
};

const printDate = (date: Date) => {
  return date.toLocaleDateString("pt-BR");
};
</script>
<script lang="ts">
export type Product = {
  id: string;
  name: string;
  description: string;
  price: number;
  valid: Date;
  imageUrl: string;
};
</script>
