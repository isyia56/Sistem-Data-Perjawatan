@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        border-radius: 12px;
        border: none;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Dashboard</h4>
        <small class="text-muted">Selamat datang, {{ auth()->user()->name }}</small>
    </div>
    <small class="text-muted">{{ now()->format('d M Y') }}</small>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-label-primary">
                    <i class="bx bx-file text-primary"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Jumlah Waran</small>
                    <h4 class="fw-bold mb-0">{{ $totalWaran }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-label-success">
                    <i class="bx bx-trending-up text-success"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Waran Lebih</small>
                    <h4 class="fw-bold mb-0 text-success">{{ $totalLebih }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-label-danger">
                    <i class="bx bx-trending-down text-danger"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Waran Kurang</small>
                    <h4 class="fw-bold mb-0 text-danger">{{ $totalKurang }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-label-info">
                    <i class="bx bx-check-circle text-info"></i>
                </div>
                <div>
                    <small class="text-muted d-block">Waran Seimbang</small>
                    <h4 class="fw-bold mb-0 text-info">{{ $totalSeimbang }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row g-3 mb-4">

    {{-- Gauge Chart - Status --}}
    <div class="col-12 col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Status Waran</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center gap-3">
                <div style="position:relative; width:180px; height:180px;">
                    <canvas id="gaugeChart" width="180" height="180"></canvas>
                    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-40%); text-align:center;">
                        <h3 class="fw-bold mb-0" id="gaugeValue">0%</h3>
                        <small class="text-muted">Seimbang</small>
                    </div>
                </div>
                <div class="d-flex gap-3 flex-wrap justify-content-center">
                    <small><span class="badge bg-success me-1">&nbsp;</span>Lebih: {{ $totalLebih }}</small>
                    <small><span class="badge bg-danger me-1">&nbsp;</span>Kurang: {{ $totalKurang }}</small>
                    <small><span class="badge bg-info me-1">&nbsp;</span>Seimbang: {{ $totalSeimbang }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Bar Chart - By Program --}}
    <div class="col-12 col-md-8">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Waran Mengikut Program</h5>
            </div>
            <div class="card-body">
                <canvas id="programChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- Recent Waran Table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Waran Terbaharu</h5>
        <a href="{{ route('waran.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>No. Waran</th>
                    <th>Jenis</th>
                    <th>Aktiviti</th>
                    <th>Penempatan</th>
                    <th class="text-center">J</th>
                    <th class="text-center">I</th>
                    <th class="text-center">K</th>
                    <th class="text-center">Status</th>
                    <th>Tarikh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentWarans as $waran)
                @php
                    $status = $waran->status_jik;
                    $badgeClass = match($status) {
                        'Lebih' => 'bg-label-success',
                        'Kurang' => 'bg-label-danger',
                        'Seimbang' => 'bg-label-info',
                        default => 'bg-label-secondary',
                    };
                    $borderColor = match($status) {
                        'Lebih' => '#198754',
                        'Kurang' => '#dc3545',
                        'Seimbang' => '#0dcaf0',
                        default => '#dee2e6',
                    };
                @endphp
                <tr style="border-left: 3px solid {{ $borderColor }};">
                    <td>
                        <a href="{{ route('waran.show', $waran) }}" class="fw-semibold text-primary text-decoration-none">
                            {{ $waran->no_waran }}
                        </a>
                    </td>
                    <td>
                        @if($waran->jenis === 'tambah')
                            <span class="badge bg-label-success">Tambah</span>
                        @else
                            <span class="badge bg-label-warning">Tolak</span>
                        @endif
                    </td>
                    <td><small class="text-muted">{!! Str::limit($waran->aktiviti_list ?? '-', 40) !!}</small></td>
                    <td><small class="text-muted">{!! Str::limit($waran->penempatan_list ?? '-', 40) !!}</small></td>
                    <td class="text-center fw-semibold">{{ $waran->jik }}</td>
                    <td class="text-center text-success fw-semibold">{{ $waran->isi_count }}</td>
                    <td class="text-center fw-semibold {{ $waran->kosong_count < 0 ? 'text-danger' : ($waran->kosong_count > 0 ? 'text-warning' : 'text-muted') }}">
                        {{ $waran->kosong_count }}
                    </td>
                    <td class="text-center"><span class="badge {{ $badgeClass }}">{{ $status }}</span></td>
                    <td><small class="text-muted">{{ $waran->created_at->format('d/m/Y') }}</small></td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">Tiada waran ditemui.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark-style');
    const textColor = isDark ? '#a6adc8' : '#566a7f';
    const gridColor = isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)';

    const seimbangPct = {{ $totalWaran > 0 ? round(($totalSeimbang / $totalWaran) * 100) : 0 }};
    new Chart(document.getElementById('gaugeChart'), {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [seimbangPct, 100 - seimbangPct],
                backgroundColor: ['#17a2b8', isDark ? '#3b3b5c' : '#f0f0f0'],
                borderWidth: 0,
                circumference: 270,
                rotation: 225,
            }]
        },
        options: {
            responsive: false,
            cutout: '75%',
            plugins: { legend: { display: false }, tooltip: { enabled: false } },
            animation: {
                onProgress: function(animation) {
                    const progress = animation.currentStep / animation.numSteps;
                    const current = Math.round(seimbangPct * progress);
                    document.getElementById('gaugeValue').textContent = current + '%';
                }
            }
        }
    });

    new Chart(document.getElementById('programChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($waranByProgram->pluck('desc_program')) !!},
            datasets: [{
                label: 'Jumlah Waran',
                data: {!! json_encode($waranByProgram->pluck('waran_count')) !!},
                backgroundColor: '#696cff',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: textColor, stepSize: 1 },
                    grid: { color: gridColor }
                },
                x: {
                    ticks: { color: textColor },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush