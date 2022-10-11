<?php

namespace App\Providers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Utilities\Flash;
use App\Classes\Paginate\Paginator;
use App\Database\Models\DBKey;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerMacros();
        $this->test();
    }
    public function registerMacros()
    {
        // Collection
        Collection::macro("findIndex", function ($callback) {
            foreach ($this as $key => $value) {
                if ($callback($value, $key)) {
                    return $key;
                }
            }
            return -1;
        });
        // Request
        Request::macro("_trimAll", function ($convert_empty_to_null = false) {
            $this->merge(_trim_array($this->input(), $convert_empty_to_null ? fn ($value) => $value === "" ? null : $value : null));
        });
        Request::macro("_trimDeep", function ($keys, $convert_empty_to_null = false) {
            $this->replace(_trim_deep($this->input(), Arr::wrap($keys), $convert_empty_to_null ? fn ($value) => $value === "" ? null : $value : null));
        });
        Request::macro("_trimOnly", function ($keys, $convert_empty_to_null = false) {
            $this->merge(_trim_array($this->only($keys), $convert_empty_to_null ? fn ($value) => $value === "" ? null : $value : null));
        });
        Request::macro("_trimExcept", function ($keys, $convert_empty_to_null = false) {
            $this->merge(_trim_array($this->except($keys), $convert_empty_to_null ? fn ($value) => $value === "" ? null : $value : null));
        });
        // Response Factory
        ResponseFactory::macro("_sendStatus", fn ($status) => $this->noContent($status));
        ResponseFactory::macro("_ok", fn () => $this->_sendStatus(200));
        ResponseFactory::macro("_created", fn () => $this->_sendStatus(201));
        // Redirector
        Redirector::macro("_route", function ($route, ...$rest) {
            return redirect()->route(_route_name($route), ...$rest);
        });
        // Redirect Response
        RedirectResponse::macro("_withMessage", function ($message, $level) {
            Flash::addMessage($message, $level);
            return $this;
        });
        RedirectResponse::macro("_withMessages", function ($messages, $level = null) {
            Flash::addMessages($messages, $level);
            return $this;
        });
        RedirectResponse::macro("_withValidationResult", function ($validation_result, $only_messages = false) {
            // validation result is always failed here
            if ($validation_result->exception) {
                if ($only_messages) {
                    $this->_withMessages($validation_result->exception->messages, "danger");
                } else {
                    $this->withErrors($validation_result->exception->validator);
                }
            }
            if ($validation_result->messagesBag->isNotEmpty()) $this->_withMessages($validation_result->messagesBag->all());
            return $this;
        });
        // View
        View::macro("_withData", function ($key, $value) {
            return $this->with("_" . $key, $value);
        });
        View::macro("_fileName", function () {
            $keys = explode(".", $this->name());
            return $keys[count($keys) - 1];
        });
        // Eloquent
        QueryBuilder::macro("_deleteFirst", function () {
            return $this->limit(1)->delete();
        });
        QueryBuilder::macro("_updateFirst", function ($values) {
            return $this->limit(1)->update($values);
        });
        QueryBuilder::macro("_ordered", function ($direction = "asc") {
            return $this->orderBy($this->model::class::$orderable ?? "order", $direction);
        });
        QueryBuilder::macro("_basePaginate", function ($options = [], $columns = ['*']) {
            extract(array_merge(["page" => null, "limit" => 9], $options));
            return $this->paginate($limit, $columns, "page", $page);
        });
        QueryBuilder::macro("_paginate", function ($options = [], $columns = ['*']) {
            $total = $this->toBase()->getCountForPagination();
            $paginator = new Paginator($total, $options);
            if ($total) {
                $paginator->items = $this->forPage($paginator->page, $paginator->limit)->get($columns);
            }
            return $paginator;
        });
        // BelongsToMany Relation
        BelongsToMany::macro("_orderedByPivot", function ($direction = "asc") {
            return $this->orderByPivot($this->getPivotClass()::$orderable ?? "order", $direction);
        });
        // Database Schema Blueprint
        Blueprint::macro("_tokenable", function () {
            $this->string("token");
            $this->string('issue_id');
        });
        Blueprint::macro("_orderable", function ($column = "order") {
            return $this->integer($column);
        });
        Blueprint::macro("_foreignKey", function ($column, $cb = null) {
            $column_def = $this->unsignedBigInteger($column)->nullable();
            $cb && $cb($column_def);
            $key = DBKey::create(["type" => "foreign", "columns" => $column, "table" => $this->getTable()]);
            return $this->foreign($column, "key_" . $key->id)->references("id");
        });
        Blueprint::macro("_dropForeignKey", function ($column) {
            $key = DBKey::where(["type" => "foreign", "columns" => $column, "table" => $this->getTable()])->first();
            return $this->dropForeign("key_" . $key->id);
        });
    }
    public function test()
    {
    }
}
