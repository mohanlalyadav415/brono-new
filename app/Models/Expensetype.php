<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expensetype extends Model
{ 
    use HasFactory, SoftDeletes;
     protected $table = 'tbl_expense_type';
      protected $primaryKey = 'expense_type_id';
      protected $dates = ['deleted_at'];
      
      protected $guarded  = [];
}
