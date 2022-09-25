import { ProgressBar } from "react-bootstrap";

import useLoader from "$hooks/actions/useLoader";

export default function Loader() {
    const { loader } = useLoader();
    return (
        loader.isActive && (
            <div className="loader">
                <ProgressBar animated now={100} />
            </div>
        )
    );
}
