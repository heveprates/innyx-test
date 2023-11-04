import axios from "axios";

export const APIInstance = axios.create({
  baseURL: "http://localhost:8000",
});

export const APIAuthInstance = axios.create({
  baseURL: "http://localhost:8000",
  headers: {
    Authorization: `Bearer ${localStorage.getItem("token")}`,
  },
});
