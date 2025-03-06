@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Détails de la voiture</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>{{ $voiture->marque }} {{ $voiture->modele }}</h4>
                    <p><strong>Matricule:</strong> {{ $voiture->matricule }}</p>
                    <p><strong>Carburant:</strong> {{ ucfirst($voiture->carburant) }}</p>
                    <p><strong>Prix par jour:</strong> {{ $voiture->prix }} DH</p>
                    <p>
                        <strong>Status:</strong>
                        @if($voiture->status == 'Disponible')
                            <span class="badge bg-success">Disponible</span>
                        @else
                            <span class="badge bg-danger">Indisponible</span>
                        @endif
                    </p>
                    <p><strong>Créée le:</strong> {{ $voiture->created_at->format('d/m/Y') }}</p>
                    <p><strong>Dernière mise à jour:</strong> {{ $voiture->updated_at->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-6 text-center">
                    @if($voiture->photo)
                        <img src="{{ asset('storage/' . $voiture->photo) }}" alt="{{ $voiture->modele }}" class="img-fluid rounded">
                    @else
                        <div class="bg-light p-5 d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                            <i class="fas fa-car fa-4x text-secondary"></i>
                        </div>
                    @endif
                </div>
            </div>

            <h4 class="mt-4">Historique des locations</h4>
            @if($voiture->locations->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date de début</th>
                            <th>Nombre de jours</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($voiture->locations as $location)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($location->datedebut)->format('d/m/Y') }}</td>
                                <td>{{ $location->nombrejours }}</td>
                                <td>{{ $location->voiture->prix * $location->nombrejours }} DH</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">Aucune location pour cette voiture.</div>
            @endif

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('voitures.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
                <div>
                    <a href="{{ route('voitures.edit', $voiture) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('voitures.destroy', $voiture) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette voiture?')">
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