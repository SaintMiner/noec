<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Enterprise;

use App\Http\Resources\DepartmentEnterprise as DepartmentEnterpriseResource;
use App\Http\Resources\Departments as DepartmentResource;

class DepartmentController extends Controller
{
    public function index() {
        return DepartmentResource::collection(Department::all());
    }

    public function store(Request $request) {
        // return $request;
        $this->validate($request, [
            "name" => "required|min:3|max:255",
        ]);
        
        $department = Department::create($request->all());
        $department->enterprises()->sync($request->enterprises);
        return response("created", 201);
        return $request;
    }

    public function destroy($departmentID) {
        $department = Department::find($departmentID);
        $department->delete();
    }

    public function update(Request $request, $departmentID) {
        $this->validate($request, [
            "name" => "required|min:3|max:255",
        ]);
        $department = Department::find($departmentID);
        $department->enterprises()->sync([]);
        $department->enterprises()->sync($request->enterprises);
        $department->update($request->all());
    }

    public function getEnterprises($departmentID) {
        $department = Department::find($departmentID);
        $enterprises = Enterprise::all();
        foreach($department->enterprises()->get() as $conEnterprise) {
            foreach($enterprises as $enterprise) {
                if ($conEnterprise->id == $enterprise->id) {
                    $enterprise->checked = true;
                    $enterprise->manager = $conEnterprise->pivot->manager;
                }
            }
        }
        return DepartmentEnterpriseResource::collection($enterprises);
    }

}
