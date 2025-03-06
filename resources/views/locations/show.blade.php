    @extends('layouts.app')

    @section('content')
        <div class="card">
            <div class="card-header">
                <h3>Détails de la réservation</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Réservation #{{ $location->id }}</h4>
                        <p><strong>Date de début:</strong> {{ \Carbon\Carbon::parse($location->datedebut)->format('d/m/Y') }}</p>
                        <p><strong>Nombre de jours:</strong> {{ $location->nombrejours }}</p>
                        <p><strong>Date de fin:</strong> {{ \Carbon\Carbon::parse($location->datedebut)->addDays($location->nombrejours)->format('d/m/Y') }}</p>
                        <p><strong>Montant total:</strong> {{ $location->voiture->prix * $location->nombrejours }} DH</p>
                        <p><strong>Créée le:</strong> {{ $location->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h4>Détails de la voiture</h4>
                        <p><strong>Modèle:</strong> {{ $location->voiture->modele }}</p>
                        <p><strong>Matricule:</strong> {{ $location->voiture->matricule }}</p>
                        <p><strong>Carburant:</strong> {{ ucfirst($location->voiture->carburant) }}</p>
                        <p><strong>Prix par jour:</strong> {{ $location->voiture->prix }} DH</p>
                        
                        @if($location->voiture->photo)
                            <img src="{{ asset('storage/' . $location->voiture->photo) }}" alt="{{ $location->voiture->modele }}" class="img-thumbnail" style="max-height: 150px;">
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('locations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <div>
                        <a href="{{ route('locations.edit', $location) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection