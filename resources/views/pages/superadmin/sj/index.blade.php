@extends('layouts.master-super')

@section('title', 'SJ Management')
@section('subtitle', 'SJ Management')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2">

                    <div>
                        <h4 class="mb-0">SJ Management</h4>
                        <p class="text-muted mb-0">
                            Total: <span class="fw-bold">{{ $sjs->total() }}</span> SJ found.
                        </p>
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2">
                        <form method="GET" action="{{ url()->current() }}" class="d-flex flex-column flex-md-row gap-2">
                            <div class="input-group input-group-sm" style="min-width: 260px; max-height: 60px;">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="search"
                                    placeholder="Search sj_no / spt_no / cust_code / item_code..."
                                    value="{{ request('search') }}"
                                    autocomplete="off"
                                />

                                @if(request()->filled('search') || request()->filled('perPage'))
                                    <a href="{{ url()->current() }}" class="btn btn-light">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                @endif
                            </div>

                            <select name="perPage" class="form-select form-select-sm"
                                    style="min-width: 110px; max-height: 60px;"
                                    onchange="this.form.submit()">
                                @foreach([10, 20, 50, 100] as $n)
                                    <option value="{{ $n }}" @selected((int)request('perPage', 10) === $n)>
                                        {{ $n }}/page
                                    </option>
                                @endforeach
                            </select>

                            <button class="btn btn-primary btn-sm" type="submit" style="max-height: 60px;">
                                <i class="bi bi-funnel me-1"></i>
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            <div class="card-body">
                @if($sjs->count() === 0)
                    <div class="alert alert-light-primary mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        No SJ found.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-lg align-middle">
                            <thead>
                            <tr>
                                <th style="width: 70px;">No</th>
                                <th>SJ No</th>
                                <th>SJ Date</th>
                                <th>SPT No</th>
                                <th>Customer</th>
                                <th>Transportir</th>
                                <th>Driver</th>
                                <th>Vehicle</th>
                                <th>Qty</th>
                                <th>Transit</th>
                                <th>Status</th>
                                <th class="text-end" style="width: 120px;">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($sjs as $i => $sj)
                                <tr>
                                    <td class="text-muted">{{ $sjs->firstItem() + $i }}</td>

                                    <td>
                                        <div class="fw-semibold">{{ $sj->sj_no ?? '-' }}</div>
                                        <div class="text-muted small text-truncate" style="max-width: 220px;">
                                            {{ $sj->item_code ?? '-' }} — {{ $sj->item_name ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="text-muted small">
                                        {{ $sj->sj_date ? \Illuminate\Support\Carbon::parse($sj->sj_date)->format('Y-m-d H:i') : '-' }}
                                    </td>

                                    <td>{{ $sj->spt_no ?? '-' }}</td>

                                    <td>
                                        <div class="fw-semibold">{{ $sj->cust_name ?? '-' }}</div>
                                        <div class="text-muted small">{{ $sj->cust_code ?? '-' }}</div>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">{{ $sj->transportir_name ?? '-' }}</div>
                                        <div class="text-muted small">{{ $sj->transportir_code ?? '-' }}</div>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">{{ $sj->driver->fullname ?? '-' }}</div>
                                        <div class="text-muted small">{{ $sj->phone ?? '-' }}</div>
                                    </td>

                                    <td>{{ $sj->vehicle_type ?? '-' }}</td>

                                    <td>
                                        <div class="fw-semibold">{{ $sj->qty ?? '-' }}</div>
                                        <div class="text-muted small">SPPB: {{ $sj->qty_sppb ?? '-' }}</div>
                                    </td>

                                    <td>
                                        @if((bool) $sj->is_transit)
                                            <span class="badge bg-light-warning text-warning">Yes</span>
                                        @else
                                            <span class="badge bg-light-secondary text-secondary">No</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if((bool) $sj->status)
                                            <span class="badge bg-light-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-light-danger text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if(\Illuminate\Support\Facades\Route::has('superadmin.mob-sj.show'))
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('superadmin.mob-sj.show', $sj->id) }}">
                                                            <i class="bi bi-eye me-2"></i> Detail
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(\Illuminate\Support\Facades\Route::has('superadmin.mob-sj.edit'))
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('superadmin.mob-sj.edit', $sj->id) }}">
                                                            <i class="bi bi-pencil-square me-2"></i> Edit
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(\Illuminate\Support\Facades\Route::has('superadmin.mob-sj.delete'))
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <button
                                                            type="button"
                                                            class="dropdown-item text-danger btn-delete-sj"
                                                            data-url="{{ route('superadmin.mob-sj.delete', $sj->id) }}"
                                                            data-name="{{ $sj->sj_no ?? $sj->spt_no ?? 'this SJ' }}"
                                                        >
                                                            <i class="bi bi-trash me-2"></i> Delete
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mt-3">
                        <div class="text-muted small">
                            Showing <b>{{ $sjs->firstItem() }}</b> to <b>{{ $sjs->lastItem() }}</b>
                            of <b>{{ $sjs->total() }}</b> results
                        </div>

                        <div>
                            {{ $sjs->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            const indexUrl = @json(url()->current());
            const csrf = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

            $(document).on('click', '.btn-delete-sj', function () {
                const url  = $(this).data('url');
                const name = $(this).data('name') || 'this SJ';

                Swal.fire({
                    title: 'Delete SJ?',
                    html: `Are you sure you want to delete <b>${name}</b>?<br><small class="text-muted">This action cannot be undone.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: { _token: csrf, _method: 'DELETE' },
                        success: function (res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: res?.message || 'SJ deleted successfully',
                                confirmButtonText: 'OK'
                            }).then(() => window.location.href = indexUrl);
                        },
                        error: function (xhr) {
                            const msg = xhr.responseJSON?.message || 'Failed to delete SJ';
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: msg,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
            });
        });
    </script>
@endpush
