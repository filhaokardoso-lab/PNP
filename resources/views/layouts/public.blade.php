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
      header {
        background-color: #212529;
        color: #fff;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 2rem;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        z-index: 50;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        transition: transform 0.3s ease, opacity 0.3s ease;
        opacity: 1;
        pointer-events: auto;
      }

      header.hidden {
        transform: translateY(-100%);
        opacity: 0;
        pointer-events: none;
      }

      @media (max-width: 768px) {
        header {
          flex-direction: column;
          gap: 0.5rem;
          padding: 0.75rem 1rem;
        }
      }
    </style>
</head>
<body>
    
    <header id="header" class="text-bg-dark d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 border-bottom">
        <div class="col-md-3 mb-2 mb-md-0">
          <a href="" class="d-inline-flex link-body-emphasis text-decoration-none">
            <img src="{{ asset('images/SESISENAI.png') }}" alt="Logo SENAI" width="120" height="auto" class="img-fluid">
          </a>
        </div>
  
        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
          <li><a href="{{ route('dashboard.index') }}" class="nav-link px-2 link-secondary">Home</a></li>

          @can('index-user')
          <li><a href="{{ route('user.index') }}" class="nav-link px-2">Usuários</a></li>    
          @endcan
          
          @can('index-role')
          <li><a href="{{ route('role.index') }}" class="nav-link px-2">Perfis</a></li>    
          @endcan
          
          @can('create-user')
          <li><a href="{{ route('user.create') }}" class="nav-link px-2">Cadastrar</a></li>    
          @endcan

          @can('profile-user')
          <li><a href="{{ route('user.profile') }}" class="nav-link px-2">Perfil</a></li>    
          @endcan

          @can('index-foto')
          <li><a href="{{ route('fotos.index') }}" class="nav-link px-2">Imagens</a></li>
          @endcan



        </ul>
  
        <div class="col-md-3 text-end">
          @if(auth()->check())
            <span class="small">Usuário Logado: {{ auth()->user()->name }}</span>
            <a href="{{ route('login.destroy') }}" class="btn btn-outline-light me-2">Sair</a>
          @else
            <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
          @endif
        </div>
      </header>

        <div class="container" style="margin-top: 70px;">
          @yield('content')
      </div>

      @include('layouts.footer')
      <script>
        const header = document.getElementById('header');
        let lastScrollY = 0;
        let scrollDirection = 'up';

        window.addEventListener('scroll', () => {
          const currentScrollY = window.scrollY;

          if (currentScrollY > lastScrollY) {
            scrollDirection = 'down';
          } else {
            scrollDirection = 'up';
          }

          if (scrollDirection === 'down' && currentScrollY > 100) {
            header.classList.add('hidden');
          } else {
            header.classList.remove('hidden');
          }

          lastScrollY = currentScrollY;
        });
      </script>
</body>
</html>
