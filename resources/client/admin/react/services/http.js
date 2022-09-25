import axios from "axios";

import * as _Global from "../utilities/global";

/**
 * @type {axios}
 */
const http = _Global.get("__SERVICES__.httpClient");
export default http;
