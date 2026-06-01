@extends('layouts.admin')

@section('content')

<style>
    :root {
        --primary-color: #c41e3a;
        --primary-dark: #8b0000;
        --background-color: #f5e6d3;
        --text-color: #2c1810;
        --hover-color: #d64d4d;
        --border-color: #d4a574;
    }

    body {
        background-color: var(--background-color);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-title {
        text-align: center;
        color: var(--primary-color);
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .subtitle {
        text-align: center;
        color: var(--text-color);
        font-size: 1rem;
        margin-bottom: 2rem;
        opacity: 0.8;
    }

    .comment-form-container {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 3rem;
        border-left: 5px solid var(--primary-color);
    }

    .form-label {
        color: var(--text-color);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-color: var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(196, 30, 58, 0.15);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .btn-submit {
        background-color: var(--primary-color);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-submit:hover {
        background-color: var(--primary-dark);
        box-shadow: 0 4px 12px rgba(196, 30, 58, 0.3);
        transform: translateY(-2px);
        color: white;
    }

    .comments-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .comment-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .comment-card:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .comment-author {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .comment-category {
        display: inline-block;
        background-color: var(--primary-color);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .comment-category.sugestao {
        background-color: #28a745;
    }

    .comment-category.elogio {
        background-color: #ffc107;
        color: #333;
    }

    .comment-category.critica {
        background-color: #dc3545;
    }

    .comment-date {
        color: #999;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .comment-text {
        color: var(--text-color);
        line-height: 1.6;
        margin-bottom: 1rem;
        word-wrap: break-word;
        white-space: pre-wrap;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .comment-actions {
        display: flex;
        gap: 0.75rem;
        border-top: 1px solid #eee;
        padding-top: 1rem;
    }

    .comment-actions {
        display: flex;
        gap: 0.75rem;
        border-top: 1px solid #eee;
        padding-top: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        background: none;
        border: none;
        color: var(--primary-color);
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.2s;
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .btn-action:hover {
        color: var(--primary-dark);
        transform: scale(1.05);
    }

    .btn-action.delete {
        color: #dc3545;
    }

    .btn-action.delete:hover {
        color: #c82333;
    }

    .btn-action.curtir {
        color: #e74c3c;
    }

    .btn-action.curtir.curtido {
        color: #c0392b;
    }

    .btn-action.curtir:hover {
        transform: scale(1.15);
    }

    .curtida-count {
        display: inline-block;
        background-color: #fee;
        color: #c0392b;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .respostas-container {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f0f0f0;
    }

    .respostas-title {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .resposta-item {
        background-color: #fafafa;
        border-left: 3px solid #ddd;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 6px;
    }

    .resposta-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }

    .resposta-author {
        font-weight: 600;
        color: var(--text-color);
        font-size: 0.95rem;
    }

    .resposta-date {
        color: #999;
        font-size: 0.8rem;
    }

    .resposta-text {
        color: var(--text-color);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 0.75rem;
        word-wrap: break-word;
        white-space: pre-wrap;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .resposta-actions {
        display: flex;
        gap: 0.5rem;
    }

    .form-resposta {
        background-color: #fff9f5;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1rem;
        display: none;
    }

    .form-resposta.ativo {
        display: block;
    }

    .form-resposta textarea {
        resize: vertical;
        min-height: 80px;
    }

    .form-resposta .btn-submit {
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
    }

    .form-resposta .btn-cancel {
        background-color: #6c757d;
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
        margin-left: 0.5rem;
    }

    .form-resposta .btn-cancel:hover {
        background-color: #5a6268;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #999;
    }

    .empty-state-icon {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }

    .empty-state p {
        font-size: 1.1rem;
        margin: 0;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: var(--border-color);
    }

    .login-required-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .login-required-modal.active {
        display: flex;
    }

    .login-modal-content {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        max-width: 450px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        text-align: center;
        animation: slideUp 0.3s ease;
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

    .login-modal-content h2 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        font-weight: 700;
        font-size: 1.8rem;
    }

    .login-modal-content p {
        color: var(--text-color);
        margin-bottom: 2rem;
        line-height: 1.6;
        font-size: 1rem;
    }

    .login-buttons {
        display: flex;
        gap: 1rem;
        flex-direction: column;
    }

    .btn-login {
        background-color: var(--primary-color);
        color: white;
        padding: 1rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        font-size: 1rem;
    }

    .btn-login:hover {
        background-color: var(--primary-dark);
        box-shadow: 0 4px 12px rgba(196, 30, 58, 0.3);
        transform: translateY(-2px);
    }

    .btn-cancel-login {
        background-color: #6c757d;
        color: white;
        padding: 1rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-cancel-login:hover {
        background-color: #5a6268;
    }

    .btn-action.disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.75rem;
        }

        .comment-form-container {
            padding: 1.5rem;
        }

        .comment-header {
            flex-direction: column;
        }

        .comment-category {
            margin-top: 0.75rem;
        }

        .login-modal-content {
            padding: 2rem;
        }

        .login-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="container mt-5">
    <h1 class="page-title">Comentários e Sugestões</h1>
    <p class="subtitle">Compartilhe seus elogios, sugestões e críticas construtivas</p>

    {{-- Exibir mensagem de sucesso se houver --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Formulário de novo comentário --}}
    <div class="comment-form-container">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; font-weight: 700;">
            <i class="bi bi-pencil-square"></i> Deixe seu Comentário
        </h3>

        @if(auth()->check())
            <form action="{{ route('user.comentarios') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome" class="form-label">Nome *</label>
                            <input type="text" 
                                   class="form-control @error('nome') is-invalid @enderror" 
                                   id="nome" 
                                   name="nome" 
                                   value="{{ auth()->user()->name ?? old('nome') }}" 
                                   placeholder="Digite seu nome"
                                   required>
                            @error('nome')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">E-mail *</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ auth()->user()->email ?? old('email') }}" 
                                   placeholder="Digite seu e-mail"
                                   required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="categoria" class="form-label">Categoria *</label>
                    <select class="form-select @error('categoria') is-invalid @enderror" 
                            id="categoria" 
                            name="categoria" 
                            required>
                        <option value="">Selecione uma categoria</option>
                        <option value="sugestao" {{ old('categoria') == 'sugestao' ? 'selected' : '' }}>💡 Sugestão</option>
                        <option value="elogio" {{ old('categoria') == 'elogio' ? 'selected' : '' }}>⭐ Elogio</option>
                        <option value="critica" {{ old('categoria') == 'critica' ? 'selected' : '' }}>💬 Crítica Construtiva</option>
                        <option value="duvida" {{ old('categoria') == 'duvida' ? 'selected' : '' }}>❓ Dúvida</option>
                        <option value="outro" {{ old('categoria') == 'outro' ? 'selected' : '' }}>📌 Outro</option>
                    </select>
                    @error('categoria')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="comentario" class="form-label">Seu Comentário *</label>
                    <textarea class="form-control @error('comentario') is-invalid @enderror" 
                              id="comentario" 
                              name="comentario" 
                              placeholder="Digite seu comentário aqui... (mínimo 10 caracteres)"
                              minlength="10"
                              maxlength="1000"
                              required>{{ old('comentario') }}</textarea>
                    <small class="form-text text-muted d-block mt-2">
                        <span id="charCount">0</span>/1000 caracteres
                    </small>
                    @error('comentario')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="form-check mb-3">
                    <input class="form-check-input" 
                           type="checkbox" 
                           id="anonimo" 
                           name="anonimo" 
                           {{ old('anonimo') ? 'checked' : '' }}>
                    <label class="form-check-label" for="anonimo">
                        Deixar comentário anônimo
                    </label>
                </div> --}}

                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-send"></i> Enviar Comentário
                </button>
            </form>
        @else
            <div style="text-align: center; padding: 2rem;">
                <p style="color: var(--text-color); font-size: 1.1rem; margin-bottom: 1.5rem;">
                    <i class="bi bi-lock-fill" style="font-size: 2rem; color: var(--primary-color);"></i><br><br>
                    Você precisa estar logado para deixar um comentário
                </p>
                <a href="{{ route('login') }}" class="btn btn-submit">
                    <i class="bi bi-box-arrow-in-right"></i> Fazer Login
                </a>
            </div>
        @endif
    </div>

    {{-- Lista de comentários --}}
    <div>
        <h3 style="color: var(--primary-color); margin-bottom: 2rem; font-weight: 700;">
            <i class="bi bi-chat-dots"></i> Comentários Recentes
        </h3>

        @if(isset($comentarios) && count($comentarios) > 0)
            <div class="comments-list">
                @foreach($comentarios as $comentario)
                    <div class="comment-card">
                        <div class="comment-header">
                            <div>
                                <div class="comment-author">
                                    {{ $comentario->anonimo ? '👤 Anônimo' : $comentario->nome }}
                                </div>
                                <div class="comment-date">
                                    <i class="bi bi-calendar-event"></i> 
                                    {{ $comentario->created_at->format('d/m/Y às H:i') ?? 'Data não disponível' }}
                                </div>
                            </div>
                            <span class="comment-category 
                                @if($comentario->categoria == 'sugestao') sugestao
                                @elseif($comentario->categoria == 'elogio') elogio
                                @elseif($comentario->categoria == 'critica') critica
                                @endif">
                                {{ ucfirst($comentario->categoria ?? 'Outro') }}
                            </span>
                        </div>

                        <p class="comment-text">{{ $comentario->comentario }}</p>

                        <div class="comment-actions">
                            <!-- Botão de Curtir -->
                            <!-- Botão de Curtir -->
                            @if(auth()->check())
                                <button type="button" 
                                        class="btn-action curtir" 
                                        data-comentario-id="{{ $comentario->id }}"
                                        onclick="curtirComentario(this, {{ $comentario->id }})">
                                    <span class="curtir-icon">🤍</span>
                                    <span class="curtir-text">Curtir</span>
                                    <span class="curtida-count" data-curtidas="{{ $comentario->id }}">{{ $comentario->curtidas->count() }}</span>
                                </button>
                            @else
                                <button type="button" 
                                        class="btn-action curtir disabled" 
                                        onclick="showLoginModal()">
                                    <span class="curtir-icon">🤍</span>
                                    <span class="curtir-text">Curtir</span>
                                    <span class="curtida-count" data-curtidas="{{ $comentario->id }}">{{ $comentario->curtidas->count() }}</span>
                                </button>
                            @endif

                            <!-- Botão de Responder -->
                            @if(auth()->check())
                                <button type="button" 
                                        class="btn-action responder" 
                                        onclick="toggleFormResposta({{ $comentario->id }})">
                                    <i class="bi bi-reply"></i> Responder
                                </button>
                            @else
                                <button type="button" 
                                        class="btn-action responder disabled" 
                                        onclick="showLoginModal()">
                                    <i class="bi bi-reply"></i> Responder
                                </button>
                            @endif

                            @if(auth()->user() && (auth()->user()->id == $comentario->user_id || auth()->user()->hasPermissionTo('destroy-comentario')))
                                <!-- Botão de Deletar -->
                                <form action="{{ route('user.comentarios.destroy', $comentario->id) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Deseja realmente excluir este comentário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete">
                                        <i class="bi bi-trash"></i> Excluir
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Seção de Respostas -->
                        <div class="respostas-container" id="respostas-{{ $comentario->id }}">
                            <div class="respostas-title">
                                <i class="bi bi-chat-left-quote"></i>
                                Respostas <span style="color: #999;">({{ $comentario->respostas->count() }})</span>
                            </div>

                            <!-- Listagem de Respostas -->
                            <div id="lista-respostas-{{ $comentario->id }}">
                                @forelse($comentario->respostas as $resposta)
                                    <div class="resposta-item">
                                        <div class="resposta-header">
                                            <div>
                                                <div class="resposta-author">
                                                    {{ $resposta->anonimo ? '👤 Anônimo' : $resposta->nome }}
                                                </div>
                                                <div class="resposta-date">
                                                    {{ $resposta->created_at->format('d/m/Y às H:i') }}
                                                </div>
                                            </div>

                                            @if(auth()->user() && (auth()->user()->id == $resposta->user_id || auth()->user()->hasPermissionTo('destroy-comentario')))
                                                <form action="{{ route('comentario.resposta.destroy', $resposta->id) }}" 
                                                      method="POST" 
                                                      style="display: inline;"
                                                      onsubmit="return confirm('Deletar esta resposta?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action delete" style="padding: 0.2rem 0.5rem;">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <p class="resposta-text">{{ $resposta->resposta }}</p>
                                    </div>
                                @empty
                                    <p style="color: #999; font-size: 0.9rem; text-align: center; padding: 1rem;">
                                        Nenhuma resposta ainda. Seja o primeiro! 💬
                                    </p>
                                @endforelse
                            </div>

                            <!-- Formulário de Nova Resposta -->
                            <form id="form-resposta-{{ $comentario->id }}" 
                                  class="form-resposta" 
                                  action="{{ route('comentario.resposta.store', $comentario->id) }}" 
                                  method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nome-resposta-{{ $comentario->id }}" class="form-label">Nome *</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="nome-resposta-{{ $comentario->id }}" 
                                                   name="nome" 
                                                   value="{{ auth()->user()->name ?? '' }}" 
                                                   placeholder="Seu nome"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email-resposta-{{ $comentario->id }}" class="form-label">E-mail *</label>
                                            <input type="email" 
                                                   class="form-control" 
                                                   id="email-resposta-{{ $comentario->id }}" 
                                                   name="email" 
                                                   value="{{ auth()->user()->email ?? '' }}" 
                                                   placeholder="seu@email.com"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="resposta-{{ $comentario->id }}" class="form-label">Sua Resposta *</label>
                                    <textarea class="form-control" 
                                              id="resposta-{{ $comentario->id }}" 
                                              name="resposta" 
                                              placeholder="Escreva sua resposta..." 
                                              minlength="5"
                                              maxlength="500"
                                              required></textarea>
                                    <small class="form-text text-muted" style="display: block; margin-top: 0.3rem;">
                                        <span class="resposta-char-count">0</span>/500 caracteres
                                    </small>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="anonimo-resposta-{{ $comentario->id }}" 
                                           name="anonimo">
                                    <label class="form-check-label" for="anonimo-resposta-{{ $comentario->id }}">
                                        Responder como anônimo
                                    </label>
                                </div>

                                <div>
                                    <button type="submit" class="btn-submit">
                                        <i class="bi bi-send"></i> Enviar Resposta
                                    </button>
                                    <button type="button" 
                                            class="btn-submit btn-cancel" 
                                            onclick="toggleFormResposta({{ $comentario->id }}, true)">
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <p>Nenhum comentário ainda. Seja o primeiro a comentar! 😊</p>
            </div>
        @endif
    </div>
</div>

<script>
    // Contador de caracteres em tempo real
    const comentarioTextarea = document.getElementById('comentario');
    const charCountSpan = document.getElementById('charCount');

    if (comentarioTextarea) {
        comentarioTextarea.addEventListener('input', function() {
            charCountSpan.textContent = this.value.length;
        });

        // Inicializar o contador
        charCountSpan.textContent = comentarioTextarea.value.length;
    }

    // ===== FUNÇÕES DE CURTIDA =====
    function curtirComentario(button, comentarioId) {
        const form = new FormData();
        
        fetch(`/comentarios/${comentarioId}/curtida`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || 
                                 document.querySelector('input[name="_token"]')?.value,
                'Accept': 'application/json'
            },
            body: form
        })
        .then(response => response.json())
        .then(data => {
            const curtidaCount = button.querySelector('.curtida-count');
            curtidaCount.textContent = data.total_curtidas;

            // Alternar ícone e cor
            const icon = button.querySelector('.curtir-icon');
            if (data.curtida) {
                button.classList.add('curtido');
                icon.textContent = '❤️';
            } else {
                button.classList.remove('curtido');
                icon.textContent = '🤍';
            }
        })
        .catch(error => {
            console.error('Erro ao curtir:', error);
            alert('Erro ao curtir comentário. Tente novamente.');
        });
    }

    // ===== FUNÇÕES DE RESPOSTA =====
    function toggleFormResposta(comentarioId, fechar = false) {
        const form = document.getElementById(`form-resposta-${comentarioId}`);
        
        if (!form) {
            console.error(`Formulário não encontrado: form-resposta-${comentarioId}`);
            return;
        }

        if (fechar) {
            form.classList.remove('ativo');
        } else {
            form.classList.toggle('ativo');
            
            // Focar no campo de resposta
            setTimeout(() => {
                const textarea = form.querySelector(`textarea[id="resposta-${comentarioId}"]`);
                if (textarea) {
                    textarea.focus();
                }
            }, 100);
        }
    }

    // Contador de caracteres para respostas
    document.querySelectorAll('.form-resposta textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            const charCount = this.parentElement.querySelector('.resposta-char-count');
            if (charCount) {
                charCount.textContent = this.value.length;
            }
        });
    });

    // Envio de resposta via AJAX
    document.querySelectorAll('.form-resposta').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const comentarioId = this.action.split('/').slice(-2)[0];
            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || 
                                   document.querySelector('input[name="_token"]')?.value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Erro ao enviar resposta');
                return response.json();
            })
            .then(data => {
                // Limpar formulário
                this.reset();
                
                // Atualizar contador de respostas
                const respostaCount = document.querySelector(
                    `#respostas-${comentarioId} .respostas-title`
                );
                if (respostaCount) {
                    const count = respostaCount.querySelector('span');
                    if (count) {
                        count.textContent = `(${data.total_respostas})`;
                    }
                }

                // Fechar formulário
                toggleFormResposta(comentarioId, true);

                // Mostrar mensagem de sucesso
                alert('✅ Resposta enviada com sucesso!');

                // Recarregar a página para mostrar a nova resposta
                location.reload();
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('❌ Erro ao enviar resposta. Tente novamente.');
            });
        });
    });

    // ===== FUNÇÃO DE LOGIN MODAL =====
    function showLoginModal() {
        const modal = document.getElementById('loginModal');
        if (modal) {
            modal.classList.add('active');
        }
    }

    function closeLoginModal() {
        const modal = document.getElementById('loginModal');
        if (modal) {
            modal.classList.remove('active');
        }
    }

    // Fechar modal ao clicar fora dele
    const modal = document.getElementById('loginModal');
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === this) {
                closeLoginModal();
            }
        });
    }
</script>

<!-- Modal de Login Necessário -->
<div id="loginModal" class="login-required-modal">
    <div class="login-modal-content">
        <h2>Acesso Necessário</h2>
        <p>
            Para curtir comentários e deixar respostas, você precisa estar logado em sua conta. 
            Faça login ou crie uma conta para participar da conversa!
        </p>
        <div class="login-buttons">
            <a href="{{ route('login') }}" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Fazer Login
            </a>
            <a href="{{ route('login.create-user') }}" class="btn-login">
                <i class="bi bi-person-plus"></i> Criar Conta
            </a>
            <button type="button" class="btn-cancel-login" onclick="closeLoginModal()">
                Cancelar
            </button>
        </div>
    </div>
</div>

@endsection