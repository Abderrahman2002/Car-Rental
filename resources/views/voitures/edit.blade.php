@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Modifier la voiture</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('voitures.update', $voiture) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="matricule" class="form-label">Matricule</label>
                    <input type="text" class="form-control @error('matricule') is-invalid @enderror" id="matricule" name="matricule" value="{{ old('matricule', $voiture->matricule) }}" required>
                    @error('matricule')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="modele" class="form-label">Modèle</label>
                    <input type="text" class="form-control @error('modele') is-invalid @enderror" id="modele" name="modele" value="{{ old('modele', $voiture->modele) }}" required>
                    @error('modele')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="carburant" class="form-label">Carburant</label>
                    <select class="form-select @error('carburant') is-invalid @enderror" id="carburant" name="carburant" required>
                        <option value="essence" {{ old('carburant', $voiture->carburant) == 'essence' ? 'selected' : '' }}>Essence</option>
                        <option value="diesel" {{ old('carburant', $voiture->carburant) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="électrique" {{ old('carburant', $voiture->carburant) == 'électrique' ? 'selected' : '' }}>Électrique</option>
                        <option value="hybride" {{ old('carburant', $voiture->carburant) == 'hybride' ? 'selected' : '' }}>Hybride</option>
                    </select>
                    @error('carburant')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prix" class="form-label">Prix de location par jour (DH)</label>
                    <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', $voiture->prix) }}" required min="0">
                    @error('prix')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    @if($voiture->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $voiture->photo) }}" alt="{{ $voiture->modele }}" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('voitures.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection