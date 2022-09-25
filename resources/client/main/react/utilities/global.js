import * as _ from "lodash";

const data = {};

export const get = (path) => _.get(data, path);
export const set = (path, value) => _.set(data, path, value);
export const unset = (path) => _.unset(data, path);
export const has = (path) => _.has(data, path);
