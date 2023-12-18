import { ref, computed } from "vue";
import { defineStore } from "pinia";
import axios from "../config/axios";

export const useClientStore = defineStore("clientStore", () => {
  async function createClient(data) {
    try {
      const result = await axios.post("/clients", data);

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  async function getClients(sort = "", order = "", page = 1, filters = null, limit=20) {
    try {
      let url = `/clients?page=${page}&limit=${limit}`;

      url = applySorting(sort, order, url);

      url = applyFiltering(filters, url);

      const result = await axios.get(url);

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  function applySorting(sort, order, url) {
    if (sort && order) {
      url = url + `&sort=${sort}&order=${order}`;
    }

    return url;
  }

  function applyFiltering(filters, url) {
    if (filters && filters.length > 0) {
      filters.forEach((filter) => {
        url = url + `&${filter.filter}=${filter.value}`;
      });
    }

    return url;
  }

  async function getClient(id) {
    try {
      const result = await axios.get(`/clients/${id}`);

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  async function deleteClient(id) {
    try {
      const result = await axios.delete(`/clients/${id}`);

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  async function updateClient(id, data) {
    try {
      const result = await axios.put(`/clients/${id}`, data);

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  return { createClient, deleteClient, getClient, getClients, updateClient };
});
