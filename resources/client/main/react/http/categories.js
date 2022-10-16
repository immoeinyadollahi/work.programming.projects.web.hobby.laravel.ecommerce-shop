import http from "$services/http";

export const getProducts = (categoryId, query) =>
  http.get(`/categories/${categoryId}/products`, { params: query });
