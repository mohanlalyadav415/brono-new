<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementType extends Model
{ 
    use HasFactory;
     protected $table = 'tbl_movement_type';
     protected $primaryKey = 'movement_type_id';
      protected $guarded  = [];
}
