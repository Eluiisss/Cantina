<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ['collected_date', 'payment_date'];

    public function articles()
    {
        return $this->belongsToMany(Article::class)
            ->withTimestamps()
            ->withPivot(['quantity']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new OrderQuery($query);
    }
}
