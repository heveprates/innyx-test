export class CategoryNotFoundError extends Error {
  constructor() {
    super(`Nenhuma Categoria encontrada`);
  }
}
