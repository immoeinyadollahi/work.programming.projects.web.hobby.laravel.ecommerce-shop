import http from "$services/http";

export const getVariations = (productId) =>
    http.get(`/shop/products/${productId}/variable-type/variations`);

export const getPerformAction = (productId, actionName) =>
    http.get(
        `/shop/products/${productId}/variable-type/variations/actions/${actionName}`
    );

export const postSaveChanges = (data) =>
    http.post(`/shop/products/variable-type/variations/save`, data);

export const deleteVariation = (variationId) =>
    http.delete(`/shop/products/variable-type/variations/${variationId}`);
