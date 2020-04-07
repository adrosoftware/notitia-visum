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

    public function __construct(LengthAwarePaginator $paginator, $pkColumn = null, $editRoute = null)
    {
        $this->paginator = $paginator;
        $this->pkColumn = $pkColumn;
        $this->editRoute = $editRoute;

        $this->setPaginatorView();
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