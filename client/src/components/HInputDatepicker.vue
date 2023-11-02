<script setup lang="ts">
import { ref, computed } from "vue";
import { Mask } from "maska";
import { format, isMatch, parse } from "date-fns";
import type { ExtractPropTypes } from "vue";
import type { VTextField } from "vuetify/components";
import type { VDatePicker } from "vuetify/labs/VDatePicker";

type PropsVTextField = Exclude<
  InstanceType<typeof VTextField>["$props"],
  | "appendInnerIcon"
  | "v-slot:append-inner"
  | "#append-inner"
  | "modelValue"
  | "onUpdate:modelValue"
>;

type PropsVDatePicker = InstanceType<typeof VDatePicker>["$props"];

const props = defineProps<{
  textField?: ExtractPropTypes<PropsVTextField>;
  datePicker?: ExtractPropTypes<PropsVDatePicker>;
  modelValue?: Date | null;
}>();
const emits = defineEmits<{
  (event: "update:modelValue", input: Date | null): void;
}>();

const mask = new Mask({
  mask: "##/##/####",
  tokens: {
    A: { pattern: /[A-Z]/, transform: (chr: string) => chr.toUpperCase() },
  },
  eager: true,
});

const menuOpen = ref(false);
const datePickerValue = ref<Date[]>([]);
const textFieldValue = ref("");

const DatePatter = "dd/MM/yyyy";

const textFieldValueModel = computed<string>({
  get() {
    if (props.modelValue) {
      return format(props.modelValue, DatePatter);
    }
    return mask.masked(textFieldValue.value).slice(0, 10);
  },
  set(value: string): void {
    if (isMatch(value, DatePatter) && value.length === 10) {
      emits(
        "update:modelValue",
        parse(value, DatePatter, new Date(Date.UTC(0)))
      );
    } else {
      emits("update:modelValue", null);
    }
    textFieldValue.value = mask.unmasked(value);
  },
});
const datePickerValueModel = computed<Date[]>({
  get() {
    if (props.modelValue) {
      return [props.modelValue];
    }
    return datePickerValue.value;
  },
  set(value: Date | Date[]) {
    if (value instanceof Date) {
      value = [value];
    }
    if (value.length) {
      emits("update:modelValue", value[0]);
    } else {
      emits("update:modelValue", null);
    }
    datePickerValue.value = value;
  },
});
</script>

<template>
  <v-text-field
    v-bind="{ ...$attrs, ...($props.textField ?? {}) }"
    v-model="textFieldValueModel"
  >
    <template #append-inner>
      <v-btn icon="mdi-map-marker">
        <v-icon>mdi-calendar</v-icon>
        <v-menu
          v-model="menuOpen"
          activator="parent"
          eager
          :close-on-content-click="false"
        >
          <v-locale-provider locale="br">
            <v-date-picker
              v-bind="{ ...($props.datePicker ?? {}) }"
              @update:modelValue="() => (menuOpen = false)"
              @click:cancel="() => (menuOpen = false)"
              v-model="datePickerValueModel"
            >
              <template #title />
              <template #header />
            </v-date-picker>
          </v-locale-provider>
        </v-menu>
      </v-btn>
    </template>
  </v-text-field>
</template>
