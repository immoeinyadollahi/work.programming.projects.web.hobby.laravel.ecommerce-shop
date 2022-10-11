import http from "$services/http";

export const postAttribute = (productId, data) => http.post(`/shop/products/${productId}/variable-type/attributes`, data);

export const postSaveOrdering = (productId, data) => http.post(`/shop/products/${productId}/variable-type/attributes/save`, data);

export const deleteAttibute = (productId, attributeId) => http.delete(`/shop/products/${productId}/variable-type/attributes/${attributeId}`);

export const patchValues = (productId, attributeId, data) => http.patch(`/shop/products/${productId}/variable-type/attributes/${attributeId}/values`, data);
