import useLoader from "$hooks/actions/useLoader";
import useData from "$hooks/actions/useData";
import { useDependencyChangeEffect } from "$hooks/core/lifecycle";
import { Fade } from "react-bootstrap";

export default function Loader() {
  const { data } = useData();
  const { loader, toggleLoader } = useLoader();

  useDependencyChangeEffect(() => {
    toggleLoader(data.loaderStateChange.state);
  }, [data.loaderStateChange]);

  return (
    <Fade in={loader.isActive} mountOnEnter unmountOnExit>
      <div className="page-loader">
        <div className="loader-inner">
          <div className="spinner-border"></div>
        </div>
      </div>
    </Fade>
  );
}
