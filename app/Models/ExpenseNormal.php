<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseNormal extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = 'tbl_expense_normal';
	protected $primaryKey = 'expense_normal_id';
	protected $dates = ['deleted_at'];

	protected $guarded  = [];
}
