import React, { useRef, useEffect } from "react";

export default function DatePicker({ onChange, initialValue }) {
    const inputRef = useRef();
    useEffect(() => {
        $(inputRef.current).persianDatepicker({
            format: "YYYY/MM/DD",
            initialValue: !!initialValue,
            onSelect: onChange,
        });
    }, []);
    return (
        <input
            type="text"
            className="form-control"
            defaultValue={initialValue}
            ref={inputRef}
        />
    );
}
