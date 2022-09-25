import React, { useEffect, useRef } from "react";
import axios from "axios";

import * as mediaHttp from "$http/shop/products/media";
import * as _Upload from "$utilities/upload";
import useErrorHandler from "$hooks/common/useErrorHandler";
import { useState } from "$hooks/core/state";

export default function Upload({ upload, updateUpload, onRemove }) {
  const [uploadProgress, setUploadProgress] = useState(0);
  const { handleHttpError } = useErrorHandler();
  const uploadCancelTokenRef = useRef();
  useEffect(() => {
    (async () => {
      try {
        const formData = new FormData();
        formData.append("thumbnail", upload.file);
        uploadCancelTokenRef.current = axios.CancelToken.source();
        const {
          data: { thumbnail_id, thumbnail_url },
        } = await mediaHttp.postThumbnail(formData, {
          cancelToken: uploadCancelTokenRef.current.token,
          onUploadProgress: (e) => setUploadProgress(_Upload.calculateProgress(e.loaded, e.total)),
        });
        updateUpload((upload) =>
          Object.assign(upload, {
            thumbnailId: thumbnail_id,
            thumbnailUrl: thumbnail_url,
            status: "completed",
          })
        );
      } catch (err) {
        handleHttpError(err, {
          onBeforeDefaultAction: () => {
            updateUpload((upload) => (upload.status = "failed"));
          },
        });
      }
    })();
    return uploadCancelTokenRef.current.cancel;
  }, []);
  return (
    <li class="list-group-item d-flex align-items-center justify-content-between">
      <div className="d-flex align-items-center">
        <span>{upload.file.name}</span>
        <div className="ms-4">{upload.status === "uploading" ? `${uploadProgress}%` : upload.status === "completed" ? <span className="badge bg-success">تکمیل شده</span> : <span className="badge bg-danger">ناموفق</span>}</div>
      </div>
      <button className="btn btn-danger" onClick={onRemove}>
        <span className="fal fa-times"></span>
      </button>
    </li>
  );
}
