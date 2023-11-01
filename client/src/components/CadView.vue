<template>
  <v-row>
    <v-col cols="12" sm="2" v-for="n in 12" :key="n">
      <v-card class="mx-auto" max-width="221">
        <v-img
          class="align-end text-white"
          height="188"
          src="https://media.istockphoto.com/id/538828557/pt/foto/bela-apartamento-fornecidas.jpg?s=1024x1024&w=is&k=20&c=T-0TxtPgOm5EV2lcAGULp_n1dsTbinU6BtCjcH2VlCo="
          cover
        >
        </v-img>
        <v-card-title>Cama</v-card-title>
        <v-card-subtitle class="pt-1"> Excelente para dormir! </v-card-subtitle>

        <v-card-text>
          <div class="text-h6">R$ 2.300,00</div>

          <div class="text-grey text-caption">Válido até 24/01/2024</div>
        </v-card-text>

        <v-card-actions>
          <v-btn color="green"> Editar </v-btn>

          <v-btn color="red"> Excluir </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script lang="ts" setup></script>
