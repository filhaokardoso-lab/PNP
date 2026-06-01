@extends('layouts.admin')
@section('content')

<style>
    /* Reuse gallery variables/styles for consistent appearance */
    :root {
        --primary-color: #c41e3a;
        --primary-dark: #8b0000;
        --background-color: #f5e6d3;
        --text-color: #2c1810;
        --gold: #d4a574;
        --light-bg: #faf6f1;
    }

    body { background-color: var(--background-color); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

    .gallery-container { max-width: 1400px; margin: 0 auto; padding: 2.5rem 2rem; }
    .gallery-header { text-align: center; margin-bottom: 2rem; }
    .page-title { color: var(--primary-color); font-size: 2.4rem; font-weight:700; text-transform:uppercase }
    .gallery-subtitle { color: var(--text-color); opacity:0.8 }

    .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.6rem; margin-top: 1.8rem }

    .photo-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; display:flex; flex-direction:column }
    .photo-card:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(0,0,0,0.15) }

    .photo-image { position: relative; overflow: hidden; height: 0; padding-bottom: 56.25%; background: #000 }
    .photo-image img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover }

    .photo-info { padding: 1rem 1.2rem; display:flex; flex-direction:column; gap:0.6rem }
    .photo-info h3 { margin:0; color:var(--text-color); font-size:1rem }
    .photo-info p { margin:0; color:#6b6b6b; font-size:0.95rem }

    .play-overlay { position:absolute; inset:0; display:flex; align-items:center; justify-content:center }
    .play-btn { background: var(--primary-color); color:#fff; width:64px; height:64px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:20px; box-shadow:0 8px 20px rgba(196,30,58,0.18) }

    .empty-state { text-align:center; padding:4rem; background:white; border-radius:12px }

    .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 1000; }
    .modal-overlay.active { display:flex; justify-content:center; align-items:center }
    .modal-content { position: relative; max-width: 90vw; max-height: 90vh; background: #000; border-radius: 12px; overflow: hidden; }
    .modal-iframe { width: 100%; height: 70vh; border: 0 }
    .modal-close-btn { position:absolute; top:8px; right:8px; background:var(--primary-color); color:white; border:none; padding:8px 10px; border-radius:8px }

    @media (max-width: 768px) { .gallery-container{ padding:1.5rem } .gallery-grid { grid-template-columns: repeat(auto-fill, minmax(200px,1fr)); gap:1rem } }
    @media (max-width: 480px) { .page-title{ font-size:1.5rem } }
</style>

<div class="gallery-container">
    <div class="gallery-header">
        <h1 class="page-title">Galeria de Vídeos</h1>
        <p class="gallery-subtitle">Vídeos selecionados do evento — clique para assistir no player.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><span class="alert-close" onclick="this.parentElement.style.display='none';">&times;</span>✓ {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error"><span class="alert-close" onclick="this.parentElement.style.display='none';">&times;</span>
            <ul style="margin:0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    @if(isset($videos) && $videos->count() > 0)
        <div class="gallery-grid">
            @foreach($videos as $video)
                <?php
                    preg_match('/(?:v=|\/embed\/|youtu\.be\/)([A-Za-z0-9_-]{11})/', $video->url, $m);
                    $yt = $m[1] ?? null;
                    $thumb = $yt ? "https://img.youtube.com/vi/{$yt}/hqdefault.jpg" : asset('images/video-placeholder.png');
                    $embed = $yt ? "https://www.youtube.com/embed/{$yt}" : $video->url;
                ?>
                <div class="photo-card" data-embed="{{ $embed }}">
                    <div class="photo-image">
                        <img src="{{ $thumb }}" alt="{{ $video->title ?? 'Vídeo' }}" loading="lazy">
                        <div class="play-overlay"><button class="play-btn" aria-label="Play">▶</button></div>
                    </div>

                    <div class="photo-info">
                        <h3>{{ $video->title ?? 'Sem título' }}</h3>
                        <p>{{ $video->description ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <h3>Nenhum vídeo encontrado</h3>
            <p>Peça ao administrador para enviar vídeos.</p>
        </div>
    @endif
</div>

<!-- Video Modal -->
<div id="videoModal" class="modal-overlay" onclick="closeVideoModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <button class="modal-close-btn" onclick="closeVideoModal()">Fechar</button>
        <iframe id="videoFrame" class="modal-iframe" src="" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>

<script>
    document.querySelectorAll('.photo-card').forEach(card => {
        card.addEventListener('click', () => {
            const embed = card.getAttribute('data-embed');
            const frame = document.getElementById('videoFrame');
            frame.src = embed + '?autoplay=1';
            document.getElementById('videoModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    function closeVideoModal(e) {
        document.getElementById('videoModal').classList.remove('active');
        document.getElementById('videoFrame').src = '';
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeVideoModal(); });
</script>

@endsection