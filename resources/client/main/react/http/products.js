import http from "$services/http";

export const getSearch = (query) => http.get("/products/search", query);

export const getQuickviewProduct = (productId) => http.get(`/products/${productId}/quickview`);
