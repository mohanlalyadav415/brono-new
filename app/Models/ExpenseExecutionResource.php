<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseExecutionResource extends Model
{
    use HasFactory, SoftDeletes;
     protected $table = 'tbl_expense_execution_resource';
     protected $primaryKey = 'expense_execution_resource_id';
     protected $dates = ['deleted_at'];

      protected $guarded  = [];
}
 