<script setup lang="ts">
import { ref, onMounted } from "vue";
import ProductCardList, { Product } from "./ProductCardList.vue";
import PaginatedView from "@/components/PaginatedView.vue";
import { ProductAPI, ProductNotFoundError } from "@/services/productAPI";

const currentPage = ref(1);
const totalPage = ref(5);
const filterSearch = ref("");
const filterShown = ref(5);
const filterTotal = ref(25);
const productsList = ref<Product[]>([]);

async function fetchProducts() {
  ProductAPI.fetchProducts()
    .then((products) => {
      productsList.value = products;
    })
    .catch((error) => {
      if (error instanceof ProductNotFoundError) {
        console.log(ProductNotFoundError);
      } else {
        console.log("Error");
      }
    });
}

onMounted(() => {
  fetchProducts();
});
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
