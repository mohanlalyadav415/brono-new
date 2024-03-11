<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Businessline extends Model
{ 
    use HasFactory, SoftDeletes;
     protected $table = 'tbl_business_line';
      protected $primaryKey = 'business_line_id';
      protected $dates = ['deleted_at'];
      
      protected $guarded  = [];
}
