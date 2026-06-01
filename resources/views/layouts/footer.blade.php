<footer class="footer-pnp">
    <style>
        .footer-pnp {
            width: 100%;
            background: #0d1117;
            color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem 1rem;
            margin-top: 4rem;
        }

        .footer-pnp .footer-bar {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            padding: 1.5rem 2rem;
            background: #071018;
            border-radius: 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.25);
        }

        .footer-pnp .footer-items {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            flex: 1;
        }

        .footer-pnp .footer-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            min-width: 220px;
            max-width: 330px;
        }

        .footer-pnp .footer-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(236, 72, 153, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .footer-pnp .footer-copy {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .footer-pnp .footer-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .footer-pnp .footer-text {
            color: #cbd5e1;
            font-size: 0.93rem;
            line-height: 1.5;
            margin: 0;
        }

        .footer-pnp .footer-brand {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.35rem;
            min-width: 180px;
            text-align: right;
        }

        .footer-pnp .footer-brand .brand-name {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: 0.15em;
            color: #ef4444;
        }

        .footer-pnp .footer-brand .brand-subtitle {
            color: #cbd5e1;
            font-size: 0.92rem;
            line-height: 1.4;
            max-width: 220px;
        }

        @media (max-width: 980px) {
            .footer-pnp .footer-bar {
                flex-direction: column;
                align-items: stretch;
                padding: 1.25rem;
            }

            .footer-pnp .footer-items {
                justify-content: space-between;
            }

            .footer-pnp .footer-brand {
                align-items: flex-start;
                text-align: left;
            }
        }

        @media (max-width: 680px) {
            .footer-pnp .footer-bar {
                padding: 1rem;
            }

            .footer-pnp .footer-items {
                flex-direction: column;
                gap: 1rem;
            }

            .footer-pnp .footer-item {
                min-width: 100%;
            }

            .footer-pnp .footer-brand {
                align-items: flex-start;
                text-align: left;
                margin-top: 0.5rem;
            }
        }
    </style>

    <div class="footer-bar">
        <div class="footer-items">
            <div class="footer-item">
                <div class="footer-icon"><i class="bi bi-shield-lock-fill"></i></div>
                <div class="footer-copy">
                    <span class="footer-title">Segurança</span>
                    <p class="footer-text">Seus dados protegidos com segurança.</p>
                </div>
            </div>
            <div class="footer-item">
                <div class="footer-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                <div class="footer-copy">
                    <span class="footer-title">Controle</span>
                    <p class="footer-text">Gestão eficiente do seu patrimônio.</p>
                </div>
            </div>
            <div class="footer-item">
                <div class="footer-icon"><i class="bi bi-speedometer2"></i></div>
                <div class="footer-copy">
                    <span class="footer-title">Eficiência</span>
                    <p class="footer-text">Informações rápidas para melhores decisões.</p>
                </div>
            </div>
        </div>

        <div class="footer-brand">
            <span class="brand-name">SENAI</span>
            <span class="brand-subtitle">Serviço Nacional de Aprendizagem Industrial</span>
        </div>
    </div>
</footer>
