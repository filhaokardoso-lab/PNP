@extends('layouts.admin')

@section('content')
<main>
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
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .description {
            text-align: center;
            color: var(--text-color);
            font-size: 1rem;
            margin-bottom: 1.75rem;
            opacity: 0.85;
        }

        .form-card {
            max-width: 1080px;
            margin: 0 auto 3rem;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 1px;
        }

        .form-body,
        .image-panel {
            background: #fff;
            padding: 2rem;
        }

        .form-body h2,
        .image-panel h2 {
            color: #111827;
            margin-bottom: 1rem;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-weight: 600;
        }

        input,
        select {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            background: #f9fafb;
            color: #111827;
            font-size: 0.95rem;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(196, 30, 58, 0.12);
            background: #ffffff;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-secondary,
        .btn-primary {
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-primary {
            background: var(--primary-color);
            color: #fff;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            opacity: 0.95;
        }

        .image-panel {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .image-preview {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            min-height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
        }

        .image-preview img {
            width: 100%;
            height: auto;
            object-fit: contain;
            max-height: 320px;
        }

        .image-panel button {
            width: 100%;
            margin-top: 1.25rem;
            background: #111827;
            color: #fff;
        }

        .text-danger {
            margin-top: 0.35rem;
            color: #b91c1c;
            font-size: 0.92rem;
        }

        @media (max-width: 960px) {
            .form-card {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="page-title">Alteração de Patrimônio</div>
    <p class="description">Atualize os dados do patrimônio e salve para registrar as mudanças.</p>

    <div class="form-card">
        <div class="form-body">
            <h2>Dados do Patrimônio</h2>

            <x-alert />

            <form action="{{ route('patrimonios.update', ['patrimonio' => $patrimonio->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div>
                        <label for="codigo">Código do Patrimônio</label>
                        <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $patrimonio->codigo) }}" required>
                        @error('codigo')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="data_aquisicao">Data de Aquisição</label>
                        <input type="date" id="data_aquisicao" name="data_aquisicao" value="{{ old('data_aquisicao', $patrimonio->data_aquisicao?->format('Y-m-d')) }}" required>
                        @error('data_aquisicao')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="full-width">
                        <label for="descricao">Descrição</label>
                        <input type="text" id="descricao" name="descricao" value="{{ old('descricao', $patrimonio->descricao) }}" required>
                        @error('descricao')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="valor_aquisicao">Valor de Aquisição (R$)</label>
                        <input type="number" step="0.01" id="valor_aquisicao" name="valor_aquisicao" value="{{ old('valor_aquisicao', $patrimonio->valor_aquisicao) }}" required>
                        @error('valor_aquisicao')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="categoria">Categoria</label>
                        <input type="text" id="categoria" name="categoria" value="{{ old('categoria', $patrimonio->categoria) }}" required>
                        @error('categoria')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="setor_localizacao">Setor / Localização</label>
                        <input type="text" id="setor_localizacao" name="setor_localizacao" value="{{ old('setor_localizacao', $patrimonio->setor_localizacao) }}">
                        @error('setor_localizacao')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="marca">Marca</label>
                        <input type="text" id="marca" name="marca" value="{{ old('marca', $patrimonio->marca) }}">
                        @error('marca')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="situacao">Situação</label>
                        <select id="situacao" name="situacao" required>
                            <option value="Ativo" {{ old('situacao', $patrimonio->situacao) === 'Ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="Inativo" {{ old('situacao', $patrimonio->situacao) === 'Inativo' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        @error('situacao')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="modelo">Modelo</label>
                        <input type="text" id="modelo" name="modelo" value="{{ old('modelo', $patrimonio->modelo) }}">
                        @error('modelo')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="numero_serie">Número de Série</label>
                        <input type="text" id="numero_serie" name="numero_serie" value="{{ old('numero_serie', $patrimonio->numero_serie) }}">
                        @error('numero_serie')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="button-group">
                    <a href="{{ route('patrimonios.index') }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Salvar alterações</button>
                </div>
            </form>
        </div>

        <div class="image-panel">
            <h2>Imagem do Patrimônio</h2>
            <div class="image-preview" onclick="document.getElementById('imagem').click()">
                @if($patrimonio->imagem)
                    <img id="preview" src="{{ asset('uploads/patrimonios/' . $patrimonio->imagem) }}" alt="Imagem do patrimônio">
                @else
                    <span style="color:#6b7280;">Nenhuma imagem cadastrada</span>
                @endif
            </div>

            <label for="imagem" style="margin-top:1rem; font-weight:600; color:#374151;">Alterar imagem</label>
            <input type="file" id="imagem" name="imagem" accept="image/jpeg,image/png" style="display:none;" onchange="previewImage(event)">
            @error('imagem')<div class="text-danger">{{ $message }}</div>@enderror
            <button type="button" class="btn-secondary" onclick="document.getElementById('imagem').click()">Selecionar nova imagem</button>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            if (!file) return;
            if (preview) {
                preview.src = URL.createObjectURL(file);
            } else {
                const previewContainer = document.querySelector('.image-preview');
                previewContainer.innerHTML = `<img id="preview" src="${URL.createObjectURL(file)}" alt="Pré-visualização">`;
            }
        }
    </script>
</main>
@endsection
