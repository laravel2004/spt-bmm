@extends('layouts.master-super')

@section('title', 'User Management')
@section('subtitle', 'User Management')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2">

                    {{-- LEFT: Title --}}
                    <div>
                        <h4 class="mb-0">User Management</h4>
                        <p class="text-muted mb-0">
                            Total: <span class="fw-bold">{{ $users->total() }}</span> users
                        </p>
                    </div>

                    {{-- RIGHT: Form dulu, baru button add --}}
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

                            {{-- PER PAGE (slim) --}}
                            <select name="perPage" class="form-select form-select-sm" style="min-width: 110px;max-height: 60px;"
                                    onchange="this.form.submit()">
                                @foreach([10, 20, 50, 100] as $n)
                                    <option value="{{ $n }}" @selected((int)request('perPage', 10) === $n)>
                                        {{ $n }}/page
                                    </option>
                                @endforeach
                            </select>

                            {{-- APPLY (slim) --}}
                            <button class="btn btn-primary btn-sm" type="submit" style="max-height: 60px;">
                                <i class="bi bi-funnel me-1"></i>
                            </button>
                        </form>

                        {{-- ADD BUTTON (slim) --}}
                        <a href="{{ route('superadmin.user-management.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i> Tambah User
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($users->count() === 0)
                    <div class="alert alert-light-primary mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        No users found.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-lg align-middle">
                            <thead>
                            <tr>
                                <th style="width: 70px;">No</th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Verified</th>
                                <th>Phone</th>
                                <th>NIPEG</th>
                                <th>IMEI</th>
                                <th>Photo</th>
                                <th>Ref Code</th>
                                <th>Active</th>
                                <th>Token</th>
                                <th>Created By</th>
                                <th>Modified By</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th class="text-end" style="width: 120px;">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($users as $i => $u)
                                <tr>
                                    <td class="text-muted">{{ $users->firstItem() + $i }}</td>

                                    {{-- USER (fullname + username + id) --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar avatar-md">
                            <span class="avatar-content bg-light-primary text-primary">
                                {{ strtoupper(mb_substr($u->fullname ?? 'U', 0, 1)) }}
                            </span>
                                            </div>

                                            <div>
                                                <div class="fw-bold mb-0">{{ $u->fullname ?? '-' }}</div>
                                                <small class="text-muted">
                                                    @<span class="fw-semibold">{{ $u->username ?? '-' }}</span> • ID: {{ $u->id }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- ROLE --}}
                                    <td>
                    <span class="badge bg-light-secondary text-dark">
                        {{ $u->role ?? '-' }}
                    </span>
                                    </td>

                                    {{-- EMAIL --}}
                                    <td>{{ $u->email ?? '-' }}</td>

                                    {{-- EMAIL VERIFIED --}}
                                    <td>
                                        @if($u->email_verified_at)
                                            <span class="badge bg-light-success text-success">
                            Yes
                        </span>
                                            <div class="text-muted small">{{ \Carbon\Carbon::parse($u->email_verified_at)->format('Y-m-d H:i') }}</div>
                                        @else
                                            <span class="badge bg-light-danger text-danger">No</span>
                                        @endif
                                    </td>

                                    {{-- PHONE --}}
                                    <td>
                                        @if($u->phone_num)
                                            <span class="badge bg-light-success text-success">{{ $u->phone_num }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- NIPEG --}}
                                    <td>{{ $u->nipeg ?? '-' }}</td>

                                    {{-- IMEI --}}
                                    <td>{{ $u->IMEI ?? '-' }}</td>

                                    {{-- PHOTO --}}
                                    <td>
                                        @if($u->photo_text)
                                            <a class="btn btn-sm btn-light"
                                               href="{{ asset('storage/' . $u->photo_text) }}"
                                               target="_blank" rel="noopener">
                                                <i class="bi bi-image"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- REFERENCE CODE --}}
                                    <td>{{ $u->reference_code ?? '-' }}</td>

                                    {{-- ACTIVE --}}
                                    <td>
                                        @if((int)$u->is_active === 1)
                                            <span class="badge bg-light-success text-success">Active</span>
                                        @else
                                            <span class="badge bg-light-danger text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    {{-- TOKEN (truncate) --}}
                                    <td>
                                        @if($u->token)
                                            <span class="text-muted small d-inline-block" style="max-width: 160px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $u->token }}
                        </span>
                                            <button type="button" class="btn btn-sm btn-light ms-1 btn-copy"
                                                    data-copy="{{ $u->token }}">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- CREATED BY / MODIFIED BY --}}
                                    <td>{{ $u->created_by ?? '-' }}</td>
                                    <td>{{ $u->modified_by ?? '-' }}</td>

                                    {{-- CREATED AT / UPDATED AT --}}
                                    <td class="text-muted small">{{ optional($u->created_at)->format('Y-m-d H:i') }}</td>
                                    <td class="text-muted small">{{ optional($u->updated_at)->format('Y-m-d H:i') }}</td>

                                    {{-- ACTIONS --}}
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('superadmin.user-management.edit', $u->id) }}">
                                                        <i class="bi bi-pencil-square me-2"></i> Edit
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button
                                                        type="button"
                                                        class="dropdown-item text-danger btn-delete-user"
                                                        data-url="{{ route('superadmin.user-management.delete', $u->id) }}"
                                                        data-name="{{ $u->fullname ?? $u->username }}"
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
                            Showing <b>{{ $users->firstItem() }}</b> to <b>{{ $users->lastItem() }}</b>
                            of <b>{{ $users->total() }}</b> results
                        </div>

                        <div>
                            {{ $users->links() }}
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
            const indexUrl = @json(route('superadmin.user-management.index'));
            const csrf = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

            $(document).on('click', '.btn-delete-user', function () {
                const url  = $(this).data('url');
                const name = $(this).data('name') || 'this user';

                Swal.fire({
                    title: 'Delete user?',
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
                                text: res?.message || 'User deleted successfully',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = indexUrl; // redirect via JS
                            });
                        },
                        error: function (xhr) {
                            const msg = xhr.responseJSON?.message || 'Failed to delete user';
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


