<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $symptoms = auth()->user()->symptoms()->latest()->get();
        return $this->success($symptoms, "Liste des symptômes récupérée");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'severity' => 'required|in:mild,moderate,severe',
            'description' => 'nullable|string',
            'date_recorded' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $symptom = auth()->user()->symptoms()->create($validated);

        return $this->success($symptom, "Symptôme enregistré avec succès", 201);
    }

    public function show($id)
    {
        $symptom = auth()->user()->symptoms()->findOrFail($id);
        return $this->success($symptom, "Détail du symptôme");
    }

    public function destroy($id)
    {
        $symptom = auth()->user()->symptoms()->findOrFail($id);
        $symptom->delete();
        return $this->success([], "Symptôme supprimé");
    }
}