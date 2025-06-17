<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    //aa

public function store(Request $request)
{
    $data = $request->validate([
        'vehicle_id' => 'required|exists:vehicles,id',
        'status' => 'required|string',
        'notes' => 'nullable|string',
        'audited_at' => 'required|date',
        'photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
    ]);

    $data['user_id'] = $request->user()->id;

    $audit = Audit::create([
        'vehicle_id' => $data['vehicle_id'],
        'status' => $data['status'],
        'notes' => $data['notes'] ?? null,
        'audited_at' => $data['audited_at'],
        'user_id' => $data['user_id'],
    ]);

    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('audit_photos', 'public');
            $audit->photos()->create([
                'photo_path' => $path,
            ]);
        }
    }

    return response()->json($audit->load('photos'), 201);
}

public function history(Request $request)
{

      return Audit::with(['vehicle', 'user', 'photos'])
        ->where('user_id', $request->user()->id)
        ->orderBy('audited_at', 'desc')
        ->get();
}
}
