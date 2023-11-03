<script setup lang="ts">
import { ref } from "vue";
import CategoryTableList, { Category } from "./CategoryTableList.vue";
import PaginatedView from "../PaginatedView.vue";

const currentPage = ref(1);
const totalPage = ref(1);
const filterSearch = ref("");
const filterShown = ref(5);
const filterTotal = ref(5);

const categoryList = ref<Category[]>(
  [...new Array(6)].map((_, index) => ({
    id: String(index + 1),
    name: "Eletrônicos",
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
    <CategoryTableList :categoryList="categoryList" />
    <template #actions>
      <v-btn icon="mdi-plus" to="/category/add"></v-btn>
    </template>
  </PaginatedView>
</template>
