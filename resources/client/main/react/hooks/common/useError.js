import ReactDOM from "react-dom/client";

import Error500 from "$components/modals/Error500";
import Error404 from "$components/modals/Error404";

const errors = {
  500: <Error500 />,
  404: <Error404 />,
};

export default function useError() {
  const showError = (status) => {
    const component = errors[status];
    const rootEl = document.createElement("div");
    ReactDOM.createRoot(rootEl).render(component);
    document.body.append(rootEl);
  };
  return { showError };
}
