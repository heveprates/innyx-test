import { useField } from "vee-validate";
import { useCurrencyInput } from "vue-currency-input";
import { watch, onMounted } from "vue";

export function useFieldCurrency<T extends number>(
  fieldArgs: Parameters<typeof useField<T>>,
  currencyArgs: Parameters<typeof useCurrencyInput>
) {
  const field = useField<T>(...fieldArgs);
  const { inputRef, formattedValue, numberValue, setValue } = useCurrencyInput(
    ...currencyArgs
  );

  watch(numberValue, (newValue) => {
    field.handleChange(newValue);
  });

  onMounted(() => {
    setTimeout(() => {
      if (field.value.value) {
        setValue(field.value.value);
      }
    }, 300);
  });

  return { inputRef, formattedValue, numberValue, setValue, field };
}
