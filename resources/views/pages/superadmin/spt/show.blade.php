@extends('layouts.master-super')

@section('title', 'SPT Detail')
@section('subtitle', 'SPT Detail')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h4 class="mb-0">SPT Detail</h4>
                            <p class="text-muted mb-0">
                                Detail information for SPT (ID: {{ $spt->id }})
                            </p>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('superadmin.spt.index') }}" class="btn btn-light">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- STATUS BADGES --}}
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if((int) $spt->status === 1)
                                <span class="badge bg-light-success text-success">Active</span>
                            @else
                                <span class="badge bg-light-danger text-danger">Inactive</span>
                            @endif

                            @if((int) $spt->is_transit === 1)
                                <span class="badge bg-light-warning text-warning">Transit</span>
                            @else
                                <span class="badge bg-light-secondary text-muted">Not Transit</span>
                            @endif

                            <span class="badge bg-light-secondary text-muted">
                                Driver ID: {{ $spt->driver_id ?? '-' }}
                            </span>

                            <span class="badge bg-light-secondary text-muted">
                                Transportir ID: {{ $spt->transportir_id ?? '-' }}
                            </span>
                        </div>

                        <div class="row g-3">
                            {{-- SPT --}}
                            <div class="col-12">
                                <h6 class="mb-0">SPT Information</h6>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">SPT No</div>
                                <div class="fw-semibold">{{ $spt->spt_no ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">SJ No</div>
                                <div class="fw-semibold">{{ $spt->sj_no ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">SPT Date</div>
                                <div class="fw-semibold">
                                    {{ $spt->spt_date ? \Carbon\Carbon::parse($spt->spt_date)->format('Y-m-d H:i') : '-' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">SPT Expired Date</div>
                                <div class="fw-semibold">
                                    {{ $spt->spt_expired_date ? \Carbon\Carbon::parse($spt->spt_expired_date)->format('Y-m-d H:i') : '-' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">SPPB No</div>
                                <div class="fw-semibold">{{ $spt->sppb_no ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">SPPB Key</div>
                                <div class="fw-semibold">{{ $spt->sppb_key ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Reference Code</div>
                                <div class="fw-semibold">{{ $spt->reference_code ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Phone</div>
                                <div class="fw-semibold">{{ $spt->phone ?? '-' }}</div>
                            </div>

                            {{-- CUSTOMER --}}
                            <div class="col-12 mt-3">
                                <h6 class="mb-0">Customer</h6>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Customer Code</div>
                                <div class="fw-semibold">{{ $spt->cust_code ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Customer Name</div>
                                <div class="fw-semibold">{{ $spt->cust_name ?? '-' }}</div>
                            </div>

                            {{-- SHIPPING --}}
                            <div class="col-12 mt-3">
                                <h6 class="mb-0">Shipping</h6>
                                <hr>
                            </div>

                            <div class="col-12">
                                <div class="text-muted small">Address Ship To</div>
                                <div class="fw-semibold">{{ $spt->address_ship_to ?? '-' }}</div>
                            </div>

                            <div class="col-12">
                                <div class="text-muted small">Address Ship From</div>
                                <div class="fw-semibold">{{ $spt->address_ship_from ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Ship From</div>
                                <div class="fw-semibold">{{ $spt->ship_from ?? '-' }}</div>
                            </div>

                            {{-- TRANSPORTIR --}}
                            <div class="col-12 mt-3">
                                <h6 class="mb-0">Transportir</h6>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Transportir Code</div>
                                <div class="fw-semibold">{{ $spt->transportir_code ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Transportir Name</div>
                                <div class="fw-semibold">{{ $spt->transportir_name ?? '-' }}</div>
                            </div>

                            {{-- ITEM --}}
                            <div class="col-12 mt-3">
                                <h6 class="mb-0">Item</h6>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Item Code</div>
                                <div class="fw-semibold">{{ $spt->item_code ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Item Name</div>
                                <div class="fw-semibold">{{ $spt->item_name ?? '-' }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-muted small">Qty SPPB</div>
                                <div class="fw-semibold">{{ $spt->qty_sppb ?? '-' }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-muted small">Qty</div>
                                <div class="fw-semibold">{{ $spt->qty ?? '-' }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-muted small">Container No</div>
                                <div class="fw-semibold">{{ $spt->container_no ?? '-' }}</div>
                            </div>

                            {{-- VEHICLE --}}
                            <div class="col-12 mt-3">
                                <h6 class="mb-0">Vehicle</h6>
                                <hr>
                            </div>

                            <div class="col-md-4">
                                <div class="text-muted small">Vehicle Type</div>
                                <div class="fw-semibold">{{ $spt->vehicle_type ?? '-' }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-muted small">Vehicle No</div>
                                <div class="fw-semibold">{{ $spt->vehicle_no ?? '-' }}</div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-muted small">Netto / Bruto</div>
                                <div class="fw-semibold">
                                    {{ $spt->weight_netto ?? '-' }} / {{ $spt->weight_bruto ?? '-' }}
                                </div>
                            </div>

                            {{-- ASSIGNMENT --}}
                            <div class="col-12 mt-3">
                                <h6 class="mb-0">Assignment</h6>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Take Assignment By</div>
                                <div class="fw-semibold">{{ $spt->take_assignment_by ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Take Assignment Date</div>
                                <div class="fw-semibold">
                                    {{ $spt->take_assignment_date ? \Carbon\Carbon::parse($spt->take_assignment_date)->format('Y-m-d H:i') : '-' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Latitude</div>
                                <div class="fw-semibold">{{ $spt->take_assignment_latitude ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Longitude</div>
                                <div class="fw-semibold">
                                    {{ $spt->take_assignment_longitude ?? '-' }}

                                    @if($spt->take_assignment_latitude && $spt->take_assignment_longitude)
                                        <a class="ms-2 small"
                                           target="_blank"
                                           href="https://www.google.com/maps?q={{ $spt->take_assignment_latitude }},{{ $spt->take_assignment_longitude }}">
                                            (Open Map)
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- KTP PICTURE (SPT) --}}
                            <div class="col-12 mt-3">
                                <h6 class="mb-0">KTP Evidence</h6>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">KTP Picture (from SPT)</div>
                                <div class="fw-semibold">
                                    @if($spt->ktp_picture)
                                        <div class="mt-2">
                                            <img
                                                src="{{ asset('storage/' . ltrim($spt->ktp_picture, '/')) }}"
                                                alt="KTP Picture"
                                                class="img-fluid rounded border"
                                                style="max-height: 260px; object-fit: cover;"
                                                onerror="this.closest('div').innerHTML='<span class=\'text-muted\'>Image not found</span>';"
                                            >
                                        </div>
                                        <div class="small text-muted mt-1">{{ $spt->ktp_picture }}</div>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            {{-- DRIVER (RELATION) --}}
                            <div class="col-12 mt-3">
                                <h6 class="mb-0">Driver (Relation)</h6>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Driver Name</div>
                                <div class="fw-semibold">{{ $spt->driver->fullname ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Driver Type</div>
                                <div class="fw-semibold">{{ $spt->driver->driver_type ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Driver Phone</div>
                                <div class="fw-semibold">{{ $spt->driver->phone_num ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Driver KTP Photo (from Driver)</div>
                                <div class="fw-semibold">
                                    @if(optional($spt->driver)->ktp_photo)
                                        <div class="mt-2">
                                            <img
                                                src="{{ asset('storage/' . ltrim($spt->driver->ktp_photo, '/')) }}"
                                                alt="Driver KTP Photo"
                                                class="img-fluid rounded border"
                                                style="max-height: 260px; object-fit: cover;"
                                                onerror="this.closest('div').innerHTML='<span class=\'text-muted\'>Image not found</span>';"
                                            >
                                        </div>
                                        <div class="small text-muted mt-1">{{ $spt->driver->ktp_photo }}</div>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            @if($spt->driver)
                                <div class="col-12">
                                    <a href="{{ route('superadmin.driver.show', $spt->driver->id) }}" class="btn btn-sm btn-light mt-1">
                                        <i class="bi bi-person-badge me-1"></i> View Driver Detail
                                    </a>
                                </div>
                            @endif

                            {{-- AUDIT --}}
                            <div class="col-12 mt-3">
                                <h6 class="mb-0">Audit</h6>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Created By</div>
                                <div class="fw-semibold">{{ $spt->created_by ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Modified By</div>
                                <div class="fw-semibold">{{ $spt->modified_by ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Created At</div>
                                <div class="fw-semibold">{{ optional($spt->created_at)->format('Y-m-d H:i') }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Updated At</div>
                                <div class="fw-semibold">{{ optional($spt->updated_at)->format('Y-m-d H:i') }}</div>
                            </div>

                        </div> {{-- row --}}
                    </div> {{-- card-body --}}
                </div> {{-- card --}}
            </div>
        </div>
    </section>
@endsection
