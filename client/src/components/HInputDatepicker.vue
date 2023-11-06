<script setup lang="ts">
import { ref, computed } from "vue";
import type { ExtractPropTypes } from "vue";
import type { VTextField } from "vuetify/components";
import type { VDatePicker } from "vuetify/labs/VDatePicker";

const props = defineProps<{
  textField?: ExtractPropTypes<PropsVTextField>;
  datePicker?: ExtractPropTypes<PropsVDatePicker>;
  modelValue?: Date | null;
}>();
const emits = defineEmits<{
  (event: "update:modelValue", input: Date | null): void;
}>();

const menuOpen = ref(false);
const datePickerValue = ref<Date[]>([]);
const textFieldValue = ref("");

const textFieldValueModel = computed<string>({
  get() {
    if (props.modelValue) {
      return formatDate(props.modelValue);
    }
    return mask.masked(textFieldValue.value).slice(0, 10);
  },
  set(value: string): void {
    if (isValidDate(value)) {
      emits("update:modelValue", makeDate(value));
    } else {
      emits("update:modelValue", null);
    }
    textFieldValue.value = mask.unmasked(value).slice(0, 10);
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
      emits("update:modelValue", makeDate(formatDate(value[0])));
    } else {
      emits("update:modelValue", null);
    }
    datePickerValue.value = value;
  },
});
</script>
<script lang="ts">
import { Mask } from "maska";
import { format, isMatch, parse } from "date-fns";

const DatePatter = "dd/MM/yyyy";
const mask = new Mask({
  mask: "##/##/####",
  tokens: {
    A: { pattern: /[A-Z]/, transform: (chr: string) => chr.toUpperCase() },
  },
  eager: true,
});

function formatDate(dateInput: Date): string {
  return format(dateInput, DatePatter);
}

function isValidDate(value: string): boolean {
  return isMatch(value, DatePatter) && value.length === 10;
}

function makeDate(value: string): Date {
  const date = parse(value, DatePatter, new Date());
  return new Date(
    Date.UTC(
      date.getUTCFullYear(),
      date.getUTCMonth(),
      date.getUTCDate(),
      date.getTimezoneOffset() / 60
    )
  );
}

type PropsVTextField = Exclude<
  InstanceType<typeof VTextField>["$props"],
  | "appendInnerIcon"
  | "v-slot:append-inner"
  | "#append-inner"
  | "modelValue"
  | "onUpdate:modelValue"
>;

type PropsVDatePicker = InstanceType<typeof VDatePicker>["$props"];
</script>

<template>
  <v-text-field
    v-bind="{ ...$attrs, ...($props.textField ?? {}) }"
    v-model="textFieldValueModel"
  >
    <template #append-inner>
      <span aria-label="abrir" role="button">
        <v-icon>mdi-calendar</v-icon>
        <v-menu
          v-model="menuOpen"
          activator="parent"
          eager
          :close-on-content-click="false"
        >
          <v-date-picker
            v-bind="{ ...($props.datePicker ?? {}) }"
            @update:modelValue="() => (menuOpen = false)"
            @click:cancel="() => (menuOpen = false)"
            v-model="datePickerValueModel"
          >
            <template #title />
            <template #header />
          </v-date-picker>
        </v-menu>
      </span>
    </template>
  </v-text-field>
</template>
