@extends('layouts.app')

@section('content')
    <!-- Dashboard Stats -->
    <div class="card bg-light mb-4 shadow-sm rounded-lg">
        <div class="card-body">
            <div class="row text-center">
                <!-- Voiture Count -->
                <div class="col-md-6 mb-4">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-car fa-3x text-primary mb-2"></i>
                        <h5 class="font-weight-bold">Nombre de Voitures</h5>
                        <h3 class="text-primary">{{ $totalVoitures }}</h3>
                    </div>
                </div>
                <!-- Reservation Amount -->
                <div class="col-md-6 mb-4">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-money-bill-wave fa-3x text-success mb-2"></i>
                        <h5 class="font-weight-bold">Montant Total des Réservations</h5>
                        <h3 class="text-success">{{ $totalReservations }} DH</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cars Management Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-semibold text-2xl">Gestion des Voitures</h2>
        <a href="{{ route('voitures.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Ajouter une voiture
        </a>
    </div>

    <!-- Cars Table -->
    <div class="card shadow-sm rounded-lg">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <!-- Pagination Control -->
            <div class="d-flex align-items-center">
                <span class="me-2">Show</span>
                <select class="form-select form-select-sm" style="width: 70px;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="ms-2">entries</span>
            </div>
            <!-- Search Form -->
            <form action="{{ route('voitures.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                </div>
            </form>
        </div>

        <!-- Table Body -->
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0 text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>Année</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($voitures as $voiture)
                        <tr>
                            <td>{{ $voiture->marque }}</td>
                            <td>{{ $voiture->modele }}</td>
                            <td>{{ random_int(2018, 2023) }}</td>
                            <td>
                                @if($voiture->status == 'Disponible')
                                    <span class="badge bg-success text-white">Disponible</span>
                                @else
                                    <span class="badge bg-danger text-white">Indisponible</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('voitures.show', $voiture) }}" class="btn btn-sm btn-primary" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('voitures.edit', $voiture) }}" class="btn btn-sm btn-info" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('voitures.destroy', $voiture) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette voiture?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500">Aucune voiture trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $voitures->firstItem() ?? 0 }} to {{ $voitures->lastItem() ?? 0 }} of {{ $voitures->total() }} entries
                </div>
                <div>
                    {{-- Custom pagination styling with Bootstrap --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $voitures->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection
