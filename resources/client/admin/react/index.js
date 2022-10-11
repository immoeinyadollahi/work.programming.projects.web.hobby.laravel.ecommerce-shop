import React from "react";
import ReactDOM from "react-dom/client";
import { Provider as ReduxProvider } from "react-redux";

import "./bootstrap";

import providers from "./providers";
import store from "./store";

const render = (root, Component, props = {}) => {
  ReactDOM.createRoot(root).render(
    <ReduxProvider store={store}>
      <Component root={root} {...props} />
    </ReduxProvider>
  );
};

const dependenciesComponents = providers
  .map((provider) => provider.default)
  .filter((provider) => _getData("dependencies", []).includes(provider.provides))
  .reduce((acc, current) => (current.components.forEach(([name, component, props]) => (acc[name] = { component, props })), acc), {});

document.querySelectorAll("[data-component]").forEach((element) => {
  const name = element.getAttribute("data-component");
  const dependencyComponent = dependenciesComponents[name];
  if (dependencyComponent) {
    const { component, props } = dependencyComponent;
    render(element, component, props);
  }
});
