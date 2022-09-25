import React from "react";
import { Modal } from "react-bootstrap";

import { useState } from "$hooks/core/state";

export default function UpdateCategoryConfirmModal({ onClose, onConfirm }) {
  const [isModalActive, setIsModalActive] = useState(true);
  return (
    <Modal show={isModalActive} onHide={() => setIsModalActive(false)} onExited={onClose} centered size="lg">
      <Modal.Header closeButton>
        <Modal.Title>تغییر دسته بندی</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <div className="d-flex flex-column align-items-center">
          <span className="svg-icon svg-icon-5tx svg-icon-danger mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
              <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
              <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
            </svg>
          </span>
          <h3 className="mb-5">آیا مطمئن هستید؟</h3>
          <p className="text-center fs-6 mb-0">با تغییر دسته بندی تمامی ویژگی ها،خصوصیت ها و متغیر های محصول از نوع متغیر وابسته به دسته بندی فعلی حذف خواهند شد</p>
        </div>
      </Modal.Body>
      <Modal.Footer>
        <button className="btn btn-danger" onClick={onConfirm}>
          مطمئنم
        </button>
        <button className="btn btn-secondary" onClick={() => setIsModalActive(false)}>
          بستن
        </button>
      </Modal.Footer>
    </Modal>
  );
}
