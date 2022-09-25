import axios from "axios";
import * as _ from "lodash";

import * as _Global from "$utilities/global";

const axiosInstance = axios.create({
    baseURL: "/api",
});

axiosInstance.interceptors.request.use((config) => {
    if (["patch", "put"].includes(config.method)) {
        config.data._method = config.method.toUpperCase();
        config.method = "POST";
    }
    return config;
});

_Global.set("__SERVICES__.httpClient", axiosInstance);
