import http from "$services/http";

export const patchSu = (productId, data) =>
    http.patch(`/shop/products/${productId}/simple-type/su`, data);
