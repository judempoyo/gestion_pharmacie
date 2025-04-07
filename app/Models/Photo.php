<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
  protected $table = 'photos'; 
  protected $fillable = ['name', 'is_public', 'photo_path'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
