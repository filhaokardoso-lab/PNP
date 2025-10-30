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
</head>
<body>
    
    <header class="text-bg-dark d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
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



          <li><a href="{{ route('user.galeria') }}" class="nav-link px-2">Galeria</a></li>
          <li><a href="{{ route('user.videos') }}" class="nav-link px-2">Vídeos</a></li>
          <li><a href="{{ route('user.comentarios') }}" class="nav-link px-2">Comentários</a></li>
        </ul>
  
        <div class="col-md-3 text-end">
           <span class="small">Usuário Logado: {{ auth()->user()->name }}</span>
           <a href="{{ route('login.destroy') }}" class="btn btn-outline-light me-2">Sair</a>
        </div>
      </header>

      <div class="container">
          @yield('content')
      </div>
</body>
</html>
