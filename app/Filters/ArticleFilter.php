<?php


namespace App\Filters;


class ArticleFilter extends QueryFilter
{

    public function rules(): array
    {
       return [
                'search' => 'filled',
                'category' => 'exists:categories,name',
                'stock' => 'in:with,without',
                'allergy' => 'in:allergy,nonallergy',
                'veg' => 'in:veg,nonveg',
            ];
    }

    public function stock($query, $stock, $operator = '>')
    {
        if($stock == 'without'){
            $operator = '<=';
        }
        return $query->where('stock', $operator, 0);
    }

    public function allergy($query, $allergy, $operator = 1)
    {
        if($allergy == 'nonallergy'){
            $operator = 0;
        }
        return $query->whereHas('nutrition', function ($query) use ($operator){
            $query->where('is_allergy', $operator);
        });
    }

    public function veg($query, $allergy, $operator = 1)
    {
        if($allergy == 'nonveg'){
            $operator = 0;
        }
        return $query->whereHas('nutrition', function ($query) use ($operator){
            $query->where('is_veg', $operator);
        });
    }

    public function category($query, $category)
    {
        return $query->whereHas('category', function ($query) use ($category){
            $query->where('name', $category);
        });
    }

    public function search($query, $search)
    {
        return $query->where(function ($query) use ($search){
            return $query->orWhere('name', 'like', "%$search%")
                ->orWhereHas('category', $this->subQuery($search, 'name'))
                ->orWhereHas('nutrition', $this->subQuery($search, 'allergy_description'));
        });
    }

    public function subQuery($search, $column)
    {
        return function ($query) use ($search, $column) {
            $query->where($column, 'like', "%{$search}%");
        };
    }
}
