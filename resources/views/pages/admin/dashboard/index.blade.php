@extends('layouts.master-admin')

@section('title', 'Dashboard')
@section('meta-tag')
    <meta name="description" content="Super Admin Dashboard">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('subtitle', 'Dashboard')

@section('content')
    <section class="section">
        {{-- STAT CARDS --}}
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-0">Customers</h6>
                                <h3 class="mb-0">128</h3>
                            </div>
                            <div class="avatar avatar-lg">
                            <span class="avatar-content bg-light-primary text-primary">
                                <i class="bi bi-people fs-4"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-0">Transporters</h6>
                                <h3 class="mb-0">32</h3>
                            </div>
                            <div class="avatar avatar-lg">
                            <span class="avatar-content bg-light-success text-success">
                                <i class="bi bi-truck fs-4"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-0">Surat Jalan Selesai</h6>
                                <h3 class="mb-0">87</h3>
                                <small class="text-muted">Year-to-date</small>
                            </div>
                            <div class="avatar avatar-lg">
                            <span class="avatar-content bg-light-info text-info">
                                <i class="bi bi-check2-circle fs-4"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-0">Surat Jalan Belum</h6>
                                <h3 class="mb-0">14</h3>
                                <small class="text-danger">Needs attention</small>
                            </div>
                            <div class="avatar avatar-lg">
                            <span class="avatar-content bg-light-danger text-danger">
                                <i class="bi bi-exclamation-triangle fs-4"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATUS + CHART --}}
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Status Ringkasan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-lg align-middle">
                                <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th class="text-center">Selesai</th>
                                    <th class="text-center">Belum</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="fw-bold">Surat Jalan</div>
                                        <small class="text-muted">Delivery order</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light-success text-success">87</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light-danger text-danger">14</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-bold">Surat Penugasan Transport</div>
                                        <small class="text-muted">Assignment order</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light-success text-success">52</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light-danger text-danger">9</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="p-3 border rounded-3">
                                    <div class="text-muted small">Penugasan Selesai</div>
                                    <div class="fw-bold fs-4">52</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 border rounded-3">
                                    <div class="text-muted small">Penugasan Belum</div>
                                    <div class="fw-bold fs-4">9</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Grafik Bulanan</h4>
                        <span class="badge bg-light-secondary text-dark">Static Demo</span>
                    </div>
                    <div class="card-body">
                        <div style="height: 280px;">
                            <canvas id="chartMonthly"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COMPARE CHART --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Perbandingan Surat Jalan vs Surat Penugasan</h4>
                    </div>
                    <div class="card-body">
                        <div style="height: 320px;">
                            <canvas id="chartCompare"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        $(document).ready(function () {
            // Static monthly data (Jan-Dec)
            const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            const suratJalan = [6, 7, 9, 8, 10, 11, 12, 9, 8, 7, 10, 12];
            const suratPenugasan = [3, 4, 5, 4, 6, 6, 7, 6, 5, 4, 6, 5];

            // Chart 1 (Line)
            const ctxMonthly = $('#chartMonthly')[0].getContext('2d');
            new Chart(ctxMonthly, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Surat Jalan', data: suratJalan, tension: 0.35 },
                        { label: 'Surat Penugasan', data: suratPenugasan, tension: 0.35 },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Chart 2 (Bar)
            const ctxCompare = $('#chartCompare')[0].getContext('2d');
            new Chart(ctxCompare, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Surat Jalan', data: suratJalan },
                        { label: 'Surat Penugasan', data: suratPenugasan },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        });
    </script>
@endpush
