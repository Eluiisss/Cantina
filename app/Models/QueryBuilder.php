<?php

namespace App\Models;

use http\Exception\BadMethodCallException;
use Illuminate\Database\Eloquent\Builder;

class QueryBuilder extends Builder
{
    public function onlyTrashedIf($value)
    {
        if ($value) {
            $this->onlyTrashed();
        }

        return $this;
    }

}
