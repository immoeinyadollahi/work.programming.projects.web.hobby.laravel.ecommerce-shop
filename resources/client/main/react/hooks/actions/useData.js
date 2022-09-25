import { useDispatch, useSelector } from "react-redux";
import immer from "immer";
import * as _ from "lodash";

import { updateData } from "../../slices/data";

export default function useData() {
    const dispatch = useDispatch();
    const { data } = useSelector((state) => state);
    const getDataPath = (path, defaultValue) => _.get(data, path, defaultValue);

    const setData = (data) => dispatch(updateData(data));
    const setDataCallback = (cb) => {
        setData(
            immer(data, (draft) => {
                cb(draft);
            })
        );
    };
    const setDataPath = (path, value) => {
        setDataCallback((data) => _.set(data, path, value));
    };

    const hasDataPath = (path) => _.has(data, path);
    return {
        setData,
        setDataPath,
        setDataCallback,
        getDataPath,
        hasDataPath,
        data,
    };
}
