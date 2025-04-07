<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = ['customer_name', 'customer_phone', 'session_type', 'start_time', 'end_time', 'status'];

}