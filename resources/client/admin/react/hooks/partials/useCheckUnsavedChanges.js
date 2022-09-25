import _ from "lodash";

import * as _Global from "$utilities/global";

export default function useCheckUnsavedChanges() {
    return (key) => {
        key = `UnsavedChanges.${key}`;
        const getValues = (object) => {
            const values = [];
            _.forOwn(object, (value) => {
                if (_.isPlainObject(value)) {
                    values.push(...getValues(value));
                } else {
                    values.push(value);
                }
            });
            return values;
        };
        const value = _Global.get(key);
        return _.isPlainObject(value) ? getValues(value).includes(true) : value;
    };
}
