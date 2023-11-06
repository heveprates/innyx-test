<template>
  <v-row justify="end">
    <v-col sm="6" md="4" lg="3">
      <form @submit.prevent="() => $props.filter.changeSearch(searchInput)">
        <v-text-field
          density="compact"
          variant="solo"
          label="Pesquisar"
          prepend-inner-icon="mdi-magnify"
          single-line
          hide-details
          clearable
          v-model="searchInput"
        ></v-text-field>
      </form>
    </v-col>
    <v-col cols="auto">
      <slot name="actions" />
    </v-col>
  </v-row>
  <v-row>
    <v-col cols="12">
      <div v-if="$props.loading" class="text-center">
        <v-progress-circular indeterminate color="primary" />
      </div>
      <slot v-else />
    </v-col>
  </v-row>
  <v-row justify="space-between" align="center">
    <v-col cols="12" md="6" class="text-center text-md-left">
      <strong>
        Mostrando {{ $props.filter.shown }} de
        {{ $props.filter.total }} resultados
      </strong>
    </v-col>
    <v-col cols="12" md="auto">
      <v-pagination
        :model-value="$props.pagination.current"
        :length="$props.pagination.total"
        @update:model-value="($event) => $props.pagination.changePage($event)"
        rounded="circle"
      ></v-pagination>
    </v-col>
  </v-row>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const searchInput = ref("");

defineProps<{
  pagination: {
    current: number;
    total: number;
    changePage: (page: number) => void;
  };
  filter: {
    search: string;
    changeSearch: (search: string) => void;
    total: number;
    shown: number;
  };
  loading: boolean;
}>();
</script>
