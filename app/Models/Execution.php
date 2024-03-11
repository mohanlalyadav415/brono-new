<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Execution extends Model
{
    use HasFactory, SoftDeletes;
	protected $table = 'tbl_execution';
	protected $primaryKey = 'execution_id';
	protected $dates = ['deleted_at'];
	protected $guarded  = []; 
}
