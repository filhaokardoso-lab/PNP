@extends('layouts.auth')

@section('content')
    <div class="login-layout">
        <div class="login-card">
            <div class="login-left">
                <div class="logo-wrap">
                    <img src="{{ asset('img/onaarandupng.png') }}" alt="Projeto PNP" class="logo-large">
                </div>
            </div>

            <div class="login-right">
                <form action="{{ route('login.store-user') }}" method="POST">
                    @csrf
                    @method('POST')

                    <h1 class="login-title">Cadastrar</h1>
                    <x-alert />

                    <div class="input-box">
                        <input type="text" name="name" id="name" placeholder="Nome completo" value="{{ old('name') }}" required>
                        <i class='bx bxs-user'></i>
                    </div>

                    <div class="input-box">
                        <input type="email" name="email" id="email" placeholder="E-mail" value="{{ old('email') }}" required>
                        <i class='bx bx-envelope'></i>
                    </div>

                    <div class="input-box">
                        <input type="password" name="password" id="password" placeholder="Senha (mín. 6)" required>
                        <i class='bx bxs-lock-alt' role="button" onclick="togglePassword('password', this)"></i>
                    </div>

                    <div class="input-box">
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar senha" required>
                        <i class='bx bxs-lock-alt' role="button" onclick="togglePassword('password_confirmation', this)"></i>
                    </div>

                    <div class="remember-forgot">
                        <label><input type="checkbox" required> Aceito os termos e condições</label>
                    </div>

                    <button type="submit" class="btn">Cadastrar</button>

                    <div class="register-link">
                        <p>Já tem uma conta? <a href="{{ route('login') }}">Fazer login</a></p>
                    </div>

                    <div class="guest-link"><a href="{{ route('dashboard.index') }}" class="guest-btn">Entrar sem conta</a></div>
                </form>
            </div>
        </div>
    </div>

    <style>
        :root{--primary:#c41e3a;--dark:#8b0000;--bg:#f5e6d3;--text:#2c1810}
        body{background:#8b0000;margin:0;padding:20px;display:flex;align-items:center;justify-content:center}
        .login-layout{width:100%;max-width:1000px}
        .login-card{display:flex;border-radius:12px;overflow:hidden;box-shadow:0 8px 30px rgba(0,0,0,.35)}
        .login-left{flex:1;background:var(--dark);display:flex;align-items:center;justify-content:center;padding:40px}
        .logo-wrap{max-width:420px;width:100%;text-align:center}
        .logo-large{width:100%;height:auto;max-width:420px}
        .login-right{flex:1;background:var(--bg);padding:48px 40px;display:flex;align-items:center;justify-content:center}
        form{width:100%;max-width:360px}
        .login-title{color:var(--primary);font-size:32px;margin:0 0 18px;font-weight:800;text-align:right}
        .input-box{position:relative;margin:18px 0}
        .input-box input{width:100%;padding:14px 18px;border-radius:12px;border:2px solid var(--primary);background:transparent;color:var(--text);outline:none}
        .input-box i{position:absolute;right:12px;top:50%;transform:translateY(-50%);color:var(--primary)}
        .remember-forgot{display:flex;justify-content:flex-start;font-size:14px;margin:12px 0;color:var(--text)}
        .btn{width:100%;padding:12px;border-radius:10px;border:none;background:var(--primary);color:#fff;font-weight:700;margin-top:8px}
        .register-link{margin-top:14px;text-align:center;color:var(--text)}
        .register-link a{color:var(--primary);font-weight:700}
        .guest-link{margin-top:10px;text-align:center}
        .guest-btn{display:inline-block;padding:8px 16px;border-radius:10px;border:2px solid var(--primary);color:var(--primary);text-decoration:none;font-weight:700;background:transparent}
        .guest-btn:hover{background:var(--primary);color:#fff}

        @media(max-width:880px){
            .login-card{flex-direction:column}
            .login-left{padding:28px}
            .login-right{padding:28px}
            .login-title{text-align:center}
        }
    </style>

    <script>
        function togglePassword(fieldId, icon){const input=document.getElementById(fieldId);if(input.type==='password'){input.type='text';icon.classList.replace('bxs-lock-alt','bxs-lock-open-alt')}else{input.type='password';icon.classList.replace('bxs-lock-open-alt','bxs-lock-alt')}}
    </script>
@endsection
