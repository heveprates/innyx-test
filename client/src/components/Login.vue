<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useField } from "vee-validate";
import * as yup from "yup";

import { useNotification } from "@/composables/useNotification";
import { AuthService } from "@/services/auth";
import { AuthLoginError } from "@/error/AuthErrors";

const visible = ref(false);
const loading = ref(false);
const notification = useNotification();

const router = useRouter();

const emailField = useField<string>("email", yup.string().required().email());
const pwdField = useField<string>("password", yup.string().required().min(3));

const submit = () => {
  if (!emailField.meta.valid || !pwdField.meta.valid) {
    notification.show("Verifique os campos", "warning");
    return;
  }

  loading.value = true;
  AuthService.login(emailField.value.value, pwdField.value.value)
    .then(() => {
      router.push("/");
    })
    .catch((error) => {
      if (error instanceof AuthLoginError) {
        notification.show(error.message, "error");
        return;
      } else {
        notification.show("Erro desconhecido ao realizar o login", "error");
        return;
      }
    })
    .finally(() => {
      loading.value = false;
    });
};
</script>

<template>
  <div>
    <form @submit.prevent="() => submit()">
      <v-img
        class="mx-auto my-12"
        max-width="228"
        src="https://innyx.com/incluir/imagens/logo_topo.png"
      ></v-img>

      <v-card
        class="mx-auto pa-12 pb-8 mt-16"
        elevation="8"
        max-width="448"
        rounded="lg"
        theme="dark"
      >
        <v-card-title class="text-h6 text-center"
          >Teste da Hévellyn</v-card-title
        >
        <v-card-title class="text-h4 text-center">Login</v-card-title>
        <div class="text-subtitle-1 text-medium-emphasis">Email</div>

        <v-text-field
          density="compact"
          prepend-inner-icon="mdi-email-outline"
          variant="outlined"
          v-model="emailField.value.value"
          :error-messages="emailField.errorMessage.value"
        />

        <div
          class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
        >
          Senha
        </div>

        <v-text-field
          :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
          :type="visible ? 'text' : 'password'"
          density="compact"
          prepend-inner-icon="mdi-lock-outline"
          variant="outlined"
          @click:append-inner="visible = !visible"
          v-model="pwdField.value.value"
          :error-messages="pwdField.errorMessage.value"
        />

        <v-btn
          type="submit"
          block
          class="mb-8"
          color="white"
          size="large"
          variant="tonal"
          :loading="loading"
        >
          Entrar
        </v-btn>
      </v-card>
    </form>
  </div>
</template>
