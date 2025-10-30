@extends('layouts.public')
@section('content')
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
</style>
<div class="container">
        <h1 class="page-title">Gerenciar Fotos</h1>
    
        <div class="row mt-4">
            @forelse($fotos as $foto)
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        {{-- ATENÇÃO: Substitua 'caminho_correto' pela coluna do seu modelo que contém o nome do arquivo --}}
                        <img src="{{ asset('uploads/fotos/' . $foto->filename) }}" 
                             class="card-img-top" 
                             alt="Foto" 
                             style="height: 200px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;">

                        <div class="card-body text-center">
                            <h6 class="card-title text-muted mb-3">{{ $foto->id ?? 'Foto sem nome' }}</h6>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Caso a coleção $fotos esteja vazia --}}
                <div class="col-12 text-center">
                    <p class="text-muted">Nenhuma foto cadastrada ainda.</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection