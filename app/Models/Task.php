<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use softDeletes;

    protected  $table = 'task';
    protected $fillable = ['name', 'body'];
    public $timestamps = false;
}
