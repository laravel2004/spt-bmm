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
                                            <span class="badge bg-light-success text-success">Open</span>
                                        @else
                                            <span class="badge bg-light-danger text-danger">Close</span>
                                        @endif
                                    </td>

                                    {{-- Status Delivery: pakai field take_assignment_date / take_assignment_by dari migration --}}
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
                                                @if(\Illuminate\Support\Facades\Route::has('superadmin.spt.show'))
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('superadmin.spt.show', $spt->id) }}">
                                                            <i class="bi bi-eye me-2"></i> Detail
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(\Illuminate\Support\Facades\Route::has('superadmin.spt.edit'))
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('superadmin.spt.edit', $spt->id) }}">
                                                            <i class="bi bi-pencil-square me-2"></i> Edit
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(\Illuminate\Support\Facades\Route::has('superadmin.spt.delete'))
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <button
                                                            type="button"
                                                            class="dropdown-item text-danger btn-delete-spt"
                                                            data-url="{{ route('superadmin.spt.delete', $spt->id) }}"
                                                            data-name="{{ $spt->spt_no ?? $spt->sppb_no ?? 'this SPT' }}"
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

            $(document).on('click', '.btn-delete-spt', function () {
                const url  = $(this).data('url');
                const name = $(this).data('name') || 'this SPT';

                Swal.fire({
                    title: 'Delete SPT?',
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
                                text: res?.message || 'SPT deleted successfully',
                                confirmButtonText: 'OK'
                            }).then(() => window.location.href = indexUrl);
                        },
                        error: function (xhr) {
                            const msg = xhr.responseJSON?.message || 'Failed to delete SPT';
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
