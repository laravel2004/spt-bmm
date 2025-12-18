@extends('layouts.master-super')

@section('title', 'Edit Vehicle')
@section('subtitle', 'Edit Vehicle')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h4 class="mb-0">Edit Vehicle</h4>
                            <p class="text-muted mb-0">
                                Update vehicle information below. (ID: {{ $vehicle->id }})
                            </p>
                        </div>

                        <a href="{{ route('superadmin.vehicle.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>

                    <div class="card-body">
                        <form id="formEditUser" enctype="multipart/form-data">
                            @csrf
                            {{-- Method spoofing untuk PUT --}}
                            <input type="hidden" name="_method" value="PUT">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Vehicle Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="vehicle_no"
                                           value="{{ old('vehicle_no', $vehicle->vehicle_no) }}" placeholder="vehicle_no">
                                    <div class="invalid-feedback" data-error-for="vehicle_no"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Vehicle No <span class="text-danger">*</span></label>
                                    <select class="form-select" name="vehicle_type">
                                        <option value="">-- Choose Type --</option>
                                        <option value="wingbox" @selected($vehicle->vehicle_type === "wingbox")>Wing Box</option>
                                        <option value="container_20_feet" @selected($vehicle->vehicle_type === "container_20_feet") >Container 20 Feet</option>
                                        <option value="container_40_feet" @selected($vehicle->vehicle_type === "container_20_feet") >Container 40 Feet</option>
                                        <option value="tronton" @selected($vehicle->vehicle_type === "tronton") >Tronton</option>
                                        <option value="trintin" @selected($vehicle->vehicle_type === "trintin") >Trintin</option>
                                        <option value="engkel" @selected($vehicle->vehicle_type === "engkel") >Engkel</option>
                                        <option value="l300" @selected($vehicle->vehicle_type === "l300") >L300</option>
                                        <option value="cdd" @selected($vehicle->vehicle_type === "cdd") >CDD</option>
                                        <option value="fuso" @selected($vehicle->vehicle_type === "fuso") >FUSO</option>
                                        <option value="cde" @selected($vehicle->vehicle_type === "cde") >CDE</option>
                                        <option value="grandmax" @selected($vehicle->vehicle_type === "grandmax") >Grand Max</option>
                                        <option value="hino" @selected($vehicle->vehicle_type === "hino") >Hino</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="vehicle_type"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Capacity<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="capacity"
                                           value="{{ old('capacity', $vehicle->capacity) }}" placeholder="1000">
                                    <div class="invalid-feedback" data-error-for="capacity"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Production Year<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="production_year"
                                           value="{{ old('production_year', $vehicle->production_year) }}" placeholder="1000">
                                    <div class="invalid-feedback" data-error-for="production_year"></div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Active <span class="text-danger">*</span></label>
                                    <select class="form-select" name="is_active">
                                        <option value="1" @selected((string)old('is_active', (int)$vehicle->is_active) === '1')>Active</option>
                                        <option value="0" @selected((string)old('is_active', (int)$vehicle->is_active) === '0')>Inactive</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="is_active"></div>
                                </div>

                                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('superadmin.vehicle.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        <i class="bi bi-save me-1"></i> Update Vehicle
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            const updateUrl = @json(route('superadmin.vehicle.update', $vehicle->id));
            const indexUrl  = @json(route('superadmin.vehicle.index'));

            function resetFieldErrors() {
                $('#formEditUser .is-invalid').removeClass('is-invalid');
                $('#formEditUser [data-error-for]').text('');
            }

            function setFieldError(field, message) {
                const $input = $('#formEditUser [name="' + field + '"]');
                $input.addClass('is-invalid');
                $('#formEditUser [data-error-for="' + field + '"]').text(message);
            }

            $('#formEditUser').on('submit', function (e) {
                e.preventDefault();
                resetFieldErrors();

                const formData = new FormData(this);
                $('#btnSubmit').prop('disabled', true);

                $.ajax({
                    url: updateUrl,
                    method: 'POST',
                    _method: 'PUT',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function (res) {
                        $('#btnSubmit').prop('disabled', false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res?.message || 'Vehicle updated successfully',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = indexUrl;
                        });
                    },
                    error: function (xhr) {
                        $('#btnSubmit').prop('disabled', false);

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON?.errors || {};
                            Object.keys(errors).forEach(function (key) {
                                setFieldError(key, errors[key][0]);
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: 'Please check the highlighted fields.',
                                confirmButtonText: 'OK'
                            });

                            return;
                        }

                        const msg = xhr.responseJSON?.message || 'Failed to update vehicle';

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
    </script>
@endpush
