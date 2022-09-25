import * as _ from "lodash";

export const paginateArray = ({
    items,
    sort,
    order = "desc",
    ...paginationOptions
}) => {
    const totalItemsCount = items.length;
    if (!totalItemsCount) return {};
    sort && (items = _.orderBy(items, [sort], [order]));
    const paginationInfo = getInfo({
        total: items.length,
        ...paginationOptions,
    });
    return {
        totalItems: items,
        items: items.slice(
            paginationInfo.startItemIndex,
            paginationInfo.endItemIndex + 1
        ),
        ...paginationInfo,
    };
};
export const getInfo = ({ total, page = 1, limit = 9, maxPages = 10 }) => {
    if (!total) return {};
    limit = !isNaN(limit) && limit > 0 ? Number(limit) : 9;
    page = isNaN(page) && page > 0 ? Number(page) : 1;
    let totalPages = Math.ceil(total / limit);
    if (page < 1) {
        page = 1;
    } else if (page > totalPages && totalPages !== 0) {
        page = totalPages;
    }
    let startPage, endPage;
    if (totalPages <= maxPages) {
        startPage = 1;
        endPage = totalPages;
    } else {
        let maxPagesBeforepage = Math.floor(maxPages / 2);
        let maxPagesAfterpage = Math.ceil(maxPages / 2) - 1;
        if (page <= maxPagesBeforepage) {
            startPage = 1;
            endPage = maxPages;
        } else if (page + maxPagesAfterpage >= totalPages) {
            startPage = totalPages - maxPages + 1;
            endPage = totalPages;
        } else {
            startPage = page - maxPagesBeforepage;
            endPage = page + maxPagesAfterpage;
        }
    }
    const offset = (page - 1) * limit;
    const startItemIndex = offset;
    const endItemIndex = Math.min(startItemIndex + limit - 1, total - 1);
    const pages = Array.from(Array(endPage - startPage).keys()).map(
        (i) => startPage + i
    );
    const hasPrevPage = page > 1;
    const hasNextPage = page < totalPages;
    const prevPage = hasPrevPage ? page - 1 : 1;
    const nextPage = hasNextPage ? page + 1 : totalPages;
    return {
        totalItemsCount: total,
        itemsCount: endItemIndex - startItemIndex + 1,
        page,
        limit,
        offset,
        hasPrevPage,
        hasNextPage,
        totalPages,
        startPage,
        endPage,
        nextPage,
        prevPage,
        startItemIndex,
        endItemIndex,
        pages,
    };
};
