@extends('layouts.master-super')

@section('title', 'Customer Management')
@section('subtitle', 'Customer Management')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2">

                    <div>
                        <h4 class="mb-0">Customer Management</h4>
                        <p class="text-muted mb-0">
                            Total: <span class="fw-bold">{{ $customers->total() }}</span> customers found.
                        </p>
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2">

                        <form method="GET" action="{{ url()->current() }}" class="d-flex flex-column flex-md-row gap-2">
                            {{-- SEARCH (slim) --}}
                            <div class="input-group input-group-sm" style="min-width: 260px; max-height: 60px;">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="search"
                                    placeholder="Search..."
                                    value="{{ request('search') }}"
                                    autocomplete="off"
                                />

                                @if(request()->filled('search') || request()->filled('perPage'))
                                    <a href="{{ url()->current() }}" class="btn btn-light">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                @endif
                            </div>

                            <select name="perPage" class="form-select form-select-sm" style="min-width: 110px;max-height: 60px;"
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

                        <a href="{{ route('superadmin.customer.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Customers
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($customers->count() === 0)
                    <div class="alert alert-light-primary mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        No customers found.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-lg align-middle">
                            <thead>
                            <tr>
                                <th style="width: 70px;">No</th>
                                <th>Customer Code</th>
                                <th>Customer Name</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Processed By</th>
                                <th>Processed Date</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th class="text-end" style="width: 120px;">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($customers as $i => $u)
                                <tr>
                                    <td class="text-muted">{{ $customers->firstItem() + $i }}</td>
                                    <td>{{ $u->cust_code ?? '-' }}</td>

                                    <td>{{ $u->cust_name ?? '-' }}</td>
                                    <td>{{ $u->address ?? '-' }}</td>
                                    <td>
                                        @if((int)$u->is_active === 1)
                                            <span class="badge bg-light-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-light-danger text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $u->processed_by ?? '-' }}</td>
                                    <td class="text-muted small">{{ $u->processed_date }}</td>
                                    <td class="text-muted small">{{ optional($u->created_at)->format('Y-m-d H:i') }}</td>
                                    <td class="text-muted small">{{ optional($u->updated_at)->format('Y-m-d H:i') }}</td>

                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('superadmin.customer.edit', $u->id) }}">
                                                        <i class="bi bi-pencil-square me-2"></i> Edit
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button
                                                        type="button"
                                                        class="dropdown-item text-danger btn-delete-user"
                                                        data-url="{{ route('superadmin.customer.delete', $u->id) }}"
                                                        data-name="{{ $u->cust_name ?? $u->cust_code }}"
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
                            Showing <b>{{ $customers->firstItem() }}</b> to <b>{{ $customers->lastItem() }}</b>
                            of <b>{{ $customers->total() }}</b> results
                        </div>

                        <div>
                            {{ $customers->links() }}
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
            const indexUrl = @json(route('superadmin.customer.index'));
            const csrf = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

            $(document).on('click', '.btn-delete-user', function () {
                const url  = $(this).data('url');
                const name = $(this).data('name') || 'this user';

                Swal.fire({
                    title: 'Delete Customer?',
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
                                text: res?.message || 'Customer deleted successfully',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = indexUrl;
                            });
                        },
                        error: function (xhr) {
                            const msg = xhr.responseJSON?.message || 'Failed to delete customer. Please try again later.';
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


