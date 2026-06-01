@extends('layouts.admin')

@section('content')
<style>
    :root {
        --primary-color: #c41e3a;
        --primary-dark: #8b0000;
        --background-color: #f5e6d3;
        --text-color: #2c1810;
        --hover-color: #d64d4d;
        --gold: #d4a574;
        --light-bg: #faf6f1;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: var(--background-color);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .upload-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2rem;
    }

    .page-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .page-title {
        color: var(--primary-color);
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: 1px;
    }

    .page-subtitle {
        color: var(--text-color);
        font-size: 1rem;
        opacity: 0.7;
    }

    /* Upload Form Card */
    .upload-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.8rem;
    }

    .form-label {
        display: block;
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 0.8rem;
        font-size: 1rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 0.9rem 1.2rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(196, 30, 58, 0.1);
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23c41e3a' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
        appearance: none;
        cursor: pointer;
    }

    /* File Upload Area */
    .file-upload-area {
        border: 2px dashed var(--primary-color);
        border-radius: 10px;
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: rgba(196, 30, 58, 0.03);
    }

    .file-upload-area:hover {
        background-color: rgba(196, 30, 58, 0.08);
        border-color: var(--primary-dark);
    }

    .file-upload-area.dragover {
        background-color: rgba(196, 30, 58, 0.15);
        border-color: var(--primary-dark);
    }

    .file-upload-icon {
        font-size: 3.5rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .file-upload-text {
        color: var(--text-color);
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .file-upload-subtext {
        color: #999;
        font-size: 0.95rem;
    }

    .file-input-hidden {
        display: none;
    }

    /* Preview */
    .image-preview-area {
        margin-top: 2rem;
    }

    .image-preview-label {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1rem;
        display: block;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .image-preview {
        max-width: 100%;
        max-height: 300px;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        display: none;
    }

    .image-preview.show {
        display: block;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.8rem;
    }

    .form-grid-full {
        grid-column: 1 / -1;
    }

    /* Buttons */
    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
    }

    .btn {
        padding: 0.9rem 2rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        flex: 1;
    }

    .btn-submit {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-submit:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(196, 30, 58, 0.3);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-reset {
        background-color: #e0e0e0;
        color: var(--text-color);
    }

    .btn-reset:hover {
        background-color: #d0d0d0;
    }

    /* Alerts */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        font-weight: 500;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-close {
        float: right;
        font-size: 1.2rem;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* Gallery Preview */
    .gallery-section {
        margin-top: 3rem;
    }

    .section-title {
        color: var(--primary-color);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .photos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1.5rem;
    }

    .photo-item {
        position: relative;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        aspect-ratio: 1;
    }

    .photo-item:hover {
        transform: translateY(-5px);
    }

    .photo-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-item-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .photo-item:hover .photo-item-overlay {
        opacity: 1;
    }

    .delete-btn {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 700;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .delete-btn:hover {
        background-color: var(--primary-dark);
    }

    .empty-gallery {
        text-align: center;
        padding: 2rem;
        color: #999;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .upload-container {
            padding: 1.5rem;
        }

        .upload-card {
            padding: 1.5rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 2rem;
        }

        .button-group {
            flex-direction: column;
        }

        .photos-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }

    @media (max-width: 480px) {
        .upload-container {
            padding: 1rem;
        }

        .upload-card {
            padding: 1.2rem;
        }

        .file-upload-area {
            padding: 2rem 1rem;
        }

        .file-upload-icon {
            font-size: 2.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .photos-grid {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 1rem;
        }
    }
</style>

<div class="upload-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">📸 Upload de Fotos</h1>
        <p class="page-subtitle">Adicione novas fotos à galeria do Projeto PNP</p>
    </div>

    <!-- Messages -->
    @if($errors->any())
        <div class="alert alert-error">
            <span class="alert-close" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Erro ao fazer upload:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-close" onclick="this.parentElement.style.display='none';">&times;</span>
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- Upload Form -->
    <div class="upload-card">
        <form method="POST" action="{{ route('fotos.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- File Upload -->
            <div class="form-group">
                <label class="form-label">📁 Selecione a Foto</label>
                <div class="file-upload-area" id="uploadArea">
                    <div class="file-upload-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </div>
                    <div class="file-upload-text">Arraste a foto aqui ou clique para selecionar</div>
                    <div class="file-upload-subtext">Formatos: JPG, PNG, GIF | Máximo: 2MB</div>
                    <input type="file" name="foto" id="fotoInput" class="file-input-hidden" accept="image/*" required>
                </div>

                <!-- Image Preview -->
                <div class="image-preview-area">
                    <label class="image-preview-label">Pré-visualização:</label>
                    <img id="imagePreview" class="image-preview" alt="Preview da foto">
                </div>
            </div>

            <!-- Form Grid -->
            <div class="form-grid">
                <!-- Category -->
                <div class="form-group">
                    <label class="form-label">🏷️ Categoria</label>
                    <select name="categoria" class="form-select" required>
                        <option value="">Selecione uma categoria</option>
                        {{-- <option value="geral" {{ old('categoria') === 'geral' ? 'selected' : '' }}>Geral</option> --}}
                        <option value="apresentacoes" {{ old('categoria') === 'apresentacoes' ? 'selected' : '' }}>Apresentações</option>
                        <option value="danca" {{ old('categoria') === 'danca' ? 'selected' : '' }}>Dança</option>
                        <option value="musica" {{ old('categoria') === 'musica' ? 'selected' : '' }}>Música</option>
                        <option value="poesia" {{ old('categoria') === 'poesia' ? 'selected' : '' }}>Poesia</option>
                        <option value="artes-visuais" {{ old('categoria') === 'artes-visuais' ? 'selected' : '' }}>Artes Visuais</option>
                        <option value="bastidores" {{ old('categoria') === 'bastidores' ? 'selected' : '' }}>Bastidores</option>
                        <option value="publico" {{ old('categoria') === 'publico' ? 'selected' : '' }}>Público</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label class="form-label">✏️ Descrição</label>
                    <input 
                        type="text" 
                        name="descricao" 
                        class="form-control" 
                        placeholder="Ex: Apresentação de dança - Noite de gala"
                        value="{{ old('descricao') }}"
                    >
                </div>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-upload"></i> Fazer Upload
                </button>
                <button type="reset" class="btn btn-reset">
                    <i class="bi bi-arrow-counterclockwise"></i> Limpar
                </button>
            </div>
        </form>
    </div>

    <!-- Gallery Preview -->
    @if($fotos->count() > 0)
        <div class="gallery-section">
            <h2 class="section-title">🖼️ Fotos Carregadas ({{ $fotos->count() }})</h2>
            <div class="photos-grid">
                @foreach($fotos as $foto)
                    <div class="photo-item">
                        <img src="{{ asset('uploads/fotos/' . $foto->filename) }}" alt="{{ $foto->description }}">
                        <div class="photo-item-overlay">
                            <form method="POST" action="{{ route('fotos.destroy', $foto->id) }}" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" onclick="return confirm('Tem certeza que deseja deletar esta foto?')">
                                    <i class="bi bi-trash"></i> Deletar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="empty-gallery">
            <p>Nenhuma foto carregada ainda. Comece adicionando uma foto!</p>
        </div>
    @endif
</div>

<script>
    const uploadArea = document.getElementById('uploadArea');
    const fotoInput = document.getElementById('fotoInput');
    const imagePreview = document.getElementById('imagePreview');

    // Click to upload
    uploadArea.addEventListener('click', () => fotoInput.click());

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fotoInput.files = files;
            previewImage(files[0]);
        }
    });

    // File input change
    fotoInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            previewImage(e.target.files[0]);
        }
    });

    function previewImage(file) {
        const reader = new FileReader();
        
        reader.onload = (e) => {
            imagePreview.src = e.target.result;
            imagePreview.classList.add('show');
        };
        
        reader.readAsDataURL(file);
    }
</script>

@endsection
