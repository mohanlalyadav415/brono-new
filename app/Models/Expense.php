<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = 'tbl_expense';
	protected $primaryKey = 'expense_id';
	protected $dates = ['deleted_at'];

	protected $guarded  = [];
}
