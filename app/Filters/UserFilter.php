<?php

namespace App\Filters;

use App\Models\{User};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserFilter extends QueryFilter
{
 
    public function rules(): array
    {
        return [
            'search' => 'filled',
            'role' => 'in:user,employee,administrator',
            'order' => 'in:name,email,banned',
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

    public function order($query, $order)
    {
        return $query->orderBy($order, 'asc');
    }
}