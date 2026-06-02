<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>SESI SENAI SP</title>
    <style>
        :root {
            --sidebar-bg: #081c2e;
            --sidebar-color: #dbeafe;
            --sidebar-border: rgba(255, 255, 255, 0.08);
            --sidebar-hover: rgba(255, 255, 255, 0.12);
            --main-bg: #f4f6fb;
            --main-surface: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --accent: #ef4444;
            --shadow: 0 24px 80px rgba(15, 23, 42, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-primary);
            background-color: var(--main-bg);
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            min-width: 260px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-color);
            display: flex;
            flex-direction: column;
            padding: 1.5rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            border-right: 1px solid var(--sidebar-border);
            z-index: 100;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            margin-bottom: 2rem;
        }

        .sidebar-brand img {
            width: 40px;
            height: auto;
            border-radius: 0.35rem;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-text .brand-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.02em;
        }

        .brand-text .brand-role {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 1rem;
        }

        .sidebar-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav li {
            margin-bottom: 0.4rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            padding: 0.95rem 1rem;
            color: var(--sidebar-color);
            text-decoration: none;
            border-radius: 0.85rem;
            transition: background-color 0.2s ease, color 0.2s ease;
            font-size: 0.95rem;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: var(--sidebar-hover);
            color: #ffffff;
        }

        .sidebar-nav a i {
            min-width: 20px;
            text-align: center;
            font-size: 1.05rem;
            color: inherit;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--sidebar-border);
        }

        .sidebar-footer .user-info {
            margin-bottom: 0.9rem;
            font-size: 0.92rem;
            color: #cbd5e1;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 0.85rem;
            background-color: var(--accent);
            color: #ffffff;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: opacity 0.2s ease;
        }

        .btn-logout:hover {
            opacity: 0.9;
        }

        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            position: fixed;
            left: 260px;
            right: 0;
            top: 0;
            background: var(--main-surface);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            gap: 1rem;
            z-index: 50;
            box-shadow: var(--shadow);
        }

        .topbar .page-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .content {
            padding: 5.5rem 1.5rem 2rem;
            min-height: calc(100vh - 5.5rem);
            background-color: var(--main-bg);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                transition: transform 0.25s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .topbar {
                left: 0;
            }

            .menu-toggle {
                display: inline-flex;
                border: none;
                background: transparent;
                color: var(--text-primary);
                font-size: 1.25rem;
                cursor: pointer;
            }
        }

        @media (max-width: 640px) {
            .sidebar {
                width: 100%;
                min-width: 100%;
            }

            .sidebar-nav a {
                padding: 0.85rem 0.9rem;
            }

            .topbar {
                padding: 0.85rem 1rem;
            }

            .content {
                padding: 4.5rem 1rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard.index') }}">
                    <img src="{{ asset('images/SESISENAI.png') }}" alt="Logo Projeto PNP">
                </a>
                <div class="brand-text">
                    <span class="brand-name">Projeto PNP</span>
                    <span class="brand-role">Gestão de Patrimônio</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('dashboard.index') }}"><i class="bi bi-house-fill"></i>Home</a></li>

                    @can('index-user')
                    <li><a href="{{ route('user.index') }}"><i class="bi bi-people-fill"></i>Usuários</a></li>
                    @endcan

                    @can('index-role')
                    <li><a href="{{ route('role.index') }}"><i class="bi bi-shield-lock-fill"></i>Perfis</a></li>
                    @endcan

                    @can('create-user')
                    <li><a href="{{ route('user.create') }}"><i class="bi bi-person-plus-fill"></i>Cadastrar Usuário</a></li>
                    @endcan

                    @can('index-patrimonio')
                    <li><a href="{{ route('patrimonios.index') }}"><i class="bi bi-search"></i>Consultar Patrimônio</a></li>
                    @endcan

                    @can('create-patrimonio')
                    <li><a href="{{ route('patrimonios.create') }}"><i class="bi bi-person-plus-fill"></i>Cadastrar Patrimônio</a></li>
                    @endcan

                    @can('edit-patrimonio')
                    <li><a href="{{ route('patrimonios.index') }}"><i class="bi bi-pencil-square"></i>Alterações</a></li>
                    @endcan

                    @can('index-patrimonio')
                    <li><a href="{{ route('patrimonios.inventory') }}"><i class="bi bi-list-check"></i>Inventário</a></li>
                    @endcan

                    @can('create-user')
                    <li><a href="{{ route('user.create') }}"><i class="bi bi-person-plus-fill"></i>Indicadores</a></li>
                    @endcan

                    @can('create-user')
                    <li><a href="{{ route('user.create') }}"><i class="bi bi-person-plus-fill"></i>Relatórios</a></li>
                    @endcan

                    @can('create-user')
                    <li><a href="{{ route('user.create') }}"><i class="bi bi-person-plus-fill"></i>Configurações</a></li>
                    @endcan

                </ul>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    @if(auth()->check())
                        <div>{{ auth()->user()->name }}</div>
                        <div style="color: #94a3b8; font-size: 0.82rem;">Administrador</div>
                    @else
                        <div>Visitante</div>
                    @endif
                </div>
                @if(auth()->check())
                    <a href="{{ route('login.destroy') }}" class="btn-logout">Sair</a>
                @else
                    <a href="{{ route('login') }}" class="btn-logout">Login</a>
                @endif
            </div>
        </aside>

        <div class="main-content">
            <header class="topbar">
                <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
                <span class="page-title">Painel</span>
                <div class="topbar-actions"></div>
            </header>

            <div class="content">
                @yield('content')
            </div>

            @include('layouts.footer')
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menuToggle');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
            });
        }
    </script>
</body>
</html>
