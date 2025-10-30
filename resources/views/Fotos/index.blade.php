@extends('layouts.admin')

@section('content')
<main>
    {{-- CSS direto --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary-color: #c41e3a;
            --primary-dark: #8b0000;
            --background-color: #f5e6d3;
            --text-color: #2c1810;
            --hover-color: #d64d4d;
        }

        body {
            background-color: var(--background-color);
            font-family: Arial, sans-serif;
        }

        .page-title {
            text-align: center;
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: white;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-color);
        }

        .btn-danger {
            background-color: var(--primary-color);
            border-color: var(--primary-dark);
        }

        .btn-danger:hover {
            background-color: var(--hover-color);
        }

        .btn-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-dark);
            color: #fff;
        }

        .btn-custom:hover {
            background-color: var(--hover-color);
            color: #fff;
        }
    </style>

    <div class="container" style="max-width: 1000px; margin-top: 2rem;">
        <h1 class="page-title">Gerenciar Fotos</h1>

        {{-- Mensagens de sucesso/erro --}}
        <x-alert />

        {{-- Formulário de upload --}}
        <div class="card p-4 mb-4">
            <form action="{{ route('fotos.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf
                <div class="col-md-9">
                    <label for="foto" class="form-label">Selecione uma foto</label>
                    <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" required>
                    @error('foto')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-custom w-100">
                        <i class="bx bx-upload"></i> Salvar Foto
                    </button>
                </div>
            </form>
        </div>

        {{-- Listagem de fotos --}}
        <div class="row mt-4">
            @forelse($fotos as $foto)
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('uploads/fotos/' . $foto->filename) }}" 
                             class="card-img-top" 
                             alt="Foto" 
                             style="height: 200px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;">

                        <div class="card-body text-center">
                            <form action="{{ route('fotos.destroy', $foto->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta foto?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger w-100">
                                    <i class="bx bx-trash"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center">Nenhuma foto cadastrada ainda.</p>
            @endforelse
        </div>
    </div>
</main>
@endsection
