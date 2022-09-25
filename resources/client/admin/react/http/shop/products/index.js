import http from "$services/http";

export const patchProduct = (productId, data) => http.patch(`/shop/products/${productId}`, data);

export const patchCategory = (productId, data) => http.patch(`/shop/products/${productId}/category`, data);
