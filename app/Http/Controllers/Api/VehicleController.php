<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VehicleResource;
class VehicleController extends Controller
{


    public function index()
    {
        return VehicleResource::collection(Vehicle::all());
    }

    public function show($id)
    {
        return Vehicle::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate_number' => 'required|string|unique:vehicles',
            'model' => 'required|string',
            'brand' => 'required|string',
            'year' => 'required|digits:4|integer|min:1900|max:' . now()->year,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $vehicle = Vehicle::create([
            'plate_number' => $request->plate_number,
            'model' => $request->model,
            'brand' => $request->brand,
            'year' => $request->year,
            'user_id' => Auth::id(), // التأكد من كتابة Auth:: وليس Auth()
        ]);

        return new VehicleResource($vehicle);
    }
}