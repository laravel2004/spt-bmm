@extends('layouts.master-super')

@section('title', 'Driver Detail')
@section('subtitle', 'Driver Detail')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h4 class="mb-0">Driver Detail</h4>
                            <p class="text-muted mb-0">
                                Detail information for driver (ID: {{ $driver->id }})
                            </p>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.driver.edit', $driver->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.driver.index') }}" class="btn btn-light">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- STATUS BADGES --}}
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if((int)$driver->status === 1)
                                <span class="badge bg-light-success text-success">Ready</span>
                            @else
                                <span class="badge bg-light-danger text-danger">Not Ready</span>
                            @endif

                            @if((int)$driver->is_active === 1)
                                <span class="badge bg-light-success text-success">Active</span>
                            @else
                                <span class="badge bg-light-danger text-danger">Inactive</span>
                            @endif

                            <span class="badge bg-light-secondary text-muted">
                            Role: {{ $driver->user->role ?? '-' }}
                        </span>
                        </div>

                        <div class="row g-3">
                            {{-- USERS --}}
                            <div class="col-12">
                                <h6 class="mb-0">Account (Users)</h6>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Username</div>
                                <div class="fw-semibold">{{ $driver->user->username ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Fullname</div>
                                <div class="fw-semibold">{{ $driver->user->fullname ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Email</div>
                                <div class="fw-semibold">{{ $driver->user->email ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Phone</div>
                                <div class="fw-semibold">{{ $driver->user->phone_num ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Created By</div>
                                <div class="fw-semibold">{{ $driver->user->created_by ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Modified By</div>
                                <div class="fw-semibold">{{ $driver->user->modified_by ?? '-' }}</div>
                            </div>

                            <div class="col-12 mt-3">
                                <h6 class="mb-0">Driver Profile (Drivers)</h6>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Driver Fullname</div>
                                <div class="fw-semibold">{{ $driver->fullname ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Driver Type</div>
                                <div class="fw-semibold">{{ $driver->driver_type ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Birthday</div>
                                <div class="fw-semibold">
                                    {{ $driver->birthday ? \Carbon\Carbon::parse($driver->birthday)->format('Y-m-d') : '-' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Place of Birth</div>
                                <div class="fw-semibold">{{ $driver->place_of_birth ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Gender</div>
                                <div class="fw-semibold">{{ $driver->gender ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Marital Status</div>
                                <div class="fw-semibold">{{ $driver->marital_status ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">No. KTP</div>
                                <div class="fw-semibold">{{ $driver->no_ktp ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Religion</div>
                                <div class="fw-semibold">{{ $driver->religion ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Last Education</div>
                                <div class="fw-semibold">{{ $driver->last_education ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Reference Code</div>
                                <div class="fw-semibold">{{ $driver->reference_code ?? '-' }}</div>
                            </div>

                            <div class="col-12">
                                <div class="text-muted small">Address</div>
                                <div class="fw-semibold">{{ $driver->address ?? '-' }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-muted small">City</div>
                                <div class="fw-semibold">{{ $driver->city ?? '-' }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-muted small">Province</div>
                                <div class="fw-semibold">{{ $driver->province ?? '-' }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-muted small">Zipcode</div>
                                <div class="fw-semibold">{{ $driver->zipcode ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Created At</div>
                                <div class="fw-semibold">{{ optional($driver->created_at)->format('Y-m-d H:i') }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Updated At</div>
                                <div class="fw-semibold">{{ optional($driver->updated_at)->format('Y-m-d H:i') }}</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
