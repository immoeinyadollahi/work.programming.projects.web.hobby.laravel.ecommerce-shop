import http from "$services/http";

export const postGroup = (productId, data) =>
    http.post(`/shop/products/${productId}/specifications/groups`, data);

export const postSaveOrdering = (data) =>
    http.post("/shop/products/specifications/save", data);

export const patchGroup = (groupId, data) =>
    http.patch(`/shop/products/specifications/groups/${groupId}`, data);

export const deleteGroup = (groupId) =>
    http.delete(`/shop/products/specifications/groups/${groupId}`);

export const postGroupItem = (groupId, data) =>
    http.post(`/shop/products/specifications/groups/${groupId}/items`, data);

export const patchGroupItem = (itemId, data) =>
    http.patch(`/shop/products/specifications/groups/items/${itemId}`, data);

export const deleteGroupItem = (itemId) =>
    http.delete(`/shop/products/specifications/groups/items/${itemId}`);
