<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loginlog extends Model
{ 
    use HasFactory;
     protected $table = 'tbl_login';
      protected $primaryKey = 'login_id';
      protected $guarded  = [];
}
