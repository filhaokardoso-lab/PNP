@extends('layouts.admin')

@section('content')
<div class="dashboard-page">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --bg: #f4f6fb;
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --accent: #ef4444;
            --accent-dark: #dc2626;
            --shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        }

        .dashboard-page {
            width: 100%;
            min-height: calc(100vh - 5.5rem);
            padding: 1rem 2rem 2rem;
            background: var(--bg);
        }

        .dashboard-header {
            margin-bottom: 1.75rem;
        }

        .dashboard-header h1 {
            font-size: 2rem;
            margin: 0 0 0.25rem;
            color: var(--text);
        }

        .dashboard-header p {
            margin: 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-card .stat-label {
            color: var(--muted);
            font-size: 0.95rem;
            margin-top: 0.75rem;
        }

        .stat-card .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text);
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.5rem;
        }

        .chart-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            min-height: 360px;
        }

        .chart-card.full-width {
            grid-column: 1 / -1;
        }

        .chart-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .chart-card-header h2 {
            font-size: 1rem;
            margin: 0;
            color: var(--text);
        }

        .chart-card canvas {
            width: 100% !important;
            height: 320px !important;
        }

        .chart-empty {
            margin-top: 1rem;
            color: var(--muted);
            font-size: 0.95rem;
            text-align: center;
        }

        @media (max-width: 1024px) {
            .stats-grid,
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .dashboard-page {
                padding: 1rem;
            }

            .stat-card {
                padding: 1.25rem;
            }

            .chart-card {
                min-height: 300px;
                padding: 1.25rem;
            }
        }
    </style>

    <div class="dashboard-header">
        <h1>Painel de Indicadores</h1>
        <p>Os gráficos já estão prontos para receber dados. Preencha as informações para visualizar o desempenho do patrimônio.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ number_format($total, 0, ',', '.') }}</div>
            <div class="stat-label">Total de Patrimônios</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($ativos, 0, ',', '.') }}</div>
            <div class="stat-label">Ativos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($inativos, 0, ',', '.') }}</div>
            <div class="stat-label">Inativos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">R$ {{ number_format($valorTotal, 2, ',', '.') }}</div>
            <div class="stat-label">Valor Total (R$)</div>
        </div>
    </div>

    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-card-header">
                <h2>Patrimônios por Categoria</h2>
            </div>
            <canvas id="categoryChart"></canvas>
            @unless(count($categories) > 0)
                <div class="chart-empty">Sem dados no momento</div>
            @endunless
        </div>

        <div class="chart-card">
            <div class="chart-card-header">
                <h2>Patrimônios por Setor</h2>
            </div>
            <canvas id="sectorChart"></canvas>
            @unless(count($sectors) > 0)
                <div class="chart-empty">Sem dados no momento</div>
            @endunless
        </div>

        <div class="chart-card full-width">
            <div class="chart-card-header">
                <h2>Evolução do Patrimônio (Valor Total)</h2>
            </div>
            <canvas id="lineChart"></canvas>
            @unless(count($evolution) > 0)
                <div class="chart-empty">Sem dados no momento</div>
            @endunless
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const buildChart = (ctx, config) => {
        if (!ctx) return;
        return new Chart(ctx, config);
    };

    const basicOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { enabled: false },
        },
        scales: {
            x: { display: true, grid: { color: '#f1f5f9' } },
            y: { display: true, beginAtZero: true, grid: { color: '#f1f5f9' } },
        },
    };

    const categoryLabels = @json(array_keys($categories));
    const categoryData = @json(array_values($categories));
    const sectorLabels = @json(array_keys($sectors));
    const sectorData = @json(array_values($sectors));
    const evolutionLabels = @json(array_keys($evolution));
    const evolutionData = @json(array_values($evolution));

    buildChart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: ['#ef4444', '#f97316', '#eab308', '#10b981', '#3b82f6', '#8b5cf6', '#14b8a6']
            }]
        },
        options: Object.assign({}, basicOptions, {
            plugins: { legend: { display: categoryLabels.length > 0, position: 'bottom' }, tooltip: { enabled: true } }
        }),
    });

    buildChart(document.getElementById('sectorChart'), {
        type: 'bar',
        data: {
            labels: sectorLabels,
            datasets: [{
                label: 'Patrimônios por Setor',
                data: sectorData,
                backgroundColor: '#3b82f6'
            }]
        },
        options: Object.assign({}, basicOptions, {
            plugins: { legend: { display: true, position: 'bottom' }, tooltip: { enabled: true } },
            scales: { y: { beginAtZero: true }, x: { ticks: { autoSkip: false } } }
        }),
    });

    buildChart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: evolutionLabels,
            datasets: [{
                label: 'Valor Total por Mês (R$)',
                data: evolutionData,
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.15)',
                tension: 0.35,
                fill: true
            }]
        },
        options: Object.assign({}, basicOptions, {
            plugins: { legend: { display: true, position: 'bottom' }, tooltip: { enabled: true } },
            scales: { y: { beginAtZero: true, ticks: { callback: function(value) { return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2}); } } } }
        }),
    });
</script>
@endsection
