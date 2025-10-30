@extends('layouts.auth')

@section('content')
    <div class="container">
        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            @method('POST')

            <h1>Login</h1>
            <x-alert />

            <!-- Campo Email -->
            <div class="input-box">
                <input type="email" name="email" id="email" 
                       placeholder="Digite seu e-mail" value="{{ old('email') }}" required>
                <i class='bx bxs-user'></i>
            </div>

            <!-- Campo Senha -->
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Senha" required>
                <i class='bx bxs-lock-alt' role="button" onclick="togglePassword('password', this)"></i>
            </div>

            <!-- Lembrar-me / Esqueceu a senha -->
            <div class="remember-forgot">
                <label><input type="checkbox" name="remember"> Lembrar-me</label>
                <a href="#">Esqueceu a senha?</a>
            </div>

            <!-- Botão -->
            <button type="submit" class="btn">Entrar</button>

            <!-- Link Cadastro -->
            <div class="register-link">
                <p>Não tem uma conta? 
                    <a href="{{ route('login.create-user') }}">Registrar-se</a>
                </p>
            </div>
        </form>
    </div>

    <style>
        :root {
            --primary-color: #c41e3a;
            --primary-dark: #8b0000;
            --background-color: #f5e6d3;
            --text-color: #2c1810;
            --hover-color: #d64d4d;
        }

        body { 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #8b0000;
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 420px;
            background: var(--background-color);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        }

        .container h1 {
            font-size: 36px;
            text-align: center;
            margin-bottom: 40px;
            color: var(--primary-color);
        }

        .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            margin: 30px 0;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: 2px solid var(--primary-color);
            border-radius: 25px;
            outline: none;
            padding: 20px 45px 20px 20px;
            font-size: 16px;
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .input-box input:focus {
            border-color: var(--primary-dark);
        }

        .input-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: var(--primary-color);
            cursor: pointer;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            font-size: 14.5px;
            margin: 15px 0 25px;
            color: var(--text-color);
        }

        .remember-forgot label input {
            accent-color: var(--primary-color);
            margin-right: 4px;
        }

        .remember-forgot a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            height: 45px;
            background: var(--primary-color);
            border: none;
            outline: none;
            border-radius: 25px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14.5px;
            color: var(--text-color);
        }

        .register-link p a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link p a:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        function togglePassword(fieldId, icon) {
            const input = document.getElementById(fieldId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bxs-lock-alt", "bxs-lock-open-alt");
            } else {
                input.type = "password";
                icon.classList.replace("bxs-lock-open-alt", "bxs-lock-alt");
            }
        }
    </script>
@endsection
