<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class VoitureController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $voitures = Voiture::when($search, function ($query) use ($search) {
            return $query->where('matricule', 'like', "%{$search}%")
                         ->orWhere('modele', 'like', "%{$search}%");
        })->paginate(10);

        $totalVoitures = Voiture::count();
        $totalReservations = Location::sum('nombrejours');

        return view('voitures.index', compact('voitures', 'totalVoitures', 'totalReservations'));
    }

    public function create()
    {
        return view('voitures.create');
    }
    public function edit(Voiture $voiture)
    {
        return view('voitures.edit', compact('voiture'));
    }
    
    public function show(Voiture $voiture)
    {
        return view('voitures.show', compact(var_name: 'voiture'));
    }
    
    public function destroy(Voiture $voiture)
{
    // Delete the car's photo if it exists
    if ($voiture->photo) {
        Storage::delete('public/' . $voiture->photo);
    }

    // Delete the voiture
    $voiture->delete();

    return redirect()->route('voitures.index')
        ->with('success', 'Voiture supprimée avec succès.');
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:50|unique:voitures',
            'modele' => 'required|string|max:100',
            'carburant' => 'required|in:essence,diesel,électrique,hybride',
            'prix' => 'required|numeric|min:0',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('voitures', 'public');
        }

        Voiture::create($validated);

        return redirect()->route('voitures.index')
            ->with('success', 'Voiture ajoutée avec succès.');
    }

    public function update(Request $request, Voiture $voiture)
    {
        $validated = $request->validate([
            'matricule' => ['required', 'string', 'max:50', Rule::unique('voitures')->ignore($voiture->id)],
            'modele' => 'required|string|max:100',
            'carburant' => 'required|in:essence,diesel,électrique,hybride',
            'prix' => 'required|numeric|min:0',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            if ($voiture->photo) {
                Storage::delete('public/' . $voiture->photo);
            }
            $validated['photo'] = $request->file('photo')->store('voitures', 'public');
        }

        $voiture->update($validated);

        return redirect()->route('voitures.index')
            ->with('success', 'Voiture mise à jour avec succès.');
    }
}

