import http from "$services/http";

export const getCategoryProperties = (productId) => http.get(`/shop/products/${productId}/category-properties`);

export const getProperties = (productId) => http.get(`/shop/products/${productId}/properties`);

export const postSave = (productId, data) => http.post(`/shop/products/${productId}/properties/save`, data);
