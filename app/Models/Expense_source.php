<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense_source extends Model
{
	use HasFactory;
	protected $table = 'tbl_expense_source';
	protected $primaryKey = 'expense_source_id'; 
	protected $guarded  = [];
}
