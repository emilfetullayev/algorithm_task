<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bond extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const UPDATED_AT = null;

   protected $casts = [
       'interest_payment_date'  => 'date:Y-m-d',

   ];
}
