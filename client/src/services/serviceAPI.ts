import axios from "axios";
import { AuthService } from "./auth";

export const Server = {
  get APIInstance() {
    return axios.create({
      baseURL: "http://localhost:8000",
    });
  },
  get APIAuthInstance() {
    return axios.create({
      baseURL: "http://localhost:8000",
      headers: {
        Authorization: `Bearer ${AuthService.getAuthToken()}`,
      },
    });
  },
};
