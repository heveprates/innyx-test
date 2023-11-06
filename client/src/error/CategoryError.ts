export class CategoryNotFoundError extends Error {
  constructor(msg?: string) {
    super(`Nenhuma Categoria encontrada${msg ? `: ${msg}` : ""}`);
  }
}
