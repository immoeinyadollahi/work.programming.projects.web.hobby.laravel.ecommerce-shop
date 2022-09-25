import { createSlice } from "@reduxjs/toolkit";

const dataSlice = createSlice({
  name: "data",
  initialState: {},
  reducers: {
    updateData: (state, { payload }) => payload,
  },
});

export const { updateData } = dataSlice.actions;
export default dataSlice.reducer;
