/**
 * plugins/vuetify.ts
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";

// Composables
import { createVuetify } from "vuetify";
import { VDatePicker } from "vuetify/labs/VDatePicker";
import DateFnsAdapter from "@date-io/date-fns";
import { enUS, ptBR } from "date-fns/locale";

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
  theme: {
    themes: {
      light: {
        colors: {
          primary: "#1867C0",
          secondary: "#5CBBF6",
        },
      },
    },
  },
  components: {
    VDatePicker,
  },
  date: {
    locale: {
      en: enUS,
      br: ptBR,
    },
    adapter: DateFnsAdapter,
  },
  locale: {
    messages: {
      br: {
        datePicker: {
          ok: "Ok",
          cancel: "Cancelar",
          header: "Escolha a data",
        },
      },
    },
  },
});
