import { Modal } from "react-bootstrap";

export default function Error500() {
  return (
    <Modal show={true} onHide={() => location.reload()} centered>
      <Modal.Body>
        <div className="d-flex flex-column align-items-center" style={{ padding: "50px 0" }}>
          <h1 className="mb-5 display-1">500</h1>
          <p className="text-center" style={{ lineHeight: 1.6 }}>
            متاسفانه مشکلی سمت سرور پیش آمده است
          </p>
        </div>
      </Modal.Body>
    </Modal>
  );
}
