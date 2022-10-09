import http from "$services/http";

export const getProperties = (categoryId) => http.get(`/shop/categories/${categoryId}/properties`);
