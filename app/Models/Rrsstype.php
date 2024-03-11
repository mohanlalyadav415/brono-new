<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rrsstype extends Model
{ 
    use HasFactory;
     protected $table = 'tbl_rrss_type';
     protected $primaryKey = 'rrss_type_id';
      protected $guarded  = [];
}
