<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Resources\PermissionResource;
use App\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return PermissionResource::collection(Permission::all());
    }
}
