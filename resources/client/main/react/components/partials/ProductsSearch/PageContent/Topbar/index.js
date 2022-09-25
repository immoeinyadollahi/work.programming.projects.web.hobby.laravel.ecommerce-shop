import React from "react";

import * as _String from "$utilities/string";
import Limit from "./Limit";
import Sort from "./Sort";

export default function Topbar({ paginator }) {
    return (
        <div className="products-view__options">
            <div className="view-options">
                <div className="view-options__legend">
                    {`${_String.getThousandSeparated(
                        paginator.total_items_count
                    )} کالا`}
                </div>
                <div className="view-options__divider" />
                <Sort />
                <Limit />
            </div>
        </div>
    );
}
