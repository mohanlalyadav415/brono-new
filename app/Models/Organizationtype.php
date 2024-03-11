<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Organizationtype extends Model
{
    use HasFactory;
	protected $table = 'tbl_organization_type';
	protected $primaryKey = 'organization_type_id'; 
	protected $guarded  = [];
}
