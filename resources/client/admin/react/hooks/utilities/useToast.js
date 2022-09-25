import uniqid from "uniqid";

import useData from "../actions/useData";

export default function useToast() {
  const { getDataPath, setDataPath } = useData();
  const toasts = getDataPath("toasts", []);
  const setToasts = (toasts) =>
    setDataPath(
      "toasts",
      toasts.map((toast) => Object.assign(toast, { id: uniqid() }))
    );
  const removeToast = (id) =>
    setDataPath(
      "toasts",
      toasts.filter((toast) => toast.id !== id)
    );
  const clearToasts = () => setDataPath("toasts", []);
  return { toasts, setToasts, removeToast, clearToasts };
}
