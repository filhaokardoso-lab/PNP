@extends('layouts.admin')

@section('content')
    <main>
        {{-- Boxicons para ícones --}}
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <style>
            :root {
                --primary-color: #c41e3a;
                --hover-color: #d64d4d;
                --background-color: #f5e6d3;
                --text-color: #2c1810;
            }

            body {
                background-color: var(--background-color);
            }

            .page-title {
                text-align: center;
                color: var(--primary-color);
                font-size: 2.3rem;
                margin-bottom: 0.5rem;
            }

            .description {
                text-align: center;
                color: var(--text-color);
                font-size: 1.1rem;
                margin-bottom: 2.5rem;
                opacity: 0.8;
            }

            .card-custom {
                border-radius: 15px;
                border: none;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                background: #fff;
                padding: 2rem;
            }

            .form-control {
                border-radius: 8px;
            }

            .btn-submit {
                background-color: var(--primary-color);
                border: none;
                padding: 0.6rem 1.5rem;
                color: white;
                border-radius: 8px;
                font-size: 1rem;
                font-weight: bold;
                transition: background-color 0.3s;
            }

            .btn-submit:hover {
                background-color: var(--hover-color);
            }

            /* Galeria */
            .gallery {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 1rem;
                margin-top: 2rem;
            }

            .gallery-item {
                position: relative;
                overflow: hidden;
                border-radius: 10px;
                box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            }

            .gallery-item img {
                width: 100%;
                height: 180px;
                object-fit: cover;
                transition: transform 0.3s ease;
            }

            .gallery-item:hover img {
                transform: scale(1.05);
            }

            .delete-btn {
                position: absolute;
                top: 8px;
                right: 8px;
                background: rgba(196, 30, 58, 0.9);
                border: none;
                color: white;
                padding: 6px 10px;
                border-radius: 6px;
                cursor: pointer;
                transition: background 0.3s;
            }

            .delete-btn:hover {
                background: rgba(214, 77, 77, 1);
            }

            .preview-img {
                display: block;
                margin: 1rem auto;
                max-width: 250px;
                max-height: 250px;
                border-radius: 10px;
                border: 2px solid var(--primary-color);
                object-fit: cover;
            }
        </style>

        {{-- Conteúdo --}}
        <h1 class="page-title">Gerenciar Fotos</h1>
        <p class="description">Adicione e organize as fotos cadastradas no sistema</p>

        <div class="container" style="max-width: 900px;">
            <div class="card-custom">

                {{-- Upload --}}
                <form action="{{ route('fotos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="photo" class="form-label">Selecione uma foto</label>
                    <input type="file" name="photo" id="photo"
                        class="form-control @error('photo') is-invalid @enderror" onchange="previewImage(event)">
                    @error('photo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    {{-- Preview --}}
                    <img id="preview" class="preview-img d-none" alt="Pré-visualização da imagem">

                    <div class="text-center mt-3">
                        <button type="submit" class="btn-submit">
                            <i class="bx bx-upload"></i> Salvar Foto
                        </button>
                    </div>
                </form>

                {{-- Galeria --}}
                <div class="gallery">
                    @forelse($fotos as $photo)
                        <div class="gallery-item">
                            <img src="{{ asset('uploads/fotos/' . $photo->filename) }}" alt="Foto">
                            <form action="{{ route('fotos.destroy', $photo->id) }}" method="POST"
                                onsubmit="return confirm('Deseja apagar esta foto?')"
                                style="position:absolute;top:0;right:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-muted mt-3">Nenhuma foto cadastrada ainda.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <script>
            function previewImage(event) {
                const preview = document.getElementById('preview');
                preview.classList.remove('d-none');
                preview.src = URL.createObjectURL(event.target.files[0]);
            }
        </script>
    </main>
@endsection
