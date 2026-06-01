@extends('layouts.admin')

@section('content')
<main>
    <style>
        .patrimonio-page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 1rem 1.5rem 3rem;
        }

        .patrimonio-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 1.5rem;
            padding: 2rem;
        }

        .patrimonio-card h1,
        .patrimonio-card h2 {
            margin-bottom: 0.75rem;
            color: #1f2937;
        }

        .patrimonio-card h1 {
            font-size: 2rem;
            font-weight: 700;
        }

        .patrimonio-card p.description {
            color: #4b5563;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .field-grid .full-width {
            grid-column: span 2;
        }

        .field-grid label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-weight: 600;
        }

        .field-grid input,
        .field-grid select,
        .field-grid textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            background: #f9fafb;
            color: #111827;
            font-size: 0.95rem;
        }

        .field-grid input:focus,
        .field-grid select:focus,
        .field-grid textarea:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
            background: #ffffff;
        }

        .image-dropzone {
            min-height: 360px;
            border: 2px dashed #d1d5db;
            border-radius: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            text-align: center;
            color: #6b7280;
            background: #f8fafc;
        }

        .image-dropzone strong {
            display: block;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .image-dropzone img {
            max-width: 100%;
            margin-top: 1rem;
            border-radius: 0.75rem;
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn-secondary,
        .btn-primary {
            border: none;
            border-radius: 0.75rem;
            padding: 0.85rem 1.4rem;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .btn-primary {
            background: #c41e3a;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #9f1b33;
        }

        .text-danger {
            color: #b91c1c;
            margin-top: 0.35rem;
            font-size: 0.92rem;
        }

        @media (max-width: 900px) {
            .patrimonio-card {
                grid-template-columns: 1fr;
            }

            .field-grid {
                grid-template-columns: 1fr;
            }

            .field-grid .full-width {
                grid-column: span 1;
            }
        }
    </style>

    <section class="patrimonio-page">
        <div class="patrimonio-card">
            <div>
                <h1>Cadastro de Patrimônio</h1>
                <p class="description">Preencha as informações do patrimônio e clique em salvar para registrar o ativo.</p>

                <x-alert />

                <form action="{{ route('patrimonios.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="field-grid">
                        <div>
                            <label for="codigo">Código Patrimonial</label>
                            <input type="text" id="codigo" name="codigo" value="{{ old('codigo') }}" placeholder="000123"
                                class="@error('codigo') is-invalid @enderror">
                            @error('codigo')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="descricao">Descrição</label>
                            <input type="text" id="descricao" name="descricao" value="{{ old('descricao') }}" placeholder="Computador Desktop"
                                class="@error('descricao') is-invalid @enderror">
                            @error('descricao')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="categoria">Categoria</label>
                            <input type="text" id="categoria" name="categoria" value="{{ old('categoria') }}" placeholder="Informática"
                                class="@error('categoria') is-invalid @enderror">
                            @error('categoria')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="marca">Marca</label>
                            <input type="text" id="marca" name="marca" value="{{ old('marca') }}" placeholder="Dell"
                                class="@error('marca') is-invalid @enderror">
                            @error('marca')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="modelo">Modelo</label>
                            <input type="text" id="modelo" name="modelo" value="{{ old('modelo') }}" placeholder="OptiPlex 7090"
                                class="@error('modelo') is-invalid @enderror">
                            @error('modelo')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="numero_serie">Número de Série</label>
                            <input type="text" id="numero_serie" name="numero_serie" value="{{ old('numero_serie') }}" placeholder="ABC123456"
                                class="@error('numero_serie') is-invalid @enderror">
                            @error('numero_serie')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="data_aquisicao">Data de Aquisição</label>
                            <input type="date" id="data_aquisicao" name="data_aquisicao" value="{{ old('data_aquisicao') }}"
                                class="@error('data_aquisicao') is-invalid @enderror">
                            @error('data_aquisicao')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="valor_aquisicao">Valor de Aquisição (R$)</label>
                            <input type="number" step="0.01" id="valor_aquisicao" name="valor_aquisicao" value="{{ old('valor_aquisicao') }}" placeholder="5000.00"
                                class="@error('valor_aquisicao') is-invalid @enderror">
                            @error('valor_aquisicao')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="setor_localizacao">Setor / Localização</label>
                            <input type="text" id="setor_localizacao" name="setor_localizacao" value="{{ old('setor_localizacao') }}" placeholder="Sala 02"
                                class="@error('setor_localizacao') is-invalid @enderror">
                            @error('setor_localizacao')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="situacao">Situação</label>
                            <select id="situacao" name="situacao" class="@error('situacao') is-invalid @enderror">
                                <option value="" disabled {{ old('situacao') == '' ? 'selected' : '' }}>Selecione</option>
                                <option value="Ativo" {{ old('situacao') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="Inativo" {{ old('situacao') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                            @error('situacao')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="full-width">
                            <label for="imagem">Imagem do Patrimônio</label>
                            <div class="image-dropzone" onclick="document.getElementById('imagem').click()">
                                <strong>Clique ou arraste uma imagem para este espaço</strong>
                                <span>Formatos: JPG, PNG (máx. 5MB)</span>
                                <img id="preview" src="" alt="Pré-visualização" style="display: none;" />
                            </div>
                            <input type="file" id="imagem" name="imagem" accept="image/jpeg,image/png" style="display:none;" onchange="previewImage(event)">
                            @error('imagem')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('dashboard.index') }}" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];

            if (!file) {
                preview.style.display = 'none';
                preview.src = '';
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    </script>
</main>
@endsection
