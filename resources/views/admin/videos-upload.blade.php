@extends('layouts.admin')

@section('content')
<style>
    /* Copiado e adaptado de admin/fotos-upload.blade.php para manter consistência */
    :root {
        --primary-color: #c41e3a;
        --primary-dark: #8b0000;
        --background-color: #f5e6d3;
        --text-color: #2c1810;
        --gold: #d4a574;
        --light-bg: #faf6f1;
    }

    * { margin:0; padding:0; box-sizing:border-box }
    body { background-color: var(--background-color); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif }

    .upload-container { max-width:900px; margin:2rem auto; padding:2rem }
    .page-header { text-align:center; margin-bottom:2rem }
    .page-title { color:var(--primary-color); font-size:2rem; font-weight:700; margin-bottom:0.5rem }
    .page-subtitle { color:var(--text-color); opacity:0.8 }

    .upload-card { background:white; border-radius:15px; box-shadow:0 8px 25px rgba(0,0,0,0.1); padding:2rem; margin-bottom:1.5rem }

    .form-group { margin-bottom:1.2rem }
    .form-label { display:block; color:var(--primary-color); font-weight:700; margin-bottom:0.6rem; text-transform:uppercase; font-size:0.95rem }
    .form-control, .form-select { width:100%; padding:0.9rem 1.2rem; border:2px solid #e0e0e0; border-radius:8px; font-size:1rem }
    .form-control:focus { outline:none; border-color:var(--primary-color); box-shadow:0 0 0 3px rgba(196,30,58,0.08) }

    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem }
    .form-grid-full { grid-column:1 / -1 }

    .thumb-preview { max-width:320px; margin-top:1rem; border-radius:8px; box-shadow:0 6px 20px rgba(0,0,0,0.12); display:none }
    .thumb-preview.show { display:block }

    .button-group { display:flex; gap:1rem; margin-top:1rem }
    .btn { padding:0.9rem 1.6rem; border:none; border-radius:8px; font-weight:700; cursor:pointer }
    .btn-submit { background:var(--primary-color); color:#fff }
    .btn-reset { background:#e0e0e0; color:var(--text-color) }

    .videos-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(150px,1fr)); gap:0.8rem; margin-top:1.2rem }
    .video-thumb { width:100%; aspect-ratio:16/9; object-fit:cover; border-radius:8px }
    .delete-btn { background:var(--primary-color); color:#fff; border:none; padding:6px 10px; border-radius:6px }

    @media (max-width:768px) { .form-grid { grid-template-columns:1fr } .upload-container{ padding:1rem } }
</style>

<div class="upload-container">
    <div class="page-header">
        <h1 class="page-title">📥 Upload de Vídeos</h1>
        <p class="page-subtitle">Adicione links do YouTube para exibição na página de vídeos.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            <span class="alert-close" onclick="this.parentElement.style.display='none';">&times;</span>
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

    <div class="upload-card">
        <form method="POST" action="{{ route('videos.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">🔗 URL do YouTube</label>
                    <input id="videoUrl" type="url" name="url" class="form-control" placeholder="https://youtu.be/ID ou https://www.youtube.com/watch?v=ID" required>
                    <small style="color:#666; display:block; margin-top:6px">Apenas links do YouTube. A thumbnail será mostrada abaixo.</small>
                </div>

                <div class="form-group">
                    <label class="form-label">✏️ Título (opcional)</label>
                    <input type="text" name="title" class="form-control" placeholder="Título do vídeo">
                </div>

                <div class="form-group form-grid-full">
                    <label class="form-label">📝 Descrição (opcional)</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Descrição breve"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Pré-visualização da Thumbnail</label>
                <img id="thumbPreview" class="thumb-preview" alt="Pré-visualização da thumbnail">
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-submit"> <i class="bi bi-upload"></i> Fazer Upload</button>
                <button type="reset" id="resetBtn" class="btn btn-reset">Limpar</button>
            </div>
        </form>
    </div>

    @if(isset($videos) && $videos->count() > 0)
        <div class="gallery-section">
            <h2 class="section-title">🎞️ Vídeos Carregados ({{ $videos->count() }})</h2>
            <div class="videos-grid">
                @foreach($videos as $video)
                    <?php
                        preg_match('/(?:v=|\/embed\/|youtu\.be\/)([A-Za-z0-9_-]{11})/', $video->url, $m);
                        $yt = $m[1] ?? null;
                        $thumb = $yt ? "https://img.youtube.com/vi/{$yt}/hqdefault.jpg" : asset('images/video-placeholder.png');
                    ?>
                    <div>
                        <img src="{{ $thumb }}" class="video-thumb" alt="{{ $video->title }}">
                        <div style="display:flex;gap:0.5rem;margin-top:0.5rem;">
                            <form method="POST" action="{{ route('videos.destroy', $video->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="delete-btn" onclick="return confirm('Excluir vídeo?')">Deletar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

@endsection

<script>
    // Extrai ID do YouTube e mostra preview da thumbnail
    function extractYoutubeId(url) {
        const m = url.match(/(?:v=|\/embed\/|youtu\.be\/)([A-Za-z0-9_-]{11})/);
        if (m) return m[1];
        try {
            const u = new URL(url);
            const qs = new URLSearchParams(u.search);
            if (qs.has('v') && /^([A-Za-z0-9_-]{11})$/.test(qs.get('v'))) return qs.get('v');
        } catch(e) {}
        return null;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const urlInput = document.getElementById('videoUrl');
        const thumb = document.getElementById('thumbPreview');
        const resetBtn = document.getElementById('resetBtn');

        function updatePreview() {
            const id = extractYoutubeId(urlInput.value || '');
            if (id) {
                thumb.src = `https://img.youtube.com/vi/${id}/hqdefault.jpg`;
                thumb.classList.add('show');
            } else {
                thumb.src = '';
                thumb.classList.remove('show');
            }
        }

        urlInput.addEventListener('change', updatePreview);
        urlInput.addEventListener('input', updatePreview);
        resetBtn && resetBtn.addEventListener('click', () => { thumb.src = ''; thumb.classList.remove('show'); });
    });
</script>
