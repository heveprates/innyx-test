export class AuthLoginError extends Error {
  constructor(msg?: string) {
    super(`Erro ao realizar login${msg ? `: ${msg}` : ""}`);
  }
}

export class AuthLogoutError extends Error {
  constructor() {
    super(`Erro ao realizar logout`);
  }
}
