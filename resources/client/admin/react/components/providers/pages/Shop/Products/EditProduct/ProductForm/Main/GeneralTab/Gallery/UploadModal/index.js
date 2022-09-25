import React from "react";
import { Modal } from "react-bootstrap";
import { useDropzone, ErrorCode } from "react-dropzone";
import _ from "lodash";

import { useState } from "$hooks/core/state";
import Upload from "./Upload";

export default function UploadModal({ onClose, onSave }) {
  const [isModalActive, setIsModalActive] = useState(true);
  const [uploads, setUploads, updateUploads] = useState([]);
  const [errors, setErrors] = useState();
  const { getRootProps, getInputProps } = useDropzone({
    onDrop: (files) => {
      setErrors();
      setUploads(
        uploads.concat(
          files.map((file) => ({
            key: _.uniqueId(),
            file,
            status: "uploading",
          }))
        )
      );
    },
    onDropRejected: (rejections) => {
      setErrors(
        Object.values(
          rejections.reduce(
            (acc, current) =>
              current.errors.forEach((error) => {
                if (!acc[error.code]) {
                  let message;
                  switch (error.code) {
                    case ErrorCode.FileInvalidType:
                      message = "فرمت فایل باید PNG ، JPG یا JPEG باشد";
                      break;
                    case ErrorCode.FileTooLarge:
                      message = "تصویر باید کمتر از 5 مگابایت باشد";
                      break;
                    default:
                      message = "فایل انتخاب شده مورد قبول نیست";
                      break;
                  }
                  acc[error.code] = message;
                }
              }),
            {}
          )
        )
      );
    },
    accept: ["png", "jpg", "jpeg"],
    maxSize: 5000000,
  });
  const handleSave = () => {
    onSave(uploads.filter((upload) => upload.status === "completed").map((upload) => ({ id: upload.thumbnailId, url: upload.thumbnailUrl })));
  };
  return (
    <Modal show={isModalActive} onHide={() => setIsModalActive(false)} onExited={onClose} centered>
      <Modal.Header closeButton>
        <Modal.Title>افزودن تصویر گالری</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <div {...getRootProps({ className: "dropzone" })}>
          <input {...getInputProps()} />
          <h6 className="mb-0">تصاویر را اینجا رها کنید یا برای آپلود کلیک کنید.</h6>
        </div>
        {errors ? (
          <div className="mt-2">
            {errors.map((error, idx) => (
              <div className="alert alert-danger" key={idx}>
                {error}
              </div>
            ))}
          </div>
        ) : null}
        {uploads.length ? (
          <ul class="list-group">
            {uploads.map((upload, idx) => (
              <Upload upload={upload} key={upload.key} updateUpload={(cb) => updateUploads((state) => cb(state[idx]))} onRemove={() => updateUploads((state) => state.splice(idx, 1))} />
            ))}
          </ul>
        ) : null}
      </Modal.Body>
      <Modal.Footer>
        <button className="btn btn-primary" disabled={uploads.some((upload) => upload.status === "uploading")} onClick={handleSave}>
          ذخیره
        </button>
        <button className="btn btn-secondary" onClick={() => setIsModalActive(false)}>
          بستن
        </button>
      </Modal.Footer>
    </Modal>
  );
}
