<script setup lang="ts">
import { ref } from "vue";
import ProductCardList, { Product } from "./ProductCardList.vue";
import PaginatedView from "@/components/PaginatedView.vue";

const currentPage = ref(1);
const totalPage = ref(5);
const filterSearch = ref("");
const filterShown = ref(5);
const filterTotal = ref(25);

const productsList = ref<Product[]>(
  [...new Array(12)].map((_, index) => ({
    id: String(index + 100),
    name: "Cama",
    description: "Excelente para dormir!",
    price: 2300,
    valid: new Date("2024-01-24"),
    imageUrl:
      "https://media.istockphoto.com/id/538828557/pt/foto/bela-apartamento-fornecidas.jpg?s=1024x1024&w=is&k=20&c=T-0TxtPgOm5EV2lcAGULp_n1dsTbinU6BtCjcH2VlCo=",
  }))
);
</script>

<template>
  <PaginatedView
    :loading="false"
    :filter="{
      changeSearch: () => {},
      search: filterSearch,
      shown: filterShown,
      total: filterTotal,
    }"
    :pagination="{
      changePage: (page: number) => {
        currentPage = page;
      },
      current: currentPage,
      total: totalPage,
    }"
  >
    <ProductCardList :productsList="productsList" />
  </PaginatedView>
</template>
