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
        'photo' => 'nullable|image',
    ]);

    if ($request->hasFile('photo')) {
        $data['photo_path'] = $request->file('photo')->store('audit_photos', 'public');
    }

    $data['user_id'] = $request->user()->id;

    $audit = Audit::create($data);

    return response()->json($audit, 201);
}

public function history(Request $request)
{
    return Audit::with(['vehicle', 'user'])
        ->where('user_id', $request->user()->id)
        ->orderBy('audited_at', 'desc')
        ->get();
}
}
