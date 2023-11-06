export function debounce<T extends (...args: any) => any>(fn: T, wait: number) {
  let timer: ReturnType<typeof setTimeout>;
  return function (...args: Parameters<T>) {
    if (timer) {
      clearTimeout(timer); // clear any pre-existing timer
    }
    const context = this; // get the current context
    timer = setTimeout(() => {
      fn.apply(context, args); // call the function if time expires
    }, wait);
  };
}
