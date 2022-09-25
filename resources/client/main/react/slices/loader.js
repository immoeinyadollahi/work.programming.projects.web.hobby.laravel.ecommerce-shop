import { createSlice } from "@reduxjs/toolkit";

const LoaderSlice = createSlice({
    name: "loader",
    initialState: {
        isActive: false,
    },
    reducers: {
        updateLoader: (state, { payload }) => payload,
    },
});

export const { updateLoader } = LoaderSlice.actions;
export default LoaderSlice.reducer;
