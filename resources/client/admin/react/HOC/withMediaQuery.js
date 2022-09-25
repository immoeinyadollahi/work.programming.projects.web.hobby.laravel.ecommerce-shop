import MediaQuery from "react-responsive";

export default function withMediaQuery(Component, options) {
  return function (props) {
    return (
      <MediaQuery {...options}>
        <Component {...props} />
      </MediaQuery>
    );
  };
}
