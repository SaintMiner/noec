<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Positions as PositionResource;
use App\Http\Resources\PositionEnterprise as PositionEnterpriseResource;


use App\Position;
use App\Enterprise;

class PositionController extends Controller
{
    public function index() {
        return PositionResource::collection(Position::all());
    }

    public function store(Request $request) {
        $this->validate($request, [
            "name" => "required|min:3|max:255",
        ]);
        $position = Position::create($request->all());
        $position->enterprises()->sync($request->enterprises);
        return response("created", 201);
    }

    public function update(Request $request, $positionID) {
        $this->validate($request, [
            "name" => "required|min:3|max:255",
        ]);
        $position = Position::find($positionID);
        $position->update($request->all());
        $position->enterprises()->sync($request->enterprises);
    }

    public function destroy($positionID) {
        Position::find($positionID)->delete();
    }

    public function getEnterprises($positionID) {
        $position = Position::find($positionID);
        $enterprises = Enterprise::all();
        foreach($position->enterprises()->get() as $conEnterprise) {
            foreach($enterprises as $enterprise) {
                if ($conEnterprise->id == $enterprise->id) {
                    $enterprise->checked = true;
                }
            }
        }
        return PositionEnterpriseResource::collection($enterprises);
    }
}
