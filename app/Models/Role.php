<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    // Specify the table name if it's not plural
    protected $table = 'role';
    protected $primary_key ='id';
    // Add fields that can be mass-assigned
    protected $fillable = ['name']; // Example fields
    public $timestamps = false;

}
