<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{ 
    use HasFactory, SoftDeletes;
     protected $table = 'tbl_budget';
      protected $primaryKey = 'budget_id';
      protected $dates = ['deleted_at'];
      
      protected $guarded  = [];
}
