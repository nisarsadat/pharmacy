import axios from "axios";

const API_URL = "/accounts";

export default {
  getAll(params) {
    return axios.get(API_URL, { params });
  },

  getById(id) {
    return axios.get(`${API_URL}/${id}`);
  },

  create(data) {
    return axios.post(API_URL, data);
  },

  update(id, data) {
    return axios.put(`${API_URL}/${id}`, data);
  },

  delete(id) {
    return axios.delete(`${API_URL}/${id}`);
  },
};