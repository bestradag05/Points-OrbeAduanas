<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Permissions extends Model
{
    use HasFactory, HasRoles, HasPermissions;

    protected $table = 'permissions';

    protected $fillable = ['name', 'guard_name'];
}
