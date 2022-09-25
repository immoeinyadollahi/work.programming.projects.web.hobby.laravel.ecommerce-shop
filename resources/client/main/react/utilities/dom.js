export const lgBreakpointMin = matchMedia("(min-width:992px)");
export const lgBreakpointMax = matchMedia("(max-width:991.98px)");
export const setScrollLock = (lockedState) => {
  Object.assign(document.body.style, lockedState && hasScrollbar() ? { overflow: "hidden", paddingRight: "17px" } : { overflow: "", paddingRight: "" });
};
export const hasScrollbar = () => {
  return document.documentElement.scrollHeight > document.documentElement.clientHeight;
};
export const scrollToPos = ({ pos = 0, offset = 0, speed = 500 } = {}) => {
  $("body,html").animate(
    {
      scrollTop: pos - offset,
    },
    speed
  );
};
export const scrollToEl = ({ el, offset = 0, speed = 500 } = {}) => {
  $("body,html").animate(
    {
      scrollTop: $(el).offset().top - offset,
    },
    speed
  );
};
export const scrollToTop = ({ offset = 0, speed = 500 } = {}) => {
  $("body,html").animate(
    {
      scrollTop: 0,
    },
    speed
  );
};

export const submitFlashForm = ({ to = "/message", body, redirectTo } = {}) => {
  $(`<form method="POST" action="${to}"></form>`)
    .append(Object.entries(Object.assign(body, redirectTo ? { redirect_to: redirectTo } : {}, { x: __rk__ })).map(([key, value]) => $(`<input type="hidden" name="${key}" value="${value}" >`)))
    .appendTo("body")
    .submit()
    .remove();
};
