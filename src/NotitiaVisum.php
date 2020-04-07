<?php

namespace NotitiaVisum;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use NotitiaVisum\System\TableBrowser;

class NotitiaVisum
{
    private $connectionName;

    private $table;

    private $pk;

    private $editRoute;

    private $readRoute;

    private $whereRaw;

    public function __construct(
        $connectionName = null,
        $table = null,
        $pk = null
    ) {
        if ($connectionName !== null) {
            $connectionName = strval($connectionName);
        }

        $this->connectionName = $connectionName;
        $this->table = $table;
        $this->pk = $pk;
    }

    public function table($table)
    {
        $this->table = strval($table);

        return $this;
    }

    public function readRoute($readRoute)
    {
        $this->readRoute = strval($readRoute);

        return $this;
    }

    public function editRoute($editRoute)
    {
        if ($this->pk === null) {
            throw new Exception("Can't add edit route with a primary key column", 500);
        }

        $this->editRoute = strval($editRoute);

        return $this;
    }

    public function primaryKey($pk = null)
    {
        if ($pk !== null) {
            $this->pk = strval($pk);

            return $this;
        }

        return $this->pk;
    }

    public function whereRaw($statement)
    {
        $this->whereRaw = strval($statement);

        return $this;
    }

    public function browse($fields = ['*'])
    {
        if ($this->whereRaw !== null) {
            // Build SELECT statement.
            // $select "SELECT " implode(',', $fields)
            /** @var LengthAwarePaginator */
            $paginator = DB::connection($this->connectionName)
                ->table($this->table)->select($fields)->whereRaw($this->whereRaw)->paginate();

            if ($paginator->total() === 1) {
                $collection = DB::connection($this->connectionName)
                    ->table($this->table)->select($fields)->whereRaw($this->whereRaw)->get();

                $paginator->setCollection($collection);
            }
        } else {
            $paginator = DB::connection($this->connectionName)
                ->table($this->table)->select($fields)->paginate();
        }

        $browser =  new TableBrowser($paginator, $this->pk, $this->editRoute, $this->readRoute);

        $browser->getColumns();

        return view('notitia-visum::browse', ['browser' => $browser]);
    }

    public function read()
    {
        $paginator = DB::connection($this->connectionName)
        ->table($this->table)->select('*')->paginate();

        $browser =  new TableBrowser($paginator, $this->pk, $this->editRoute, $this->readRoute);

        return view('notitia-visum::browse', ['browser' => $browser]);
    }

    public function edit()
    {
        $paginator = DB::connection($this->connectionName)
            ->table($this->table)->select('*')->paginate();

        $browser =  new TableBrowser($paginator, $this->pk, $this->editRoute, $this->readRoute);

        return view('notitia-visum::browse', ['browser' => $browser]);
    }

    public function add()
    {
        $paginator = DB::connection($this->connectionName)
            ->table($this->table)->select('*')->paginate();

        $browser =  new TableBrowser($paginator, $this->pk, $this->editRoute, $this->readRoute);

        return view('notitia-visum::browse', ['browser' => $browser]);
    }

    public function delete()
    {
        $paginator = DB::connection($this->connectionName)
            ->table($this->table)->select('*')->paginate();

        $browser =  new TableBrowser($paginator, $this->pk, $this->editRoute, $this->readRoute);

        return view('notitia-visum::browse', ['browser' => $browser]);
    }
}
