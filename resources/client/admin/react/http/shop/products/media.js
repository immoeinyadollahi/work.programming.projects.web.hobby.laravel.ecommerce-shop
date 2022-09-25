import http from "$services/http";

export const postImage = (data, options) => http.post(`/shop/products/image`, data, options);

export const postThumbnail = (data, options) => http.post(`/shop/products/thumbnails`, data, options);
