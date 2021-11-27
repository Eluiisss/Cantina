<?php


namespace App\Filters;


class CategoryFilter extends QueryFilter
{

    public function rules(): array
    {
        return [
            'search' => 'filled',
        ];
    }

    public function search($query, $search)
    {
        return $query->where(function ($query) use ($search){
            return $query->orWhere('name', 'like', "%$search%")
                         ->orWhere('description', 'like', "%$search%");
        });
    }
}
