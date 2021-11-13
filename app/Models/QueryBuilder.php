<?php

namespace App\Models;

use http\Exception\BadMethodCallException;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\QueryFilter;
use Illuminate\Support\Facades\DB;

class QueryBuilder extends Builder
{
    private $filters;
    public function onlyTrashedIf($value)
    {
        if ($value) {
            $this->onlyTrashed();
        }

        return $this;
    }

    public function whereQuery($subquery, $operator, $value = null)
    {
        $this->addBinding($subquery->getBindings());
        $this->where(DB::raw("({$subquery->toSql()})"), $operator, $value);

        return $this;
    }

    public function filterBy(QueryFilter $filters, array $data)
    {
        $this->filters = $filters;

        return $filters->applyTo($this, $data);
    }

    public function applyFilters(array $data = null)
    {
        return $this->filterBy($this->newQueryFilter(), $data ?: request()->all());
    }

    public function newQueryFilter()
    {
        if (method_exists($this->model, 'newQueryFilter')) {
            return $this->model->newQueryFilter();
        }

        if (class_exists($filterClass = '\App\Filters\\'.class_basename($this->model).'Filter')) {
            return new $filterClass;
        }

        throw new BadMethodCallException(
            sprintf('No query filter was found for the model [%s]', get_class($this->model))
        );

       
    }
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $paginator = parent::paginate($perPage, $columns, $pageName, $page);

        if ($this->filters) {
            $paginator->appends($this->filters->valid());
        }

        return $paginator;
    }
}
