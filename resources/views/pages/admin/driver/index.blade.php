@extends('layouts.master-admin')

@section('title', 'Driver Management')
@section('subtitle', 'Driver Management')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2">
                    <div>
                        <h4 class="mb-0">Driver Management</h4>
                        <p class="text-muted mb-0">
                            Total: <span class="fw-bold">{{ $drivers->total() }}</span> drivers
                        </p>
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2">
                        <form method="GET" action="{{ url()->current() }}" class="d-flex flex-column flex-md-row gap-2">
                            <div class="input-group input-group-sm" style="min-width: 260px; max-height: 60px;">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" name="search" placeholder="Search..."
                                       value="{{ request('search') }}" autocomplete="off" />
                                @if(request()->filled('search') || request()->filled('perPage'))
                                    <a href="{{ url()->current() }}" class="btn btn-light">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                @endif
                            </div>

                            <select name="perPage" class="form-select form-select-sm"
                                    style="min-width: 110px;max-height: 60px;" onchange="this.form.submit()">
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

                        <a href="{{ route('admin.driver.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Driver
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if($drivers->count() === 0)
                    <div class="alert alert-light-primary mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        No driver found.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-lg align-middle">
                            <thead>
                            <tr>
                                <th style="width: 70px;">No</th>
                                <th>Username</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Type</th>
                                <th>KTP</th>
                                <th>Status</th>
                                <th>Active</th>
                                <th>Created</th>
                                <th>Modified</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th class="text-end" style="width: 120px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($drivers as $i => $d)
                                <tr>
                                    <td class="text-muted">{{ $drivers->firstItem() + $i }}</td>
                                    <td>{{ $d->user->username ?? '-' }}</td>
                                    <td>{{ $d->fullname ?? ($d->user->fullname ?? '-') }}</td>
                                    <td>{{ $d->user->email ?? '-' }}</td>
                                    <td>{{ $d->user->phone_num ?? '-' }}</td>
                                    <td>{{ $d->driver_type ?? '-' }}</td>

                                    <td>
                                        @if($d->ktp_photo)
                                            <a href="{{ '/storage/' . $d->ktp_photo }}" target="_blank" class="btn btn-sm btn-light">
                                                <i class="bi bi-eye me-1"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if((int)$d->status === 1)
                                            <span class="badge bg-light-success text-success">Ready</span>
                                        @else
                                            <span class="badge bg-light-danger text-danger">Not Ready</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if((int)$d->is_active === 1)
                                            <span class="badge bg-light-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-light-danger text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>{{ $d->created_by ?? '-' }}</td>
                                    <td>{{ $d->modified_by ?? '-' }}</td>

                                    <td class="text-muted small">{{ optional($d->created_at)->format('Y-m-d H:i') }}</td>
                                    <td class="text-muted small">{{ optional($d->updated_at)->format('Y-m-d H:i') }}</td>

                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.driver.show', $d->id) }}">
                                                        <i class="bi bi-eye me-2"></i> Detail
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.driver.edit', $d->id) }}">
                                                        <i class="bi bi-pencil-square me-2"></i> Edit
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger btn-delete-driver"
                                                            data-url="{{ route('admin.driver.delete', $d->id) }}"
                                                            data-name="{{ $d->fullname ?? ($d->user->fullname ?? $d->user->username) }}">
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
                            Showing <b>{{ $drivers->firstItem() }}</b> to <b>{{ $drivers->lastItem() }}</b>
                            of <b>{{ $drivers->total() }}</b> results
                        </div>

                        <div>{{ $drivers->links() }}</div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            const indexUrl = @json(route('admin.driver.index'));
            const csrf = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

            $(document).on('click', '.btn-delete-driver', function () {
                const url  = $(this).data('url');
                const name = $(this).data('name') || 'this driver';

                Swal.fire({
                    title: 'Delete driver?',
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
                                text: res?.message || 'Driver deleted successfully',
                                confirmButtonText: 'OK'
                            }).then(() => window.location.href = indexUrl);
                        },
                        error: function (xhr) {
                            const msg = xhr.responseJSON?.message || 'Failed to delete driver';
                            Swal.fire({ icon: 'error', title: 'Error', text: msg, confirmButtonText: 'OK' });
                        }
                    });
                });
            });
        });
    </script>
@endpush
