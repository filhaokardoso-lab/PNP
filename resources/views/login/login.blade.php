@extends('layouts.auth')

@section('content')
<div class="page-bg">
  <div class="bg-circles">
    <div class="bg-c1"></div>
    <div class="bg-c2"></div>
    <div class="bg-c3"></div>
    <div class="bg-c4"></div>
    <div class="bg-dot" style="top:15%;left:8%"></div>
    <div class="bg-dot" style="top:40%;left:4%"></div>
    <div class="bg-dot" style="top:70%;left:12%"></div>
    <div class="bg-dot" style="top:25%;right:6%"></div>
    <div class="bg-dot" style="top:60%;right:10%"></div>
    <div class="bg-dot" style="bottom:18%;right:5%"></div>
  </div>

  <div class="login-card">

    {{-- ───── LEFT PANEL ───── --}}
    <div class="left-panel">
      <div class="left-geo">
        <div class="geo-stripe geo-s1"></div>
        <div class="geo-stripe geo-s2"></div>
        <div class="geo-stripe geo-s3"></div>
        <div class="geo-circle gc1"></div>
        <div class="geo-circle gc2"></div>
        <div class="geo-circle gc3"></div>
        <div class="geo-dot-grid">
          @for ($i = 0; $i < 30; $i++)
            <div class="gdot"></div>
          @endfor
        </div>
      </div>

      <div class="brand-top">
        <div class="senai-wordmark">SENAI</div>
        <div class="senai-tagline">Sistema de Patrimônios</div>
        <div class="senai-sub">Gestão e Controle de Ativos</div>
      </div>

      <div class="stats-row">
        <div class="stat-card">
          <div class="stat-num">4.8k</div>
          <div class="stat-label">Ativos Cadastrados</div>
        </div>
        <div class="stat-card">
          <div class="stat-num">98%</div>
          <div class="stat-label">Disponibilidade</div>
        </div>
        <div class="stat-card">
          <div class="stat-num">127</div>
          <div class="stat-label">Usuários Ativos</div>
        </div>
        <div class="stat-card">
          <div class="stat-num">24/7</div>
          <div class="stat-label">Monitoramento</div>
        </div>
      </div>

      <div class="feature-list">
        <div class="feat-item">
          <div class="feat-icon"><i class="bi bi-pc-display"></i></div>
          Controle de equipamentos e inventário
        </div>
        <div class="feat-item">
          <div class="feat-icon"><i class="bi bi-shield-check"></i></div>
          Acesso seguro e auditável
        </div>
        <div class="feat-item">
          <div class="feat-icon"><i class="bi bi-bar-chart-line"></i></div>
          Relatórios e dashboards em tempo real
        </div>
      </div>
    </div>

    {{-- ───── RIGHT PANEL ───── --}}
    <div class="right-panel">
      <form action="{{ route('login.process') }}" method="POST">
        @csrf
        @method('POST')

        <div class="form-header">
          <div class="form-eyebrow">Bem-vindo de volta</div>
          <div class="form-title">Acesse<br>sua conta</div>
          <div class="form-sub">Entre com suas credenciais para acessar o sistema de patrimônios.</div>
        </div>

        {{-- Alerts globais --}}
        <x-alert />

        @if ($errors->any())
          <div class="alert-box alert-error">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if (session('status'))
          <div class="alert-box alert-success">{{ session('status') }}</div>
        @endif

        {{-- E-mail --}}
        <div class="field-group">
          <label class="field-label" for="email">Usuário / E-mail</label>
          <div class="input-wrap">
            <input
              id="email"
              class="field-input @error('email') input-error @enderror"
              type="email"
              name="email"
              placeholder="Digite seu usuário"
              value="{{ old('email') }}"
              required
              autocomplete="email"
            >
            <span class="input-ico"><i class="bi bi-person-fill"></i></span>
          </div>
          @error('email')
            <span class="field-error">{{ $message }}</span>
          @enderror
        </div>

        {{-- Senha --}}
        <div class="field-group">
          <label class="field-label" for="password">Senha</label>
          <div class="input-wrap">
            <input
              id="password"
              class="field-input @error('password') input-error @enderror"
              type="password"
              name="password"
              placeholder="Digite sua senha"
              required
              autocomplete="current-password"
            >
            <span
              class="input-ico"
              role="button"
              tabindex="0"
              aria-label="Mostrar/ocultar senha"
              onclick="togglePassword('password', this)"
              onkeydown="if(event.key==='Enter') togglePassword('password', this)"
            >
              <i id="eye-icon" class="bi bi-eye-fill"></i>
            </span>
          </div>
          @error('password')
            <span class="field-error">{{ $message }}</span>
          @enderror
        </div>

        {{-- Lembrar + Esqueceu --}}
        <div class="remember-row">
          <label class="remember-label">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            Lembrar-me
          </label>
          <a href="#" class="forgot">Esqueceu sua senha?</a>
        </div>

        <button type="submit" class="btn-submit">Entrar</button>

        <div class="divider">ou</div>

        <a href="{{ route('dashboard.index') }}" class="btn-guest">
          <i class="bi bi-person-slash" style="margin-right:8px;font-size:15px;color:#bbb"></i>
          Entrar sem conta
        </a>

        <div class="reg-row">
          Não tem uma conta? <a href="{{ route('login.create-user') }}">Cadastrar agora</a>
        </div>
      </form>

      <div class="right-footer">
        <span class="footer-logo">SENAI</span>
        <div class="footer-sep"></div>
        <span class="footer-text">Serviço Nacional de<br>Aprendizagem Industrial</span>
      </div>
    </div>

  </div>
