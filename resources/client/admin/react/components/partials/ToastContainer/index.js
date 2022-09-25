import React from "react";
import { ToastContainer as BootstrapToastContainer, Toast, CloseButton } from "react-bootstrap";

import useToast from "$hooks/utilities/useToast";

export default function ToastContainer() {
  const { toasts, removeToast, clearToasts } = useToast();
  return toasts.length ? (
    <BootstrapToastContainer className="p-3 text-white" position="top-end">
      {toasts.map((toast) => (
        <Toast key={toast.id} bg={toast.level} className="d-flex between-center p-2" onClose={clearToasts} autohide>
          {toast.message}
          <CloseButton onClick={() => removeToast(toast.id)} variant="white" className="p-0" />
        </Toast>
      ))}
    </BootstrapToastContainer>
  ) : null;
}
