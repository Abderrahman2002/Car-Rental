<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('voiture')->paginate(10);
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        $voitures = Voiture::all();
        return view('locations.create', compact('voitures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'voiture_id' => 'required|exists:voitures,id',
            'datedebut' => 'required|date|after_or_equal:today',
            'nombrejours' => 'required|integer|min:1'
        ]);

        $voiture = Voiture::findOrFail($request->voiture_id);
        $dateDebut = Carbon::parse($request->datedebut);
        $dateFin = $dateDebut->copy()->addDays($request->nombrejours);

        if (!$voiture->estDisponible($dateDebut, $dateFin)) {
            return back()->withErrors([
                'datedebut' => 'La voiture n\'est pas disponible pour ces dates.'
            ])->withInput();
        }

        Location::create($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Réservation créée avec succès.');
    }

    public function edit(Location $location)
    {
        $voitures = Voiture::all();
        return view('locations.edit', compact('location', 'voitures'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'voiture_id' => 'required|exists:voitures,id',
            'datedebut' => 'required|date',
            'nombrejours' => 'required|integer|min:1'
        ]);

        $dateDebut = Carbon::parse($request->datedebut);
        $dateFin = $dateDebut->copy()->addDays($request->nombrejours);

        if (
            $location->voiture_id != $request->voiture_id || 
            $location->datedebut != $request->datedebut || 
            $location->nombrejours != $request->nombrejours
        ) {
            $voiture = Voiture::findOrFail($request->voiture_id);
            if (!$voiture->estDisponible($dateDebut, $dateFin, $location->id)) {
                return back()->withErrors([
                    'datedebut' => 'La voiture n\'est pas disponible pour ces dates.'
                ])->withInput();
            }
        }

        $location->update($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Réservation mise à jour avec succès.');
    }

    // app/Http/Controllers/LocationController.php

public function show($id)
{
    // Fetch the location by ID
    $location = Location::findOrFail($id);

    // Return the view with location details
    return view('locations.show', compact('location'));
}

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index')
            ->with('success', 'Réservation supprimée avec succès.');
    }
}
