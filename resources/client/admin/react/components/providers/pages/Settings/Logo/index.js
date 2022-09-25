import React from "react";
import path from "path-browserify";
import { ProgressBar } from "react-bootstrap";

import * as settingsHttp from "$http/settings";
import * as _Upload from "$utilities/upload";
import useErrorHandler from "$hooks/common/useErrorHandler";
import { useState } from "$hooks/core/state";

const settings = _getData("pageData.settings");

export default function Logo() {
  const [error, setError] = useState();
  const [image, setImage] = useState(settings.logo.url && { url: settings.logo.url });
  const [uploadFile, setUploadFile] = useState();
  const [isUploading, setIsUploading] = useState();
  const [uploadProgress, setUploadProgress] = useState(0);
  const { handleHttpError } = useErrorHandler();

  const handleImageInputChange = (e) => {
    setError();
    const file = e.target.files[0];
    if (file.size > 5000000) {
      setError("تصویر باید کمتر از 5 مگابایت باشد");
    } else if (![".png", ".jpg", ".jpeg"].includes(path.extname(file.name))) {
      setError("فرمت فایل باید PNG ، JPG یا JPEG باشد");
    } else {
      setUploadFile(file);
      // preview
      const reader = new FileReader();
      reader.addEventListener("load", (e) => setImage(image ? { ...image, url: e.target.result } : { url: e.target.result }));
      reader.readAsDataURL(file);
    }
    e.target.value = "";
  };
  const resetUpload = () => {
    setUploadFile();
    setIsUploading(false);
    setUploadProgress(0);
  };
  const handleStartUpload = async () => {
    try {
      setIsUploading(true);
      const formData = new FormData();
      formData.append("logo", uploadFile);
      const {
        data: { logo_temp_id, logo_url },
      } = await settingsHttp.postLogo(formData, {
        onUploadProgress: (e) => setUploadProgress(_Upload.calculateProgress(e.loaded, e.total)),
      });
      setImage({ temp_id: logo_temp_id, url: logo_url });
      resetUpload();
    } catch (err) {
      handleHttpError(err, {
        onBeforeDefaultAction: () => (resetUpload(), setError("مشکلی در انجام عملیات پیش آمده است")),
      });
    }
  };
  return (
    <div className="d-flex flex-column align-items-center">
      {image && image.temp_id && <input type="hidden" value={image.temp_id} name="temp_logo" />}
      {/*begin::Image input*/}
      <div className="image-input image-input-outline" data-kt-image-input="true">
        {/*begin::نمایش existing avatar*/}
        <div
          className="image-input-wrapper w-150px h-150px"
          style={
            image
              ? {
                  backgroundImage: `url(${image.url})`,
                  backgroundPosition: "center",
                }
              : {}
          }
        />
        {/*end::نمایش existing avatar*/}
        {/*begin::Tags*/}
        <label className="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change">
          <i className="bi bi-pencil-fill fs-7" />
          {/*begin::Inputs*/}
          <input type="file" accept=".png,.jpg,.jpeg" onChange={handleImageInputChange} />
          {/*end::Inputs*/}
        </label>
        {/*end::Tags*/}
      </div>
      {/*end::Image input*/}
      {error && <div className="fs-7 mt-4">{error}</div>}
      {uploadFile && (
        <div className="d-flex justify-content-center w-100 mt-4">
          {isUploading ? (
            <ProgressBar className="mw-200px w-100" now={uploadProgress} label={`${uploadProgress}%`} />
          ) : (
            <button className="btn btn-success" onClick={handleStartUpload}>
              آپلود
            </button>
          )}
        </div>
      )}
    </div>
  );
}
