<script setup lang="ts">
import { ref, onMounted } from "vue";
import CategoryTableList, { Category } from "./CategoryTableList.vue";
import PaginatedView from "../PaginatedView.vue";
import { CategoryAPIFetch } from "@/services/categoryAPI";

const loadingData = ref(false);
const currentPage = ref(1);
const totalPage = ref(1);
const filterSearch = ref("");
const filterShown = ref(5);
const filterTotal = ref(5);
const categoryList = ref<Category[]>([]);

const deleteDialog = ref(false);
const deleteItem = ref<Category | null>(null);
const deleteIsLoading = ref(false);

const deleteClickHandle = (category: Category) => {
  deleteDialog.value = true;
  deleteItem.value = category;
};

const deleteConfirmHandle = () => {
  if (!deleteItem.value) {
    return;
  }
  deleteIsLoading.value = true;
  CategoryAPIFetch.delete(deleteItem.value.id)
    .then(() => {
      deleteDialog.value = false;
      deleteItem.value = null;
      fetchCategories();
    })
    .catch(() => {
      deleteDialog.value = false;
      deleteItem.value = null;
    })
    .finally(() => {
      deleteIsLoading.value = false;
    });
};

function fetchCategories() {
  loadingData.value = true;
  CategoryAPIFetch.listPage(currentPage.value, filterSearch.value)
    .then((response) => {
      categoryList.value = response.data;
      currentPage.value = response.pagination.current;
      totalPage.value = response.pagination.last;
      filterTotal.value = response.pagination.total;
      filterShown.value = response.data.length;
    })
    .finally(() => (loadingData.value = false));
}

onMounted(() => fetchCategories());

function changeSearchHandle(search: string) {
  filterSearch.value = search;
  fetchCategories();
}

function changePageHandle(page: number) {
  currentPage.value = page;
  fetchCategories();
}
</script>

<template>
  <PaginatedView
    :loading="false"
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
    <v-dialog v-model="deleteDialog" width="500" persistent>
      <v-card>
        <v-card-title> Confirme a exclusão </v-card-title>
        <v-card-text>
          Você esta preste a excluir a categoria <b>{{ deleteItem?.name }}</b
          >.
          <v-spacer></v-spacer>
          A exclusão dessa categoria é <b>irreversível</b> e apagara tambem
          todos os produtos associados!
          <v-spacer class="mt-2"></v-spacer>
          Deseja continuar?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            variant="text"
            @click="() => (deleteDialog = false)"
            :disabled="deleteIsLoading"
          >
            cancelar
          </v-btn>
          <v-btn
            color="amber-accent-2"
            @click="deleteConfirmHandle"
            :loading="deleteIsLoading"
          >
            Excluir Categoria
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <CategoryTableList
      @delete-category="deleteClickHandle"
      :categoryList="categoryList"
    />
    <template #actions>
      <v-btn icon="mdi-plus" to="/category/add"></v-btn>
    </template>
  </PaginatedView>
</template>
