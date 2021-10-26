<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function Users()
    {
        return $this->hasMany(Users::class);
    }
}
