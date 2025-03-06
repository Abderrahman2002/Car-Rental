@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Ajouter une nouvelle réservation</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('locations.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="voiture_id" class="form-label">Voiture</label>
                    <select class="form-select @error('voiture_id') is-invalid @enderror" id="voiture_id" name="voiture_id" required>
                        <option value="">Sélectionner une voiture</option>
                        @foreach($voitures as $voiture)
                            <option value="{{ $voiture->id }}" {{ old('voiture_id') == $voiture->id ? 'selected' : '' }}>
                                {{ $voiture->modele }} ({{ $voiture->matricule }}) - {{ $voiture->prix }} DH/jour
                            </option>
                        @endforeach
                    </select>
                    @error('voiture_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="datedebut" class="form-label">Date de début</label>
                    <input type="date" class="form-control @error('datedebut') is-invalid @enderror" id="datedebut" name="datedebut" value="{{ old('datedebut', date('Y-m-d')) }}" required>
                    @error('datedebut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nombrejours" class="form-label">Nombre de jours</label>
                    <input type="number" class="form-control @error('nombrejours') is-invalid @enderror" id="nombrejours" name="nombrejours" value="{{ old('nombrejours', 1) }}" required min="1">
                    @error('nombrejours')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('locations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection