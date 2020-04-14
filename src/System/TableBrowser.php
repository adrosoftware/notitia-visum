<?php

namespace NotitiaVisum\System;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class TableBrowser
{
    /** @var LengthAwarePaginator */
    protected $paginator;

    protected $pkColumn;

    protected $editRoute;

    protected $table;

    protected $title;

    public function __construct($table, LengthAwarePaginator $paginator, $pkColumn = null, $editRoute = null)
    {
        $this->table = $table;
        $this->paginator = $paginator;
        $this->pkColumn = $pkColumn;
        $this->editRoute = $editRoute;

        $this->setPaginatorView();
    }

    public function setTitle($title)
    {
        $this->title = strval($title);

        return $this;
    }

    public function title()
    {
        if ($this->title === null) {
            return $this->table;
        }

        return $this->title;
    }

    public function records()
    {
        if (
            $this->pkColumn !== null &&
            is_string($this->pkColumn) &&
            $this->editRoute !== null &&
            is_string($this->editRoute)
        ) {
            $route = $this->editRoute;
            $parts = explode('/', $route);
            $last = count($parts) - 1;
            $parts[$last] = '{{id}}';
            $routeTemplate = implode('/', $parts);

            $collection = collect($this->paginator->items())->map(function ($record) use ($routeTemplate) {
                $id = $record->{$this->pkColumn};

                $record->editUrl = str_replace('{{id}}', $id, $routeTemplate);

                return $record;
            });

            $this->paginator->setCollection($collection);
        }

        $collection = collect($this->paginator->items())->map(function ($record) {
            if (isset($record->row_num) ) {
                unset($record->row_num);
            }

            return $record;
        });

        $this->paginator->setCollection($collection);

        return $this->paginator->items();
    }

    public function count()
    {
        return $this->paginator->total();
    }

    public function paginator()
    {
        return $this->paginator;
    }

    public function total()
    {
        return $this->paginator->total();
    }

    public function getColumns()
    {
        if ($this->total() === 0) {
            return [];
        }

        $item = $this->paginator->first();

        if (isset($item->row_num)) {
            unset($item->row_num);
        }

        return array_keys(get_object_vars($item));
    }

    public function rowHeaders()
    {
        $headers = $this->getColumns();

        $headers = collect($headers)->map(function ($header) {
            $header = str_replace('-', ' ', $header);
            $header = str_replace('_', ' ', $header);

            return $header;
        });

        return $headers->toArray();
    }

    public function setPaginatorView($view = 'notitia-visum::pagination.bootstrap-4')
    {
        LengthAwarePaginator::$defaultView = strval($view);
    }

    public function hasEditRoute()
    {
        return boolval($this->editRoute);
    }
}