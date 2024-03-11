<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = 'tbl_supplier';
	protected $primaryKey = 'supplier_id';
	protected $dates = ['deleted_at'];
	protected $guarded  = [];
}
