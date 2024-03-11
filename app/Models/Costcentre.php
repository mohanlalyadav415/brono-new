<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Costcentre extends Model
{ 
    use HasFactory, SoftDeletes;
     protected $table = 'tbl_cost_centre';
      protected $primaryKey = 'cost_centre_id';
      protected $dates = ['deleted_at'];

      protected $guarded  = [];
}
