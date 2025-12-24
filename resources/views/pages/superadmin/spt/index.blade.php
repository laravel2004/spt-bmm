@extends('layouts.master-super')

@section('title', 'SPT Management')
@section('subtitle', 'SPT Management')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2">

                    <div>
                        <h4 class="mb-0">SPT Management</h4>
                        <p class="text-muted mb-0">
                            Total: <span class="fw-bold">{{ $spts->total() }}</span> SPT found.
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
                                    placeholder="Search spt_no / sppb_no / cust_code..."
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
                @if($spts->count() === 0)
                    <div class="alert alert-light-primary mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        No SPT found.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-lg align-middle">
                            <thead>
                            <tr>
                                <th style="width: 70px;">No</th>
                                <th>No. SPPB</th>
                                <th>No. SPT</th>
                                <th>Driver</th>
                                <th>No. Telp</th>
                                <th>Date SPT</th>
                                <th>Date Expired</th>
                                <th>Status</th>
                                <th>Status Delivery</th>
                                <th>Transit</th>
                                <th class="text-end" style="width: 120px;">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($spts as $i => $spt)
                                <tr>
                                    <td class="text-muted">{{ $spts->firstItem() + $i }}</td>

                                    <td>{{ $spt->sppb_no ?? '-' }}</td>

                                    <td>{{ $spt->spt_no ?? '-' }}</td>

                                    <td>{{ $spt->driver->fullname ?? '-' }}</td>

                                    <td>{{ $spt->phone ?? '-' }}</td>

                                    <td class="text-muted small">
                                        {{ $spt->spt_date ? \Illuminate\Support\Carbon::parse($spt->spt_date)->format('Y-m-d H:i') : '-' }}
                                    </td>

                                    <td class="text-muted small">
                                        {{ $spt->spt_expired_date ? \Illuminate\Support\Carbon::parse($spt->spt_expired_date)->format('Y-m-d H:i') : '-' }}
                                    </td>

                                    <td>
                                        @if((bool) $spt->status)
                                            <span class="badge bg-light-danger text-danger">Close</span>
                                        @else
                                            <span class="badge bg-light-success text-success">Open</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($spt->take_assignment_date)
                                            <span class="badge bg-light-info text-info">Assigned</span>
                                            <div class="text-muted small text-truncate" style="max-width: 180px;">
                                                {{ $spt->take_assignment_by ?? '-' }}
                                            </div>
                                        @else
                                            <span class="badge bg-light-secondary text-secondary">Not Assigned</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if((bool) $spt->is_transit)
                                            <span class="badge bg-light-warning text-warning">Yes</span>
                                        @else
                                            <span class="badge bg-light-secondary text-secondary">No</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">
                                                {{-- Show --}}
                                                @if(\Illuminate\Support\Facades\Route::has('superadmin.spt.show'))
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('superadmin.spt.show', $spt->id) }}">
                                                            <i class="bi bi-eye me-2"></i> Detail
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- Transit (POST /transit/{id}) --}}
                                                <li>
                                                    <button
                                                        type="button"
                                                        class="dropdown-item text-warning btn-transit-spt"
                                                        data-url="{{ route('superadmin.spt.transit', $spt->id) }}"
                                                        data-name="{{ $spt->spt_no ?? $spt->sppb_no ?? 'this SPT' }}"
                                                    >
                                                        <i class="bi bi-arrow-left-right me-2"></i> Transit
                                                    </button>
                                                </li>
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
                            Showing <b>{{ $spts->firstItem() }}</b> to <b>{{ $spts->lastItem() }}</b>
                            of <b>{{ $spts->total() }}</b> results
                        </div>

                        <div>
                            {{ $spts->links() }}
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

            $(document).on('click', '.btn-transit-spt', function () {
                const url  = $(this).data('url');
                const name = $(this).data('name') || 'this SPT';

                Swal.fire({
                    title: 'Set Transit?',
                    html: `Are you sure you want to set <b>${name}</b> as <b>Transit</b>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, transit',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: { _token: csrf },
                        success: function (res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res?.message || 'Transit updated successfully',
                                confirmButtonText: 'OK'
                            }).then(() => window.location.href = indexUrl);
                        },
                        error: function (xhr) {
                            const msg = xhr.responseJSON?.message || 'Failed to update transit';
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
