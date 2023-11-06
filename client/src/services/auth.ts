import { AuthLoginError, AuthLogoutError } from "@/error/AuthErrors";
import { Server } from "./serviceAPI";

export class AuthService {
  private static authToken: string | null = null;

  static async login(email: string, password: string) {
    try {
      const response = await Server.APIInstance.post<{ bearer_token: string }>(
        "/api/auth/login",
        {
          email,
          password,
        }
      );
      this.setAuthToken(response.data.bearer_token);
      return response.data;
    } catch (error: any) {
      if (error?.response?.data?.message) {
        throw new AuthLoginError(error?.response?.data?.message);
      }
      throw error;
    }
  }

  static async logout() {
    try {
      await Server.APIAuthInstance.post("/api/auth/logout");
      this.removeAuthToken();
    } catch (error: any) {
      if (error?.response?.data?.message) {
        throw new AuthLogoutError(error?.response?.data?.message);
      }
      throw error;
    }
  }

  private static setAuthToken(token: string) {
    this.authToken = token;
    localStorage.setItem("authToken", token);
  }

  static removeAuthToken() {
    this.authToken = null;
    localStorage.removeItem("authToken");
  }

  static getAuthToken() {
    if (!this.authToken) {
      this.authToken = localStorage.getItem("authToken");
    }
    return this.authToken;
  }

  static isAuthenticated() {
    return this.getAuthToken() !== null;
  }
}
