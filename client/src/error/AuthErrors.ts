export class AuthLoginError extends Error {
  constructor() {
    super(`Erro ao realizar login`);
  }
}

export class AuthLogoutError extends Error {
  constructor() {
    super(`Erro ao realizar logout`);
  }
}
