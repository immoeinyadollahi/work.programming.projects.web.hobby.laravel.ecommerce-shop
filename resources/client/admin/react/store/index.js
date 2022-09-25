import { configureStore } from "@reduxjs/toolkit";

import loaderReducer from "../slices/loader";
import userReducer from "../slices/user";
import dataReducer from "../slices/data";

export default configureStore({
    reducer: {
        loader: loaderReducer,
        data: dataReducer,
        user: userReducer,
    },
    devTools: process.env.NODE_ENV === "development",
    preloadedState: _getData("pageData.redux"),
});
