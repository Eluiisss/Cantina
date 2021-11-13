<?php

namespace App\Filters;

use App\Models\{Sortable,User};
use App\Rules\SortableColumn;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserFilter extends QueryFilter
{
    protected $aliasses = [
        'date' => 'created_at',
        'login' => 'last_login_at',
    ];

    public function getColumnName($alias)
    {
        return $this->aliasses[$alias] ?? $alias;
    }

    public function rules(): array
    {
        return [
            'search' => 'filled',
            'role' => 'in:user,employee,administrator',
            'order' => [new SortableColumn(['name', 'email'])],
        ];
    }

    public function search($query, $search)
    {
        return $query->whereRaw('name like ?', "%$search%")
            ->orWhere('email', 'like', "%$search%");
    }

    public function role($query, $role)
    {
        return $query->whereRoleIs($role);
    }


    public function order($query, $value)
    {
        [$column, $direction] = Sortable::info($value);

        $query->orderBy($this->getColumnName($column), $direction);
    }
}