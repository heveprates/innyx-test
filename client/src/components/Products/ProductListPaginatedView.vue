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

const deleteDialog = ref(false);
const deleteProduct = ref<Product | null>(null);
const deleteIsLoading = ref(false);

const deleteClickHandle = (product: Product) => {
  deleteDialog.value = true;
  deleteProduct.value = product;
};

const deleteConfirmHandle = () => {
  if (!deleteProduct.value) {
    return;
  }
  deleteIsLoading.value = true;
  ProductAPI.fetchDeleteProduct(deleteProduct.value.id)
    .then(() => {
      deleteDialog.value = false;
      deleteProduct.value = null;
      fetchProducts();
    })
    .catch(() => {
      deleteDialog.value = false;
      deleteProduct.value = null;
    })
    .finally(() => {
      deleteIsLoading.value = false;
    });
};

function fetchProducts() {
  loadingData.value = true;
  ProductAPI.fetchProducts(currentPage.value, filterSearch.value)
    .then((response) => {
      productsList.value = response.data;
      currentPage.value = response.pagination.current;
      totalPage.value = response.pagination.last;
      filterTotal.value = response.pagination.total;
      filterShown.value = response.data.length;
    })
    .catch((error) => {})
    .finally(() => {
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
    <v-dialog v-model="deleteDialog" width="500" persistent>
      <v-card>
        <v-card-title> Confirme a exclusão </v-card-title>
        <v-card-text>
          Você esta preste a excluir o produto <b>{{ deleteProduct?.name }}</b
          >.
          <v-spacer></v-spacer>
          A exclusão desse produto é <b>irreversível</b>!
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
            Excluir Produto
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <ProductCardList
      @deleteProduct="deleteClickHandle"
      :productsList="productsList"
    />
    <template #actions>
      <v-btn icon="mdi-plus" to="/product/add"></v-btn>
    </template>
  </PaginatedView>
</template>
