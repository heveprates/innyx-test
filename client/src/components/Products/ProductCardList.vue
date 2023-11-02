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
        <v-card-subtitle class="pt-1">
          {{ product.description }}
        </v-card-subtitle>

        <v-card-text>
          <div class="text-h6">{{ printMoney(product.price) }}</div>

          <div class="text-grey text-caption">
            Válido até {{ printDate(product.valid) }}
          </div>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-btn color="green"> Editar </v-btn>

          <v-btn color="red"> Excluir </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script lang="ts" setup>
import { ref } from "vue";
const productsList = ref<Product[]>([
  {
    id: 1,
    name: "Cama",
    description: "Excelente para dormir!",
    price: 2300,
    valid: new Date("2024-01-24"),
    imageUrl:
      "https://media.istockphoto.com/id/538828557/pt/foto/bela-apartamento-fornecidas.jpg?s=1024x1024&w=is&k=20&c=T-0TxtPgOm5EV2lcAGULp_n1dsTbinU6BtCjcH2VlCo=",
  },
]);

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
  id: number;
  name: string;
  description: string;
  price: number;
  valid: Date;
  imageUrl: string;
};
</script>
