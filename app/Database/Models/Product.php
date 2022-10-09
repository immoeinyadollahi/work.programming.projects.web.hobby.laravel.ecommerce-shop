<?php

namespace App\Database\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Attribute as CastAttribute;
use Illuminate\Database\Eloquent\Collection;

use App\Classes\Base\Database\Model;
use App\Classes\Paginate\Paginator;

/* 
    in most product queries we don't filter product by publishing status directly, instead we filter published products in related association joins
*/

class Product extends Model
{
    protected $table = 'products';
    protected $hidden = ["selected_su_id"];

    public static function aggregate($query, $options = [])
    {
        $req = request();
        $request_filters = [];
        $query_filters = [];

        $request_page = $req->query("page");
        $request_limit = $req->query("limit");
        $request_sort = $req->query("sort");

        $request_filters["price_min"]   = $req->query("price_min");
        $request_filters["price_max"]  = $req->query("price_max");
        $request_filters["only_available"]  = $req->query("only_available");
        $request_filters["only_discounted"] = $req->query("only_discounted");

        isset($options["on_get_request_filters"]) && $options["on_get_request_filters"]($request_filters);

        $sort = $request_sort && in_array($request_sort, ["most-relevant", "most-visited", "newest", "best-selling", "lowest-price", "highest-price"]) ? $request_sort : "most-visited";
        $limit = $request_limit && in_array($request_limit, ["18", "27", "36"]) ? (int)$request_limit : 18;

        $can_perform_query = false;
        do {
            // Price Min Filter
            $query_filters["price_min"] = null;
            $request_price_min_filter = $request_filters["price_min"];
            if ($request_price_min_filter) {
                if (!(is_numeric($request_price_min_filter) && ($query_filters["price_min"] = (int)$request_price_min_filter) > 0)) break;
            }
            // Price Max Filter
            $query_filters["price_max"] = null;
            $request_price_max_filter = $request_filters["price_max"];
            if ($request_price_max_filter) {
                if (!(is_numeric($request_price_max_filter) && ($query_filters["price_max"] = (int)$request_price_max_filter) > 0)) break;
            }
            // Only Available Filter
            $query_filters["only_available"] = null;
            $request_only_available_filter = $request_filters["only_available"];
            if ($request_only_available_filter) {
                if ($request_only_available_filter !== "1") break;
                $query_filters["only_available"] = $request_only_available_filter;
            }
            // Only Discountded Filter
            $query_filters["only_discounted"] = null;
            $request_only_discounted_filter = $request_filters["only_discounted"];
            if ($request_only_discounted_filter) {
                if ($request_only_discounted_filter !== "1") break;
                $query_filters["only_discounted"] = true;
            }

            if (isset($options["on_sanitize_filters"]) && $options["on_sanitize_filters"]($request_filters, $query_filters) === false) break;

            $can_perform_query = true;
            break;
        } while (true);
        if ($can_perform_query) {
            $query->select("products.*");

            switch ($sort) {
                case "most-relevant":
                    $orderBy = "1";
                    break;
                case "most-visited":
                    $query->selectSub(ProductVisit::selectRaw("COUNT(*)")->where("product_id", "products.id"), "product_visits_count");
                    $orderBy = "product_visits_count desc";
                    break;
                case "newest":
                    $orderBy = "products.created_at desc";
                    break;
                case "best-selling":
                    $query->selectSub(ProductSale::selectRaw("COUNT(*)")->where("product_id", "products.id"), "product_sales_count");
                    $orderBy = "product_sales_count desc";
                    break;
                case "lowest-price":
                    $orderBy = "selected_products_su.sale_price asc";
                    break;
                case "highest-price":
                    $orderBy = "selected_products_su.sale_price desc";
                    break;
            }

            $query
                ->withSelectedSu([
                    "conditions" => [
                        "only_available" => $query_filters["price_min"] ||
                            $query_filters["price_max"] ||
                            $query_filters["only_available"],
                        "only_discounted" => $query_filters["only_discounted"]
                    ],
                    "on_join" => fn ($join) => $join
                        ->when($query_filters["price_min"], function ($query, $query_price_min_filter) {
                            $query->where("selected_products_su.sale_price", ">=", $query_price_min_filter);
                        })
                        ->when($query_filters["price_max"], function ($query, $query_price_max_filter) {
                            $query->where("selected_products_su.sale_price", "<=", $query_price_max_filter);
                        })
                ]);

            isset($options["on_su_selected"]) && $options["on_su_selected"]($query, $query_filters);

            return $query->orderByRaw($orderBy)->with($options["with"] ?? null)->_paginate(["page" => $request_page, "limit" => $limit]);
        }
        return new Paginator();
    }
    public static function aggregateByCategory($category)
    {
        $req = request();
        return self::aggregate($category->products(), [
            "with" => ["image"],
            "on_get_request_filters" => function (&$request_filters) use ($req) {
                $request_filters["search_term"] = $req->query("q");
                $request_filters["tag"] = $req->query("tag");
                $request_filters["brands"] = $req->query("brands");
                $request_filters["attributes"] = $req->query("attributes");
                $request_filters["properties"] = $req->query("properties");
            },
            "on_sanitize_filters" => function ($request_filters, &$query_filters) use ($category) {
                // Term Filter
                $query_filters["search_term"] = null;
                $request_search_term_filter = $request_filters["search_term"];
                if ($request_search_term_filter) {
                    if (is_string($request_search_term_filter)) {
                        $query_filters["search_term"] = $request_search_term_filter;
                    } else return false;
                }
                // Tag Filter
                $query_filters["tag"] = null;
                $request_tag_filter = $request_filters["tag"];
                if ($request_tag_filter) {
                    if (is_string($request_tag_filter) && ($request_tag_filter = Tag::where(["type" => self::class, "slug" => $request_tag_filter])->first())) {
                        $query_filters["tag"] = $request_tag_filter->id;
                    } else return false;
                }
                // Brands Filter
                $query_filters["brands"] = null;
                $request_brands_filter = $request_filters["brands"];
                if ($request_brands_filter) {
                    if (is_array($request_brands_filter)) {
                        $request_brands_filter = collect($request_brands_filter);
                        if ($request_brands_filter->every(fn ($value, $key) => is_numeric($key) && is_numeric($value)) && $category->brands()->whereIn("brands.id", $request_brands_filter)->count() === $request_brands_filter->count()) {
                            $query_filters["brands"] = $request_brands_filter;
                        }
                    }
                    if (!$query_filters["brands"]) return false;
                }
                // Properties Filter
                $query_filters["properties"] = null;
                $request_properties_filter = $request_filters["properties"];
                if ($request_properties_filter) {
                    if (is_array($request_properties_filter)) {
                        $request_properties_filter = collect($request_properties_filter);
                        if (
                            $request_properties_filter->every(fn ($values, $key) => is_numeric($key) && is_array($values)) &&
                            count($category_properties = $category->properties()->whereIn("properties.id", $request_properties_filter->keys())->get()) === $request_properties_filter->count() &&
                            $category_properties->every(fn ($property) => $property->pivot->values()->whereIn("property_values.id", $property_values = $request_properties_filter[$property->id])->count() === count($property_values))
                        ) {
                            $query_filters["properties"] = $request_properties_filter;
                        }
                    }
                    if (!$query_filters["properties"]) return false;
                };
                // Attributes Filter
                $query_filters["attributes"] = null;
                $request_attributes_filter = $request_filters["attributes"];
                if ($request_attributes_filter) {
                    if (is_array($request_attributes_filter)) {
                        $request_attributes_filter = collect($request_attributes_filter);
                        if (
                            $request_attributes_filter->every(fn ($values, $key) => is_numeric($key) && is_array($values)) &&
                            count($category_attributes = $category->attributes()->whereIn("attributes.id", $request_attributes_filter->keys())->get()) === $request_attributes_filter->count() &&
                            $category_attributes->every(fn ($attribute) => $attribute->pivot->values()->whereIn("attribute_values.id", $attribute_values = $request_attributes_filter[$attribute->id])->count() === count($attribute_values))
                        ) {
                            $query_filters["attributes"] = $request_attributes_filter;
                        }
                    }
                    if (!$query_filters["attributes"]) return false;
                }
            },
            "on_su_selected" => function ($query, $query_filters) {
                $query
                    ->when($query_filters["tag"], function ($query, $query_tag_filter) {
                        $query->join("taggables", fn ($join) => $join->on("taggables.target_id", "products.id")->where(["taggables.target_type" => self::class, "taggables.tag_id" => $query_tag_filter]));
                    })
                    ->when($query_filters["properties"], function ($query, $query_properties_filter) {
                        $properties_join_subquery = self::select("products.id as id")->where("products.status", "published")->groupBy("products.id");
                        foreach ($query_properties_filter as $key => $values) {
                            $properties_join_subquery->join("products_properties as products_properties_$key", function ($join) use ($key, $values) {
                                $join->on(["products_properties_$key.product_id" => "products.id"])->where("products_properties_$key.property_id", $key)->whereIn("products_properties_$key.property_value_id", $values);
                            });
                        }
                        $query->joinSub($properties_join_subquery, "products_matched_with_properties", function ($join) {
                            $join->on("products_matched_with_properties.id", "products.id");
                        });
                    })
                    ->when($query_filters["attributes"], function ($query, $query_attributes_filter) {
                        /* 
                            filter product if at least one of product variations has one of query attribute combination
                            e.g. one of the product variations, has color of x and also size of x
                        */
                        $attributes_join_subquery = ProductSu::select("products_su.product_id as product_id")->join("products", function ($join) {
                            // this join is currently optional and can be removed
                            $join->on([['products.id', "products_su.product_id"], ["products.type", "products_su.product_type"]])->where("products.status", "published");
                        })->where([["is_active", true], ["stock", "!=", 0]])->groupBy("products_su.product_id");
                        foreach ($query_attributes_filter as $key => $values) {
                            $attributes_join_subquery->join("variable_product_su_attributes as variable_product_su_attributes_$key", function ($join) use ($key, $values) {
                                $join->on(["variable_product_su_attributes_$key.product_su_id" => "products_su.id"])->where("variable_product_su_attributes_$key.attribute_id", $key)->whereIn("variable_product_su_attributes_$key.attribute_value_id", $values);
                            });
                        }
                        $query->joinSub($attributes_join_subquery, "variations_matched_with_attributes", function ($join) {
                            $join->on("variations_matched_with_attributes.product_id", "products.id");
                        });
                    })
                    ->when($query_filters["search_term"], function ($query, $query_search_term_filter) {
                        $query->where("products.name", "LIKE", "%" . $query_search_term_filter . "%");
                    })
                    ->when($query_filters["brands"], function ($query, $query_brands_filter) {
                        $query->whereIn("products.brand_id", $query_brands_filter);
                    });
            }
        ]);
    }
    public static function aggregateBySearch($search_term, $tag, &$request_query_result)
    {
        $req = request();
        return self::aggregate(self::query(), [
            "with" => ["image"],
            "on_get_request_filters" => function (&$request_filters) use ($req) {
                $request_filters["brands"] = $req->query("brands");
            },
            "on_sanitize_filters" => function ($request_filters, &$query_filters) use ($search_term, $tag, &$request_query_result) {
                // Term Filter
                $query_filters["search_term"] = null;
                $request_search_term_filter = $search_term;
                if ($request_search_term_filter) {
                    if (is_string($request_search_term_filter) && ($request_search_term_filter = trim($request_search_term_filter))) {
                        $query_filters["search_term"] = $request_query_result["search_term"] = $request_search_term_filter;
                    } else return false;
                }
                // Tag Filter
                $query_filters["tag"] = null;
                $request_tag_filter = $tag;
                if ($request_tag_filter) {
                    if (is_string($request_tag_filter) && ($request_tag_filter = Tag::where(["type" => self::class, "slug" => $request_tag_filter])->first())) {
                        $request_query_result["tag"] = $request_tag_filter->name;
                        $query_filters["tag"] = $request_tag_filter->id;
                    } else return false;
                }
                // Brands Filter
                $query_filters["brands"] = null;
                $request_brands_filter = $request_filters["brands"];
                if ($request_brands_filter) {
                    if (is_array($request_brands_filter)) {
                        $request_brands_filter = collect($request_brands_filter);
                        if ($request_brands_filter->every(fn ($value, $key) => is_numeric($key) && is_numeric($value)) && Brand::whereIn("id", $request_brands_filter)->count() === $request_brands_filter->count()) {
                            $query_filters["brands"] = $request_brands_filter;
                        }
                    }
                    if (!$query_filters["brands"]) return false;
                }
            },
            "on_su_selected" => function ($query, $query_filters) {
                $query
                    ->when($query_filters["tag"], function ($query, $query_tag_filter) {
                        $query->join("taggables", fn ($join) => $join->on("taggables.target_id", "products.id")->where(["taggables.target_type" => self::class, "taggables.tag_id" => $query_tag_filter]));
                    })
                    ->when($query_filters["search_term"], function ($query, $query_search_term_filter) {
                        $query->where("products.name", "LIKE", "%" . $query_search_term_filter . "%");
                    })
                    ->when($query_filters["brands"], function ($query, $query_brands_filter) {
                        $query->whereIn("products.brand_id", $query_brands_filter);
                    });
            }
        ]);
    }

