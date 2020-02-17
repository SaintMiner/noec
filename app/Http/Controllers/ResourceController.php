<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\Http\Resources\Resources as ResourceResource;
class ResourceController extends Controller
{
    public function index() {
        dd(Resource::find(1)->department());
        return ResourceResource::collection(Resource::all());
    }
}
