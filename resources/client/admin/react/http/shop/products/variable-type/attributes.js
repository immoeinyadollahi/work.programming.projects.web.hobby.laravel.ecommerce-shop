import http from "$services/http";

export const postAttribute = (productId, data) =>
    http.post(`/shop/products/${productId}/variable-type/attributes`, data);

export const postSaveOrdering = (productId, data) =>
    http.post(
        `/shop/products/${productId}/variable-type/attributes/save`,
        data
    );

export const deleteAttibute = (attributeId) =>
    http.delete(`/shop/products/variable-type/attributes/${attributeId}`);

export const patchValues = (attributeId, data) =>
    http.patch(
        `/shop/products/variable-type/attributes/${attributeId}/values`,
        data
    );
