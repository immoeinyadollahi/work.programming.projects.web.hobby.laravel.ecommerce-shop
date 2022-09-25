import http from "$services/http";

export const postSlide = (data) => http.post("/settings/slideshow/slides", data);

export const patchSlide = (slideId, data) => http.post(`/settings/slideshow/slides/${slideId}`, data);

export const deleteSlide = (slideId) => http.delete(`/settings/slideshow/slides/${slideId}`);

export const postSlideImage = (data, options) => http.post("/settings/slideshow/slides/image", data, options);
