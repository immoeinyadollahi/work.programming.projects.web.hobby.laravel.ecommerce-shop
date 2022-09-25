import axios from "axios";

import useError from "./useError";
import { useState } from "../core/state";

export default function useErrorHandler() {
    const [{ errors = {}, messages }, setState] = useState({});
    const { showError } = useError();
    const handleHttpError = (
        err,
        {
            422: handler422,
            401: handler401,
            403: handler403,
            404: handler404,
            onBeforeDefaultAction = () => {},
        } = {}
    ) => {
        if (!axios.isAxiosError(err)) return console.error(err);
        const { response: res } = err;
        const status = res.status;
        if (status === 401) {
            if (handler401) {
                handler401(res);
            } else {
                onBeforeDefaultAction(res);
                location.href = "/login";
            }
        } else if (status === 422) {
            if (handler422) {
                handler422(res);
            } else {
                onBeforeDefaultAction(res);
                const { messages, errors } = res.data || {};
                setState({ messages, errors });
            }
        } else if (status === 404) {
            if (handler404) {
                handler404(res);
            } else {
                onBeforeDefaultAction(res);
                showError(404);
            }
        } else if (status === 403) {
            if (handler403) {
                handler403(res);
            } else {
                onBeforeDefaultAction(res);
                showError(403);
            }
        } else if (status > 499) {
            onBeforeDefaultAction(res);
            showError(500);
        }
        return res;
    };
    const clearErrors = () => setState({});
    return { handleHttpError, clearErrors, errors, messages };
}
