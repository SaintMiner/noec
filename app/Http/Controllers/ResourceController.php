<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\Http\Responses\Feed;
use App\Http\Resources\Resources as ResourceResource;
class ResourceController extends Controller
{
    public function index() {
        // dd(Resource::find(1)->department());
        return new Feed;
        $resources = Resource::with('department')->get();
        // dd($resources);
        // foreach ($resources as $resource) {
        //     $resource->department = $resource->department()->get();
        //     $resource->enterprise = $resource->enterprise()->get();
        //     $resource->status = $resourece->status()->get();
        //     $resource->position = $resource->position()->get();
        // }
        return ResourceResource::collection($resources);
    }
}
