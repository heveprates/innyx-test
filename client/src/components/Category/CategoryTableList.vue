<script lang="ts">
export type Category = {
  id: string;
  name: string;
};
</script>

<script setup lang="ts">
defineProps<{
  categoryList: Category[];
}>();
defineEmits<{
  (event: "delete-category", input: Category): void;
}>();
</script>

<template>
  <v-row>
    <v-col cols="12" sm="12" md="12" lg="12">
      <v-table>
        <thead>
          <tr>
            <th class="text-center">Nome</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in categoryList" :key="item.id">
            <td class="text-center">{{ item.name }}</td>
            <td class="text-center">
              <v-btn
                color="green"
                class="me-4"
                :to="'/category/edit/' + item.id"
              >
                Editar
              </v-btn>

              <v-btn color="red" @click="() => $emit('delete-category', item)">
                Excluir
              </v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-col>
  </v-row>
</template>
