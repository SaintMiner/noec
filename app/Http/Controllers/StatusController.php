<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
class StatusController extends Controller
{
    public function index() {
        return Status::all();
    }

    public function store(Request $request) {
        $this->validate($request, [
            "name" => "required|min:1|max:60",
            "color" => "nullable|in:Red,Yellow,Green"
        ]);
        Status::create($request->all());
    }

    public function update(Request $request, $statusID) {
        $this->validate($request, [
            "name" => "required|min:1|max:60",
            "color" => "nullable|in:Red,Yellow,Green"
        ]);
        $status = Status::find($statusID);
        $status->update($request->all());
    }

    public function destroy($statusID) {
        Status::find($statusID)->delete();
    }
}
