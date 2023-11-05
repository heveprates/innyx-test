export class ProductNotFoundError extends Error {
  constructor() {
    super(`Nenhum Produto encontrado`);
  }
}
