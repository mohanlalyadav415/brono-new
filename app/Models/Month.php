<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{ 
    use HasFactory;
     protected $table = 'tbl_month';
     protected $primaryKey = 'month_id';
      protected $guarded  = [];
}
