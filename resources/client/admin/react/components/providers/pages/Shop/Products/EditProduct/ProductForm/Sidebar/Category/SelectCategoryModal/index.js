import React from "react";
import _ from "lodash";
import { Modal } from "react-bootstrap";

import * as productsHttp from "$http/shop/products";
import { useState } from "$hooks/core/state";
import useData from "$hooks/actions/useData";
import useErrorHandler from "$hooks/common/useErrorHandler";
import Category from "./Category";
import UpdateCategoryConfirmModal from "./UpdateCategoryConfirmModal";

const categoriesTree = _getData("pageData.categories");

export default function SelectCategoryModal({ onClose, onSave }) {
  const { data } = useData();
  const productCategories = data.product.categories;
  const productMainCategory = data.product.main_category;
  const [isModalActive, setIsModalActive] = useState(true);
  const [isUpdateCategoryConfirmModalActive, setIsUpdateCategoryConfirmModalActive] = useState(false);
  const [isSubmiting, setIsSubmiting] = useState(false);
  const [selectedCategory, setSelectedCategory] = useState(productMainCategory?.id);
  const { handleHttpError } = useErrorHandler();
  const handleSaveCategory = async () => {
    try {
      setIsSubmiting(true);
      const {
        data: { categories, main_category },
      } = await productsHttp.patchCategory(data.product.id, { category_id: selectedCategory });
      setIsModalActive(false);
      onSave(categories, main_category);
    } catch (err) {
      handleHttpError(err, { onBeforeDefaultAction: () => setIsSubmiting(false) });
    }
  };
  const handleSaveBtnClick = () => {
    if (productMainCategory) {
      setIsUpdateCategoryConfirmModalActive(true);
    } else {
      handleSaveCategory();
    }
  };
  return (
    <>
      <Modal show={isModalActive} className="product-category-modal" onHide={() => setIsModalActive(false)} onExited={onClose} centered scrollable>
        <Modal.Header closeButton>
          <Modal.Title>انتخاب دسته بندی</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          {categoriesTree.length ? (
            <div className="categories-list">
              {categoriesTree.map((category) => (
                <Category productCategories={productCategories} category={category} selectedCategory={selectedCategory} setSelectedCategory={setSelectedCategory} key={category.id} />
              ))}
            </div>
          ) : (
            <div className="alert alert-primary mb-0">در حال حاظر دسته بندی وجود ندارد</div>
          )}
        </Modal.Body>
        <Modal.Footer>
          <button className="btn btn-primary" onClick={handleSaveBtnClick} disabled={isSubmiting || !selectedCategory || (productMainCategory ? productMainCategory.id === selectedCategory : false)}>
            {isSubmiting ? <span className="spinner-border spinner-border-sm"></span> : "ذخیره تغییرات"}
          </button>
          <button className="btn btn-secondary" onClick={() => setIsModalActive(false)} disabled={isSubmiting}>
            بستن
          </button>
        </Modal.Footer>
      </Modal>
      {isUpdateCategoryConfirmModalActive && <UpdateCategoryConfirmModal onClose={() => setIsUpdateCategoryConfirmModalActive(false)} onConfirm={handleSaveCategory} />}
    </>
  );
}
