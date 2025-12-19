@extends('layouts.master-super')

@section('title', 'Mapping Transportir Management')
@section('subtitle', 'Mapping Transportir Management')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2">

                    <div>
                        <h4 class="mb-0">Mapping Transportir Management</h4>
                        <p class="text-muted mb-0">
                            Total: <span class="fw-bold">{{ $mappings->total() }}</span> mapping found.
                        </p>
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2">

                        <form method="GET" action="{{ url()->current() }}" class="d-flex flex-column flex-md-row gap-2">
                            {{-- SEARCH (slim) --}}
                            <div class="input-group input-group-sm" style="min-width: 320px; max-height: 60px;">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="search"
                                    placeholder="Search driver / phone / transportir..."
                                    value="{{ request('search') }}"
                                    autocomplete="off"
                                />

                                @if(request()->filled('search') || request()->filled('perPage'))
                                    <a href="{{ url()->current() }}" class="btn btn-light">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                @endif
                            </div>

                            <select name="perPage"
                                    class="form-select form-select-sm"
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

                        {{-- Sesuaikan route name ini dengan route kamu --}}
                        <a href="{{ route('superadmin.mapping-transportir.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Mapping
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if($mappings->count() === 0)
                    <div class="alert alert-light-primary mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        No mapping found.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-lg align-middle">
                            <thead>
                            <tr>
                                <th style="width: 70px;">No</th>
                                <th>Driver</th>
                                <th>Phone Driver</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>No. KTP</th>
                                <th>Driver Status</th>
                                <th>Transportir Code</th>
                                <th>Transportir Name</th>
                                <th>Transportir Status</th>
                                <th>Status Mapping</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th class="text-end" style="width: 120px;">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($mappings as $i => $m)
                                @php
                                    $driver = $m->driver;
                                    $transportir = $m->transportir;

                                    $displayName = trim(($driver->fullname ?? '-') . ' - ' . ($transportir->code ?? '-'));
                                @endphp

                                <tr>
                                    <td class="text-muted">{{ $mappings->firstItem() + $i }}</td>

                                    <td>{{ $driver->fullname ?? '-' }}</td>
                                    <td class="text-muted">{{ $driver->phone_num ?? '-' }}</td>
                                    <td class="text-muted"> {{ $driver->gender  ?? '-'}}</td>
                                    <td class="text-muted">
                                        {{ $driver->birthday ? \Carbon\Carbon::parse($driver->birthday)->age . ' tahun' : '-' }}
                                    </td>
                                    <td class="text-muted">{{ $driver->no_ktp }}</td>
                                    <td>
                                        @if((int)($driver->is_active ?? 0) === 1)
                                            <span class="badge bg-light-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-light-danger text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>{{ $transportir->code ?? '-' }}</td>
                                    <td>{{ $transportir->tranportir_name ?? '-' }}</td>
                                    <td>
                                        @if((int)($transportir->is_active ?? 0) === 1)
                                            <span class="badge bg-light-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-light-danger text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if((int)($m->is_active ?? 0) === 1)
                                            <span class="badge bg-light-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-light-danger text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-muted small">{{ optional($m->created_at)->format('Y-m-d H:i') }}</td>
                                    <td class="text-muted small">{{ optional($m->updated_at)->format('Y-m-d H:i') }}</td>

                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    {{-- Sesuaikan route name ini dengan route kamu --}}
                                                    <a class="dropdown-item"
                                                       href="{{ route('superadmin.mapping-transportir.edit', $m->id) }}">
                                                        <i class="bi bi-pencil-square me-2"></i> Edit
                                                    </a>
                                                </li>

                                                <li><hr class="dropdown-divider"></li>

                                                <li>
                                                    {{-- Sesuaikan route name ini dengan route kamu --}}
                                                    <button
                                                        type="button"
                                                        class="dropdown-item text-danger btn-delete-mapping"
                                                        data-url="{{ route('superadmin.mapping-transportir.delete', $m->id) }}"
                                                        data-name="{{ $displayName }}"
                                                    >
                                                        <i class="bi bi-trash me-2"></i> Delete
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
                            Showing <b>{{ $mappings->firstItem() }}</b> to <b>{{ $mappings->lastItem() }}</b>
                            of <b>{{ $mappings->total() }}</b> results
                        </div>

                        <div>
                            {{ $mappings->links() }}
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
            const indexUrl = @json(route('superadmin.mapping-transportir.index'));
            const csrf = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

            $(document).on('click', '.btn-delete-mapping', function () {
                const url  = $(this).data('url');
                const name = $(this).data('name') || 'this mapping';

                Swal.fire({
                    title: 'Delete Mapping?',
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
                                text: res?.message || 'Mapping deleted successfully',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = indexUrl;
                            });
                        },
                        error: function (xhr) {
                            const msg = xhr.responseJSON?.message || 'Failed to delete mapping';
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
