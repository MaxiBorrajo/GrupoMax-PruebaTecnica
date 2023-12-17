import axios from "axios";
import VueCookies from "vue-cookies";

const instance = axios.create({
  baseURL: `${import.meta.env.VITE_URL_SERVICE}/api`,
  withCredentials: false,
});

instance.interceptors.request.use(
  function (config) {
    const token = VueCookies.get("token");

    if (VueCookies.isKey("token") && token) {
      config.headers["Authorization"] = `Bearer ${token}`;
    }

    return config;
  },
  function (error) {
    return Promise.reject(error);
  }
);

//Exports
export default instance;
