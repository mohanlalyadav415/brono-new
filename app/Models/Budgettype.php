<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budgettype extends Model
{ 
    use HasFactory, SoftDeletes;
     protected $table = 'tbl_budget_type';
     protected $primaryKey = 'budget_type_id';
     protected $dates = ['deleted_at'];

      protected $guarded  = [];
}
