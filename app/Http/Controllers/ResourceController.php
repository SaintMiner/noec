<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\Http\Resources\Resources as ResourceResource;
class ResourceController extends Controller
{
    public function index(Request $request) {
        // dd(Resource::find(1)->department());
        $condition = [];
        
        if ($request->enterpriseFilter) {
            array_push($condition, ["enterprise_id", '=', $request->enterpriseFilter]);
        }
        if ($request->departmentFilter) {
            array_push($condition, ["department_id", '=', $request->departmentFilter]);
        }
        return ResourceResource::collection(Resource::with("department", "enterprise", "status", "position")
                                            ->where($condition)
                                            ->orWhere('name', 'like', '%' . $request->searchFilter . '%')
                                            ->orWhere('surname', 'like', '%' . $request->searchFilter . '%')
                                            ->get()
                );
        return $request;

    }
}
