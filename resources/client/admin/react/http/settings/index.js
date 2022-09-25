import http from "$services/http";

export const postLogo = (data, options) => http.post(`/settings/logo`, data, options);
