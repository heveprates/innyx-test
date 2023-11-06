import { FormDataError } from "@/error/FormDataError";

export const notififyError = (msg: string) => {
  console.log(msg);
};

export type NonNullableObject<T> = {
  [K in keyof T]: NonNullable<T[K]>;
};

export const validFormData = <T extends {}>(
  values: T
): Required<NonNullableObject<T>> => {
  Object.entries(values)
    .filter(([, value]) => value === null || value === undefined)
    .forEach(([key]) => {
      throw new FormDataError(`Valor de '${key}' invalido`);
    });
  return values as Required<NonNullableObject<T>>;
};
