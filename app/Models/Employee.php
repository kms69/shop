<?php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'employee';
    protected $fillable = [
        'name', 'email', 'password', 'address', 'role', 'permission', 'entity',
    ];
    protected $hidden = [
        'password',
    ];


}
