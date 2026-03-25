<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    use ApiResponse;

    public function getAdvice($symptomId)
    {
        $symptom = auth()->user()->symptoms()->findOrFail($symptomId);
        $apiKey = env('GEMINI_API_KEY');

        $prompt = "En tant qu'assistant médical IA, analyse ce symptôme : {$symptom->name} (Sévérité: {$symptom->severity}). 
                   Description: {$symptom->description}. 
                   Donne des conseils courts et précise s'il faut voir un médecin. 
                   Réponds en français et reste professionnel.";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ]);

        if ($response->successful()) {
            $advice = $response->json()['candidates'][0]['content']['parts'][0]['text'];
            return $this->success(['advice' => $advice], "Conseil généré par l'IA");
        }

        return $this->error("Erreur avec l'IA Gemini", $response->json(), 500);
    }
}