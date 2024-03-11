<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{ 
    use HasFactory;
     protected $table = 'tbl_comuna';
     protected $primaryKey = 'comuna_id';
      protected $guarded  = [];
}
