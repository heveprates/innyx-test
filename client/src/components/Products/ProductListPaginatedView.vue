<script setup lang="ts">
import { ref, onMounted } from "vue";
import ProductCardList, { Product } from "./ProductCardList.vue";
import PaginatedView from "@/components/PaginatedView.vue";
import { ProductAPI } from "@/services/productAPI";

const loadingData = ref(false);
const currentPage = ref(1);
const totalPage = ref(5);
const filterSearch = ref("");
const filterShown = ref(5);
const filterTotal = ref(25);
const productsList = ref<Product[]>([]);

function fetchProducts() {
  loadingData.value = true;
  ProductAPI.fetchProducts(currentPage.value, filterSearch.value)
    .then((response) => {
      loadingData.value = false;
      productsList.value = response.data;
      currentPage.value = response.pagination.current;
      totalPage.value = response.pagination.last;
      filterTotal.value = response.pagination.total;
      filterShown.value = response.data.length;
    })
    .catch((error) => {
      loadingData.value = false;
    });
}

onMounted(() => {
  fetchProducts();
});

function changeSearchHandle(search: string) {
  filterSearch.value = search;
  fetchProducts();
}

function changePageHandle(page: number) {
  currentPage.value = page;
  fetchProducts();
}
</script>

<template>
  <PaginatedView
    :loading="loadingData"
    :filter="{
      changeSearch: changeSearchHandle,
      search: filterSearch,
      shown: filterShown,
      total: filterTotal,
    }"
    :pagination="{
      changePage: changePageHandle,
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