    public function su()
    {
        return $this->hasMany(ProductSu::class, "product_id");
    }
    // this relation is not based on specific column on products table, it only fetches related model based on query selected column
    public function selectedSu()
    {
        return $this->belongsTo(ProductSu::class, 'selected_su_id');
    }
    public function simpleTypeSu()
    {
        return $this->hasOne(ProductSu::class, "product_id")->where("product_type", "simple");
    }
    public function variableTypeVariations()
    {
        return $this->hasMany(ProductSu::class, "product_id")->where("product_type", "variable");
    }
    public function variableTypeAttributes()
    {
        return $this->belongsToMany(Attribute::class, VariableProductAttribute::class)->withTimestamps()->withPivot(["id", "order"]);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'target');
    }
    public function favoredByUsers()
    {
        return $this->morphToMany(User::class, 'target', Favourite::class)->withTimestamps();
    }
    public function comments()
    {
        return $this->hasMany(ProductComment::class, "product_id");
    }
    public function thumbnails()
    {
        return $this->hasMany(ProductThumbnail::class, "product_id");
    }
    public function specificationGroups()
    {
        return $this->hasMany(ProductSpecificationGroup::class, "product_id");
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, ProductCategoryX::class)->withTimestamps();
    }
    public function mainCategory()
    {
        return $this->categories()->where("categories.is_last_level", true);
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, "target", Taggable::class)->withTimestamps();
    }
    public function sales()
    {
        return $this->belongsToMany(User::class, ProductSale::class)->withTimestamps();
    }
    public function visits()
    {
        return $this->hasMany(ProductVisit::class, "product_id");
    }
    public function properties()
    {
        return $this->belongsToMany(Property::class, ProductPropertyX::class)->withTimestamps();
    }

    public function scopePublished($query)
    {
        return $query->where("status", "published");
    }
    public function scopeWithSelectedSu($query, $options = [])
    {
        $selected_su_join_subquery = DB::query()->fromSub(ProductSu::selectRaw("products_su.*,row_number() OVER (PARTITION BY product_id ORDER BY if (products_su.stock = 0,999999999999,products_su.sale_price),products_su.stock desc) as row_num")
            ->join("products", function ($join) {
                $join->on(['products.id' => "products_su.product_id", "products.type" => "products_su.product_type"])->where("products.status", "published");
            })->where("products_su.is_active", true), "products_su")->where("products_su.row_num", 1);
        return $query->addSelect("selected_products_su.id as selected_su_id")->joinSub($selected_su_join_subquery, "selected_products_su", function ($join) use ($options) {
            $join->on("selected_products_su.product_id", "products.id");
            $conditions = collect($options["conditions"] ?? []);
            $conditions->get("only_available", true) && $join->where('selected_products_su.stock', "!=", 0);
            $conditions->get("only_discounted") && $join->whereNotNull("selected_products_su.discounted_price");
            isset($options["on_join"]) && $options["on_join"]($join);
        })->with("selectedSu");
    }
    public function scopeWithUserFavouriteCheck($query, $user = null)
    {
        $user = $user ?: _user();
        if (!$user) return $query->selectRaw("0 as is_user_favourite");
        $favourite_check_query = Favourite::selectRaw("1")->whereColumn("target_id", "products.id")->where(["target_type" => self::class, "user_id" => $user->id ?? _user()->id])->limit(1);
        return $query->selectRaw('IFNULL((' . $favourite_check_query->toSql() . '),0) as is_user_favourite', $favourite_check_query->getBindings());
    }

    public function getSelectedSu()
    {
        switch ($this->type) {
            case 'simple':
                return $this->simpleTypeSu()->active()->first();
            case 'variable':
                return $this->variableTypeVariations()->active()->orderByRaw('if (stock = 0,999999999999,sale_price),stock desc')->first();
        }
    }
    public function getMainCategoryWithRelatedData()
    {
        $main_category = $this->mainCategory()->with(collect(['brands', 'properties', 'attributes'])->reduce(function ($acc, $current) {
            $acc[$current] = fn ($query) => $query->_orderedByPivot();
            return $acc;
        }, []))->first();
        if ($main_category) {
            foreach (['properties', 'attributes'] as $relation_name) {
                $relation = $main_category->getRelation($relation_name);
                $relation->isNotEmpty() &&  (new Collection($relation->pluck("pivot")))->load(["values" => fn ($query) => $query->_orderedByPivot()]);
            }
        }
        return $main_category;
    }
    public function sortVariableTypeAttributes($attribute_ids)
    {
        $attributes_ordering_update = $attribute_ids->reduce(function ($acc, $current, $key) {
            $acc[$current] = ['order' => $key + 1];
            return $acc;
        }, []);
        $this->variableTypeAttributes()->sync($attributes_ordering_update);
        $this->variableTypeVariations()->get()->each(fn ($variation) => $variation->variableProductTypeAttributes()->sync($attributes_ordering_update));
    }
    public function rearrangeVariableTypeAttributes()
    {
        $this->sortVariableTypeAttributes($this->variableTypeAttributes()->_orderedByPivot()->pluck("attributes.id"));
    }

    protected function isVariable(): CastAttribute
    {
        return CastAttribute::get(fn () => $this->type === "variable");
    }
}
