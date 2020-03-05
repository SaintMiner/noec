<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Storage;

class StorageController extends Controller
{
    public function index() {
        return Storage::all();
    }
}
