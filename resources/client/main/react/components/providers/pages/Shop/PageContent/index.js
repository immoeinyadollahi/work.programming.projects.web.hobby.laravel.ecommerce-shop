import React from "react";
import { Pagination } from "@mui/material";

import * as categoriesHttp from "$http/categories";
import { useState } from "$hooks/core/state";
import useQuery from "$hooks/utilities/useQuery";
import { useDependencyChangeEffect } from "$hooks/core/lifecycle";
import useLoader from "$hooks/actions/useLoader";
import useErrorHandler from "$hooks/common/useErrorHandler";
import ProductsSearchContext from "$contexts/partials/ProductsSearch";
import Topbar from "$components/partials/ProductsSearch/PageContent/Topbar";
import ProductCard from "$components/shared/ProductCard";
import Sidebar from "./Sidebar";

const productsPaginator = _getData("pageData.productsPaginator");
const category = _getData("pageData.category");

export default function PageContent() {
  const [paginator, setPaginator] = useState(productsPaginator);
  const { toggleLoader } = useLoader();
  const { handleHttpError } = useErrorHandler();
  const { query, queryChange, hasQueryState, setSearchQuery, toggleSearchQuery, getQuerySearchParams } = useQuery({
    defaultQuery: { limit: 18, page: 1 },
  });
  useDependencyChangeEffect(async () => {
    try {
      toggleLoader(true);
      const {
        data: { paginator },
      } = await categoriesHttp.getProducts(category.id, getQuerySearchParams());
      setPaginator(paginator);
      toggleLoader(false);
    } catch (err) {
      handleHttpError(err, {
        onBeforeDefaultAction: () => toggleLoader(false),
      });
    }
  }, [queryChange]);
  console.log(category)
  return (
    <ProductsSearchContext.Provider value={{ query, setSearchQuery, toggleSearchQuery, hasQueryState }}>
      <div className="shop-layout shop-layout--sidebar--start">
        <Sidebar />
        <div className="shop-layout__content">
          <div className="block">
            {paginator.total_items_count ? (
              <div className="products-view">
                <Topbar paginator={paginator} />
                <div className="products-view__list products-list" data-layout="grid-3-sidebar" data-with-features="false">
                  <div className="products-list__body">
                    {paginator.items.map((product) => (
                      <ProductCard key={product.id} product={product} />
                    ))}
                  </div>
                </div>
                {paginator.has_pages && (
                  <div className="products-view__pagination d-flex justify-content-center">
                    <Pagination count={paginator.total_pages} page={query.page} onChange={(e, page) => setSearchQuery({ page })} />
                  </div>
                )}
              </div>
            ) : (
              <div className="alert alert-primary mb-0 text-center">نتیجه ای یافت نشد</div>
            )}
          </div>
        </div>
      </div>
    </ProductsSearchContext.Provider>
  );
}
