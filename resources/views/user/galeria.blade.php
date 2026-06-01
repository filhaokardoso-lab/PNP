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

    .gallery-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }

    .gallery-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .page-title {
        color: var(--primary-color);
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 1rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .gallery-subtitle {
        color: var(--text-color);
        font-size: 1.1rem;
        opacity: 0.8;
        margin-bottom: 2rem;
    }

    /* Filtros e Busca */
    .gallery-filters {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 3rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-select,
    .filter-input {
        padding: 0.75rem 1rem;
        border: 2px solid var(--gold);
        border-radius: 8px;
        font-size: 0.95rem;
        background-color: white;
        color: var(--text-color);
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .filter-select:focus,
    .filter-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(196, 30, 58, 0.1);
    }

    .filter-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-filter {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .btn-apply {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-apply:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(196, 30, 58, 0.3);
    }

    .btn-reset {
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-reset:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    /* Categorias Tags */
    .category-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }

    .category-tag {
        display: inline-block;
        padding: 0.5rem 1rem;
        background-color: var(--light-bg);
        color: var(--primary-color);
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .category-tag:hover {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .category-tag.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Galeria Grid */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .photo-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }

    .photo-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .photo-image {
        position: relative;
        overflow: hidden;
        height: 250px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    }

    .photo-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .photo-card:hover .photo-image img {
        transform: scale(1.1);
    }

    .photo-category-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background-color: var(--primary-color);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .photo-info {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .photo-description {
        color: var(--text-color);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        word-wrap: break-word;
    }

    .photo-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }

    .photo-meta {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        font-size: 0.8rem;
        color: #999;
    }

    .photo-meta-item {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .empty-icon {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 1rem;
    }

    .empty-title {
        color: var(--primary-color);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: var(--text-color);
        opacity: 0.7;
        margin-bottom: 2rem;
    }

    /* Stats */
    .gallery-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(196, 30, 58, 0.2);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.95rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gallery-container {
            padding: 2rem 1rem;
        }

        .page-title {
            font-size: 2rem;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .filter-buttons {
            flex-direction: column;
        }

        .btn-filter {
            width: 100%;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .photo-image {
            height: 200px;
        }

        .gallery-stats {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .gallery-container {
            padding: 1.5rem 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .gallery-grid {
            grid-template-columns: 1fr;
        }

        .category-tags {
            justify-content: center;
        }
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .modal-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
        background: white;
        border-radius: 15px;
        overflow: auto;
        animation: slideUp 0.3s ease;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    @keyframes slideUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-close-btn {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        font-size: 1.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .modal-close-btn:hover {
        background: var(--primary-dark);
        transform: scale(1.1);
    }

    .modal-body {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
        padding: 2rem;
    }

    .modal-image-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-image-container img {
        max-width: 100%;
        max-height: 70vh;
        object-fit: contain;
        border-radius: 10px;
    }

    .modal-info {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .modal-category {
        display: inline-block;
        background-color: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1.5rem;
        width: fit-content;
    }

    .modal-description-title {
        color: var(--primary-color);
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .modal-description {
        color: #fdfdfd;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        word-wrap: break-word;
    }

    .modal-meta {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 2px solid #eee;
    }

    .modal-meta-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: var(--primary-color);
        font-size: 0.95rem;
    }

    .modal-meta-item i {
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .modal-body {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .modal-close-btn {
            top: 1rem;
            right: 1rem;
            width: 40px;
            height: 40px;
            font-size: 1.3rem;
        }
    }

    @media (max-width: 480px) {
        .modal-content {
            max-width: 95vw;
            max-height: 95vh;
            border-radius: 10px;
        }

        .modal-body {
            padding: 1rem;
        }

        .modal-image-container img {
            max-height: 50vh;
        }

        .modal-close-btn {
            width: 35px;
            height: 35px;
            font-size: 1.2rem;
        }
    }
</style>

<div class="gallery-container">
    <!-- Header -->
    <div class="gallery-header">
        <h1 class="page-title">Galeria</h1>
        <p class="gallery-subtitle">
            Explore os registros de patrimônio do Projeto PNP
        </p>
    </div>

    <!-- Stats -->
    <div class="gallery-stats">
        <div class="stat-card">
            <div class="stat-number">{{ is_countable($fotos) ? count($fotos) : 0 }}</div>
            <div class="stat-label">Fotos Totais</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ is_countable($categories) ? count($categories) : 0 }}</div>
            <div class="stat-label">Categorias</div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="gallery-filters">
        <form method="GET" action="{{ route('user.galeria') }}">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-funnel"></i> Categoria
                    </label>
                    <select name="category" class="filter-select">
                        <option value="">Todas as Categorias</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ $category === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-search"></i> Buscar
                    </label>
                    <input 
                        type="text" 
                        name="search" 
                        class="filter-input" 
                        placeholder="Buscar na descrição..." 
                        value="{{ $search ?? '' }}"
                    >
                </div>
            </div>

            <div class="filter-buttons">
                <button type="submit" class="btn-filter btn-apply">
                    <i class="bi bi-search"></i> Filtrar
                </button>
                <a href="{{ route('user.galeria') }}" class="btn-filter btn-reset">
                    <i class="bi bi-arrow-counterclockwise"></i> Limpar
                </a>
            </div>
        </form>

        <!-- Category Quick Tags -->
        <div class="category-tags">
            <a 
                href="{{ route('user.galeria') }}" 
                class="category-tag {{ !$category ? 'active' : '' }}"
            >
                Todas
            </a>
            @foreach($categories as $key => $label)
                <a 
                    href="{{ route('user.galeria', ['category' => $key]) }}" 
                    class="category-tag {{ $category === $key ? 'active' : '' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Gallery Grid -->
    @if($fotos->count() > 0)
        <div class="gallery-grid">
            @foreach($fotos as $foto)
                <div class="photo-card" onclick="openPhotoModal('{{ asset('uploads/fotos/' . $foto->filename) }}', '{{ $foto->description ?? 'Sem descrição' }}', '{{ $categories[$foto->category] ?? $foto->category }}', '{{ $foto->created_at->format('d/m/Y') }}')">
                    <div class="photo-image">
                        <img 
                            src="{{ asset('uploads/fotos/' . $foto->filename) }}" 
                            alt="{{ $foto->description ?? 'Foto' }}"
                            loading="lazy"
                            style="cursor: pointer;"
                        >
                        <span class="photo-category-badge">
                            {{ $categories[$foto->category] ?? $foto->category }}
                        </span>
                    </div>

                    <div class="photo-info">
                        @if($foto->description)
                            <p class="photo-description">{{ $foto->description }}</p>
                        @else
                            <p class="photo-description" style="opacity: 0.6; font-style: italic;">
                                Sem descrição
                            </p>
                        @endif

                        <div class="photo-footer">
                            <div class="photo-meta">
                                <div class="photo-meta-item">
                                    <i class="bi bi-calendar"></i>
                                    {{ $foto->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-image"></i>
            </div>
            <h3 class="empty-title">Nenhuma foto encontrada</h3>
            <p class="empty-text">
                @if($category)
                    Nenhuma foto na categoria "{{ $categories[$category] ?? $category }}"
                @elseif($search)
                    Nenhuma foto com a descrição contendo "{{ $search }}"
                @else
                    A galeria ainda está vazia. Volte em breve!
                @endif
            </p>
            @if($category || $search)
                <a href="{{ route('user.galeria') }}" class="btn-filter btn-apply">
                    Ver Todas as Fotos
                </a>
            @endif
        </div>
    @endif
</div>

<!-- Photo Modal -->
<div id="photoModal" class="modal-overlay" onclick="closePhotoModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <button class="modal-close-btn" onclick="closePhotoModal()">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="modal-body">
            <div class="modal-image-container">
                <img id="modalImage" src="" alt="Foto ampliada">
            </div>

            <div class="modal-info">
                <div id="modalCategory" class="modal-category"></div>

                <div class="modal-description-title">Descrição</div>
                <p id="modalDescription" class="modal-description"></p>

                <div class="modal-meta">
                    <div class="modal-meta-item">
                        <i class="bi bi-calendar"></i>
                        <span id="modalDate"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openPhotoModal(imageSrc, description, category, date) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('modalDescription').textContent = description;
        document.getElementById('modalCategory').textContent = category;
        document.getElementById('modalDate').textContent = date;
        document.getElementById('photoModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closePhotoModal(event) {
        // Se clicou no overlay (fundo), fecha o modal
        if (event && event.target.id !== 'photoModal') return;
        
        document.getElementById('photoModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Fecha o modal ao pressionar ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePhotoModal();
        }
    });
</script>

@endsection