</div>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --red:      #cc0000;
    --red-dk:   #a80000;
    --red-xdk:  #3a0000;
    --white:    #ffffff;
    --border:   #e8e8e8;
    --text:     #111111;
    --muted:    #888888;
    --radius:   10px;
  }

  html, body {
    height: 100%;
    font-family: 'Montserrat', 'Inter', system-ui, sans-serif;
  }

  body {
    background: #0f0f0f;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 32px 20px;
  }

  /* ── Page background ── */
  .page-bg {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
  }

  .bg-circles { position: fixed; inset: 0; pointer-events: none; overflow: hidden; z-index: 0; }
  .bg-c1 { position: absolute; width: 500px; height: 500px; border-radius: 50%; border: 1px solid rgba(204,0,0,0.12); top: -150px; left: -150px; }
  .bg-c2 { position: absolute; width: 360px; height: 360px; border-radius: 50%; border: 1px solid rgba(204,0,0,0.08); top: -80px; left: -80px; }
  .bg-c3 { position: absolute; width: 600px; height: 600px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.03); bottom: -200px; right: -200px; }
  .bg-c4 { position: absolute; width: 200px; height: 200px; border-radius: 50%; background: rgba(204,0,0,0.06); bottom: 60px; right: 80px; }
  .bg-dot { position: absolute; width: 3px; height: 3px; border-radius: 50%; background: rgba(204,0,0,0.4); }

  /* ── Card ── */
  .login-card {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: 1.15fr 1fr;
    width: 100%;
    max-width: 900px;
    min-height: 580px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.06);
  }

  /* ── LEFT ── */
  .left-panel {
    background: var(--red);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 44px 40px 36px;
  }

  .left-geo { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
  .geo-stripe { position: absolute; background: rgba(0,0,0,0.12); transform-origin: center; }
  .geo-s1 { width: 200%; height: 80px; top: 120px; left: -50%; transform: rotate(-12deg); }
  .geo-s2 { width: 200%; height: 40px; top: 180px; left: -50%; transform: rotate(-12deg); background: rgba(0,0,0,0.08); }
  .geo-s3 { width: 200%; height: 120px; bottom: 100px; left: -50%; transform: rotate(-12deg); }
  .geo-circle { position: absolute; border-radius: 50%; border: 2px solid rgba(255,255,255,0.12); }
  .gc1 { width: 300px; height: 300px; top: -80px; right: -80px; }
  .gc2 { width: 180px; height: 180px; top: -20px; right: -20px; border-color: rgba(255,255,255,0.08); }
  .gc3 { width: 220px; height: 220px; bottom: -60px; left: -60px; }
  .geo-dot-grid { position: absolute; bottom: 20px; right: 20px; display: grid; grid-template-columns: repeat(6,1fr); gap: 7px; opacity: 0.18; }
  .gdot { width: 4px; height: 4px; border-radius: 50%; background: #fff; }

  .brand-top { position: relative; z-index: 1; }
  .senai-wordmark { font-size: 48px; font-weight: 900; color: #fff; letter-spacing: 4px; line-height: 1; text-shadow: 0 2px 20px rgba(0,0,0,0.3); }
  .senai-tagline { color: rgba(255,255,255,0.85); font-size: 16px; font-weight: 600; margin-top: 8px; }
  .senai-sub { color: rgba(255,255,255,0.6); font-size: 11px; font-weight: 500; margin-top: 4px; letter-spacing: 2px; text-transform: uppercase; }

  .stats-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; position: relative; z-index: 1; }
  .stat-card { background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 14px 16px; }
  .stat-num { font-size: 22px; font-weight: 800; color: #fff; line-height: 1; }
  .stat-label { font-size: 10px; color: rgba(255,255,255,0.65); font-weight: 600; margin-top: 4px; text-transform: uppercase; letter-spacing: 1px; }

  .feature-list { display: flex; flex-direction: column; gap: 10px; position: relative; z-index: 1; }
  .feat-item { display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.88); font-size: 12.5px; font-weight: 500; }
  .feat-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.14); display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.15); color: #fff; }

  /* ── RIGHT ── */
  .right-panel {
    background: var(--white);
    display: flex;
    flex-direction: column;
    padding: 44px 44px 36px;
  }

  form { flex: 1; }

  .form-header { margin-bottom: 28px; }
  .form-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--red); margin-bottom: 6px; }
  .form-title { font-size: 26px; font-weight: 800; color: #111; line-height: 1.1; }
  .form-sub { font-size: 12.5px; color: #888; margin-top: 6px; line-height: 1.5; }

  .alert-box { border-radius: var(--radius); padding: 10px 14px; font-size: 12.5px; margin-bottom: 14px; }
  .alert-error { background: #fff0f0; border: 1px solid #f5c6c6; color: #a00; }
  .alert-error ul { padding-left: 16px; }
  .alert-success { background: #f0fff4; border: 1px solid #b2dfdb; color: #1a6e40; }

  .field-group { margin-bottom: 16px; }
  .field-label { display: block; font-size: 11.5px; font-weight: 700; color: #333; margin-bottom: 6px; letter-spacing: 0.3px; }

  .input-wrap { position: relative; }
  .field-input {
    width: 100%; height: 46px;
    padding: 0 42px 0 14px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    background: #fafafa;
    font-size: 13.5px;
    font-family: 'Montserrat', sans-serif;
    color: var(--text);
    outline: none;
    transition: border-color .2s, box-shadow .2s, background .2s;
  }
  .field-input::placeholder { color: #c0c0c0; font-size: 13px; }
  .field-input:focus { border-color: var(--red); background: #fff; box-shadow: 0 0 0 3px rgba(204,0,0,0.09); }
  .field-input.input-error { border-color: #e05050; background: #fff8f8; }

  .input-ico { position: absolute; right: 13px; top: 50%; transform: translateY(-50%); color: #ccc; font-size: 17px; cursor: pointer; transition: color .2s; user-select: none; }
  .input-ico:hover { color: var(--red); }

  .field-error { display: block; font-size: 11px; color: #c0392b; margin-top: 4px; }

  .remember-row { display: flex; align-items: center; justify-content: space-between; margin: 2px 0 20px; }
  .remember-label { display: flex; align-items: center; gap: 8px; font-size: 12.5px; color: #555; cursor: pointer; }
  .remember-label input { width: 15px; height: 15px; accent-color: var(--red); cursor: pointer; }
  .forgot { font-size: 12.5px; color: var(--red); font-weight: 700; text-decoration: none; }
  .forgot:hover { text-decoration: underline; }

  .btn-submit {
    width: 100%; height: 48px;
    background: var(--red); color: #fff; border: none;
    border-radius: var(--radius);
    font-size: 14px; font-weight: 800;
    font-family: 'Montserrat', sans-serif;
    letter-spacing: 1.5px; text-transform: uppercase;
    cursor: pointer;
    transition: background .2s, transform .15s, box-shadow .2s;
    box-shadow: 0 6px 20px rgba(204,0,0,0.3);
  }
  .btn-submit:hover { background: var(--red-dk); transform: translateY(-1px); box-shadow: 0 10px 28px rgba(204,0,0,0.38); }
  .btn-submit:active { transform: translateY(0); }

  .divider { display: flex; align-items: center; gap: 12px; margin: 16px 0; color: #ccc; font-size: 11px; font-weight: 600; letter-spacing: 1px; }
  .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #ebebeb; }

  .btn-guest {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 42px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    color: #666; font-size: 13px; font-weight: 600;
    font-family: 'Montserrat', sans-serif;
    background: transparent; cursor: pointer;
    transition: border-color .2s, color .2s, background .2s;
    text-decoration: none;
  }
  .btn-guest:hover { border-color: var(--red); color: var(--red); background: #fff5f5; }

  .reg-row { text-align: center; margin-top: 14px; font-size: 12.5px; color: #888; }
  .reg-row a { color: var(--red); font-weight: 700; text-decoration: none; }
  .reg-row a:hover { text-decoration: underline; }

  .right-footer { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: auto; padding-top: 20px; border-top: 1px solid #f0f0f0; }
  .footer-logo { font-size: 15px; font-weight: 900; letter-spacing: 2px; color: var(--red); }
  .footer-sep { width: 1px; height: 20px; background: #e0e0e0; }
  .footer-text { font-size: 10px; color: #bbb; line-height: 1.3; font-weight: 500; }

  /* ── Responsive ── */
  @media (max-width: 750px) {
    .login-card { grid-template-columns: 1fr; }
    .left-panel { min-height: 220px; padding: 28px 24px 20px; }
    .stats-row { grid-template-columns: repeat(4, 1fr); }
    .right-panel { padding: 28px 24px; }
  }

  @media (max-width: 520px) {
    body { padding: 16px; }
    .senai-wordmark { font-size: 36px; }
    .stats-row { grid-template-columns: 1fr 1fr; }
    .form-title { font-size: 22px; }
    .login-card { border-radius: 14px; }
  }
</style>

<script>
  function togglePassword(fieldId, iconWrapper) {
    const input = document.getElementById(fieldId);
    const icon = iconWrapper.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
    } else {
      input.type = 'password';
      icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
    }
  }
</script>
@endsection