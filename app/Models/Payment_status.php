<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_status extends Model
{
    use HasFactory; 
    protected $table = 'tbl_payment_status';
	protected $primaryKey = 'payment_status_id'; 
	protected $guarded  = [];
}
