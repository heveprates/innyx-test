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
  ProductAPI.fetchProducts().catch((error) => {
    if (error instanceof ProductNotFoundError) {
      console.log("Product not found");
    }
  })
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
    <template #actions>
      <v-btn icon="mdi-plus" to="/product/add"></v-btn>
    </template>
  </PaginatedView>
</template>
