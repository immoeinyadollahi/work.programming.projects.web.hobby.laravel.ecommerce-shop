import http from "$services/http";

export const postImage = (data, options) => http.post(`/shop/categories/image`, data, options);
