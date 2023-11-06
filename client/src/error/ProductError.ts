export class ProductNotFoundError extends Error {
  constructor(msg?: string) {
    super(`Nenhum Produto encontrado${msg ? `: ${msg}` : ""}`);
  }
}
