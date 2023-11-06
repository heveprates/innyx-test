import { ref } from "vue";

type ThemeType =
  | "success"
  | "default"
  | "error"
  | "warning"
  | "info"
  | "primary"
  | "secondary";

const isShown = ref(false);
const message = ref("");
const showTimeout = ref(0);
const color = ref<ThemeType>("default");

let timer: ReturnType<typeof setTimeout>;

export function useNotification() {
  function show(
    msg: string,
    theme: ThemeType = "default",
    timeout: number = 4500
  ) {
    message.value = msg;
    isShown.value = true;
    color.value = theme;
    clearTimeout(timer);
    timer = setTimeout(() => {
      isShown.value = false;
    }, timeout);
    showTimeout.value = timeout;
  }
  return { show, displayData: { isShown, message, showTimeout, color } };
}
