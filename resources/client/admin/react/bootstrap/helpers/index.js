import _ from "lodash";

window._getData = (key, defaultValue) => _.get(typeof __DATA__ === "undefined" ? {} : __DATA__, key, defaultValue);
