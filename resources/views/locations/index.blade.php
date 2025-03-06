@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Gestion des Réservations</h2>
        <a href="{{ route('locations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Ajouter une réservation
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <span class="me-2">Show</span>
                        <select class="form-select form-select-sm" style="width: 70px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="ms-2">entries</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('locations.index') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-light">Search:</span>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Voiture</th>
                        <th>Date de début</th>
                        <th>Nombre de jours</th>
                        <th>Montant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $location)
                        <tr>
                            <td>{{ $location->id }}</td>
                            <td>{{ $location->voiture->modele }} ({{ $location->voiture->matricule }})</td>
                            <td>{{ \Carbon\Carbon::parse($location->datedebut)->format('d/m/Y') }}</td>
                            <td>{{ $location->nombrejours }}</td>
                            <td>{{ $location->voiture->prix * $location->nombrejours }} DH</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('locations.show', $location) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('locations.edit', $location) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('locations.destroy', $location) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucune réservation trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $voitures->firstItem() ?? 0 }} to {{ $voitures->lastItem() ?? 0 }} of {{ $voitures->total() }} entries
                </div>
                <div>
                    {{ $voitures->links() }}
                </div>
            </div>
        </div>
              
    </div>
@endsection
