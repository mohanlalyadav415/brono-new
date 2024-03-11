<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expensetypeproject extends Model
{ 
    use HasFactory, SoftDeletes;
     protected $table = 'tbl_expense_type_project';
      protected $primaryKey = 'expense_type_project_id';
      protected $dates = ['deleted_at'];

      protected $guarded  = [];
}
