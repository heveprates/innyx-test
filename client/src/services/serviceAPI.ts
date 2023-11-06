import axios from "axios";
import { AuthService } from "./auth";

export const Server = {
  get APIInstance() {
    return axios.create({
      baseURL: "http://localhost:8000",
    });
  },
  get APIAuthInstance() {
    const instance = axios.create({
      baseURL: "http://localhost:8000",
      headers: {
        Authorization: `Bearer ${AuthService.getAuthToken()}`,
      },
    });
    instance.interceptors.response.use(
      (response) => response,
      (error) => {
        if (error.response.status !== 401) {
          return;
        }
        if (error.response.data.message !== "Não autenticado") {
          return;
        }
        AuthService.removeAuthToken();
      }
    );
    return instance;
  },
};
