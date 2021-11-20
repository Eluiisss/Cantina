<?php


namespace App\Filters;


class OrderFilter extends QueryFilter
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
            return $query->where('order_code', 'like', "%$search%")
                ->orWhereHas('user', function ($query) use ($search){
                return $query->where('name', 'like', "%$search%");
            });
        });
    }

}
