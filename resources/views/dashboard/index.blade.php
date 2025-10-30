@extends('layouts.admin')

@section('content')
<main>
    {{-- CSS direto aqui dentro --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary-color: #c41e3a;
            --primary-dark: #8b0000;
            --background-color: #f5e6d3;
            --text-color: #2c1810;
            --hover-color: #d64d4d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: var(--background-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-title {
            text-align: center;
            color: var(--primary-color);
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .description {
            text-align: center;
            color: var(--text-color);
            font-size: 1.2rem;
            margin-bottom: 3rem;
            opacity: 0.8;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }

        section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        section h2 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .content p {
            color: var(--text-color);
            line-height: 1.6;
            text-align: justify;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .info-card {
            text-align: center;
            padding: 1.5rem;
            border-radius: 10px;
            background: var(--background-color);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
        }

        .info-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .info-card h3 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .info-card p {
            color: var(--text-color);
            font-size: 0.9rem;
        }

        .destaque-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .destaque-grid img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .destaque-grid img:hover {
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .destaque-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    {{-- Conteúdo --}}
    <h1 class="page-title">Bem-vindo ao Afro-Sarau 2025</h1>
    <p class="description">Celebrando nossa cultura e arte</p>

    <div class="container">
        <section class="sobre-sarau">
            <h2>Sobre o Sarau</h2>
            <div class="content">
                <p>O Afro-Sarau é um evento cultural que celebra a riqueza e diversidade da cultura afro-brasileira através da arte, música, dança e poesia. Um espaço de expressão, reconhecimento e valorização de nossa identidade.</p>
            </div>
        </section>

        <section class="mais-info">
            <h2>Programação</h2>
            <div class="info-grid">
                <div class="info-card">
                    <i class='bx bx-music'></i>
                    <h3>Música</h3>
                    <p>Apresentações musicais com ritmos africanos e afro-brasileiros</p>
                </div>
                <div class="info-card">
                    <i class='bx bx-book-open'></i>
                    <h3>Poesia</h3>
                    <p>Sarau de poesia com artistas locais</p>
                </div>
                <div class="info-card">
                    <i class='bx bx-movie-play'></i>
                    <h3>Dança</h3>
                    <p>Apresentações de dança contemporânea e tradicional</p>
                </div>
            </div>
        </section>

        <section class="destaques">
            <h2>Destaques</h2>
            <div class="destaque-grid">
                <img src="" alt="Apresentação Musical">
                <img src="" alt="Dança Tradicional">
                <img src="" alt="Artistas">
            </div>
        </section>
    </div>
</main>
@endsection
