<?php

namespace App\Classes\Paginate;

class Paginator
{
    public $items = null;
    public $total_items_count = 0;
    public $page = 1;
    public $limit = 9;
    public $offset = 0;
    public $has_prev_page = false;
    public $has_next_page = false;
    public $has_pages = false;
    public $prev_page = null;
    public $next_page = null;
    public $total_pages = null;
    public $start_page = null;
    public $end_page = null;
    public $start_item_index = null;
    public $end_item_index = null;
    public $pages = [];

    public function __construct($total = 0, $options = [])
    {
        $this->items = collect();
        if ($this->total_items_count = $total) {
            extract(array_merge(["page" => $this->page, "limit" => $this->limit, "max_page" => 10], $options));
            $limit  = is_numeric($limit) && ($limit = (int) $limit) > 0 ? $limit : $this->limit;
            $page  = is_numeric($page) && ($page = (int) $page) > 0 ? $page : $this->page; // instead if page is invalid we can pass page as array which second element is default value for page,same for limit and other fields
            $total_pages = $this->total_pages = (int) ceil($total / $limit);
            if ($page < 1) {
                $page = 1;
            } else if ($page > $total_pages && $total_pages !== 0) {
                $page = $total_pages;
            }
            if ($total_pages <= $max_page) {
                $start_page = 1;
                $end_page = $total_pages;
            } else {
                $max_page_before_page = (int) floor($max_page / 2);
                $max_page_after_page = (int) ceil($max_page / 2) - 1;
                if ($page <= $max_page_before_page) {
                    $start_page = 1;
                    $end_page = $max_page;
                } else if ($page + $max_page_after_page >= $total_pages) {
                    $start_page = $total_pages - $max_page + 1;
                    $end_page = $total_pages;
                } else {
                    $start_page = $page - $max_page_before_page;
                    $end_page = $page + $max_page_after_page;
                }
            }
            $this->page = $page;
            $this->limit = $limit;
            $this->start_page = $start_page;
            $this->end_page = $end_page;
            $offset = $this->offset = ($page - 1) * $limit;
            $start_item_index = $this->start_item_index = $offset;
            $this->end_item_index = min($start_item_index + $limit - 1, $total - 1);
            $this->pages = array_map(fn ($i) => $start_page + $i, range(0, $end_page - $start_page));
            $has_prev_page = $this->has_prev_page = $page > 1;
            $has_next_page = $this->has_next_page = $page < $total_pages;
            $this->prev_page = $has_prev_page ? $page - 1 : 1;
            $this->next_page = $has_next_page ? $page + 1 : $total_pages;
            $this->has_pages = $total_pages > 1;
        }
    }
    public static function paginateArray($items, $options = [])
    {
        $paginator = new self(count($items), $options);
        if (!$paginator->total_items_count) return $paginator;
        $paginator->items = collect(array_slice($items, $paginator->start_item_index, $paginator->end_item_index + 1));
        return $paginator;
    }
}
