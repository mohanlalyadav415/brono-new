<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usersaccess extends Model
{ 
    use HasFactory;
     protected $table = 'tbl_users_access';
     protected $primaryKey = 'user_access_id';
      protected $guarded  = [];
}
