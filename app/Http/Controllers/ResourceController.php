<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\Http\Resources\Resources as ResourceResource;

class ResourceController extends Controller

{
    public function index(Request $request) {
        $condition = [];
        
        if ($request->enterpriseFilter) {
            array_push($condition, ["enterprise_id", '=', $request->enterpriseFilter]);
        }
        if ($request->departmentFilter) {
            array_push($condition, ["department_id", '=', $request->departmentFilter]);
        }
        if ($request->statusFilter) {
            array_push($condition, ["status_id", '=', $request->statusFilter]);
        }
        if ($request->searchFilter) {
            array_push($condition, [\DB::raw('CONCAT(resources.name, " ", resources.surname)'), "like", "%".$request->searchFilter."%"]);
        }
        $resources = ResourceResource::collection(Resource::with("department", "enterprise", "status", "position")->where($condition)->get());
        return $resources;
    }

    public function store(Request $request) {
        $this->validate($request, [
            "name" => "required|min:1|max:50|regex:/^[a-zA-Z]+$/u",
            "surname" => "required|min:1|max:50|regex:/^[a-zA-Z]+$/u",
            "enterprise_id" => "nullable|numeric",
            "status_id" => "nullable|numeric",
            "position_id" => "nullable|numeric",
            "department_id" => "nullable|numeric",
        ]);
        Resource::create($request->all());
        return response("created", 201);
    }

    public function update(Request $request, $resourceID) {
        $this->validate($request, [
            "name" => "required|min:1|max:50|regex:/^[a-zA-Z]+$/u",
            "surname" => "required|min:1|max:50|regex:/^[a-zA-Z]+$/u",
            "enterprise_id" => "nullable|numeric",
            "status_id" => "nullable|numeric",
            "position_id" => "nullable|numeric",
            "department_id" => "nullable|numeric",
        ]);
        $resource = Resource::find($resourceID);
        $resource->update($request->all());
        return response("updated", 201);
    }

    public function show($resourceID) {
        return Resource::find($resourceID);
    }

    public function destroy($resourceID) {
        $resource = Resource::findOrFail($resourceID);
        $resource->delete();
    }
}
