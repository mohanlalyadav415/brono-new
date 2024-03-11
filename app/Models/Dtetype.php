<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Dtetype extends Model
{
    use HasFactory;
	protected $table = 'tbl_dte_type';
	protected $primaryKey = 'dte_type_id'; 
	protected $guarded  = [];
}
