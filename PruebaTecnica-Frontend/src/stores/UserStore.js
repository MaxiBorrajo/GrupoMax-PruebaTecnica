import { ref, computed } from "vue";
import { defineStore } from "pinia";
import axios from "../config/axios";

export const useUserStore = defineStore("userStore", () => {
  async function createUser(data) {
    try {
      const result = await axios.post("/users", data);

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  async function deleteUser() {
    try {
      const result = await axios.delete("/users");

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  async function getCurrentUser() {
    try {
      const result = await axios.get("/users/current");

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  async function getUsers(
    sort = "",
    order = "",
    page = 1,
    filters = null,
    limit = 20
  ) {
    try {
      let url = `/users?page=${page}&limit=${limit}`;

      url = applySorting(sort, order, url);

      url = applyFiltering(filters, url);

      console.log(url);

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

  async function updateUser(data) {
    try {
      const result = await axios.put("/users", data);

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  async function login(data) {
    try {
      const result = await axios.post("/users/login", data);

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  async function logout() {
    try {
      const result = await axios.delete("/users/logout");

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  async function forgotPassword(data) {
    try {
      const result = await axios.post("/users/forgotPassword", data);

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  async function resetPassword(data) {
    try {
      const result = await axios.post("/users/resetPassword", data);

      return result.data;
    } catch (error) {
      throw error;
    }
  }

  return {
    createUser,
    deleteUser,
    updateUser,
    forgotPassword,
    resetPassword,
    getCurrentUser,
    getUsers,
    login,
    logout,
  };
});
