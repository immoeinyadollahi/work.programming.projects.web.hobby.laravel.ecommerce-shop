import React from "react";
import ReactDOM from "react-dom/client";
import { Provider as ReduxProvider } from "react-redux";

import "./bootstrap";

import providers from "./providers";
import reduxStore from "./store";
import * as _Global from "./utilities/global";

const render = (root, Component, props = {}) => {
  ReactDOM.createRoot(root).render(
    <ReduxProvider store={reduxStore}>
      <Component root={root} {...props} />
    </ReduxProvider>
  );
};

const dependenciesComponents = providers
  .map((provider) => provider.default)
  .filter((provider) => _getData("dependencies", []).includes(provider.provides))
  .reduce(
    (acc, current) => (
      current.components.forEach(([name, component, props]) => (acc[name] = { component, props })),
      acc
    ),
    {}
  );

document.querySelectorAll("[data-component]").forEach((element) => {
  const componentName = element.getAttribute("data-component");
  const dependencyComponent = dependenciesComponents[componentName];
  if (dependencyComponent) {
    const componentProps = element.getAttribute("data-component-props");
    const { component, props } = dependencyComponent;
    render(
      element,
      component,
      componentProps ? { ...props, ...JSON.parse(componentProps) } : props
    );
  }
});

_Global.set("redux.store", reduxStore);

window.__GLOBAL__ = _Global;
