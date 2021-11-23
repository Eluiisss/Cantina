<?php


namespace App\Filters;


class OrderFilter extends QueryFilter
{
    public function rules(): array
    {
        return [
            'search' => 'filled',
            'orderStatus' => 'in:no_recogido,pendiente,recogido',
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

    public function orderStatus($query, $status)
    {
        return $query->where('order_status', $status);
    }
}
