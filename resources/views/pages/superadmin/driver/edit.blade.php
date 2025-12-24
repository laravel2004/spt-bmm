@extends('layouts.master-super')

@section('title', 'Edit Driver')
@section('subtitle', 'Edit Driver')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h4 class="mb-0">Edit Driver</h4>
                            <p class="text-muted mb-0">Update driver information below. (ID: {{ $driver->id }})</p>
                        </div>

                        <a href="{{ route('superadmin.driver.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>

                    <div class="card-body">
                        <form id="formEditDriver" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="user_id" value="{{ $driver->user_id }}">

                            <div class="row g-3">

                                <div class="col-12">
                                    <h6 class="mb-0">Account (Users)</h6>
                                    <hr>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username"
                                           value="{{ old('username', $driver->user->username ?? '') }}">
                                    <div class="invalid-feedback" data-error-for="username"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fullname <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="user_fullname"
                                           value="{{ old('user_fullname', $driver->user->fullname ?? '') }}">
                                    <div class="invalid-feedback" data-error-for="user_fullname"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email"
                                           value="{{ old('email', $driver->user->email ?? '') }}">
                                    <div class="invalid-feedback" data-error-for="email"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone_num"
                                           value="{{ old('phone_num', $driver->user->phone_num ?? '') }}">
                                    <div class="invalid-feedback" data-error-for="phone_num"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">New Password (optional)</label>
                                    <input type="password" class="form-control" name="password" placeholder="leave blank if unchanged">
                                    <div class="invalid-feedback" data-error-for="password"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Password Confirmation</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                    <div class="invalid-feedback" data-error-for="password_confirmation"></div>
                                </div>

                                <div class="col-12 mt-3">
                                    <h6 class="mb-0">Driver Profile (Drivers)</h6>
                                    <hr>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Driver Fullname</label>
                                    <input type="text" class="form-control" name="driver_fullname"
                                           value="{{ old('driver_fullname', $driver->fullname) }}">
                                    <div class="invalid-feedback" data-error-for="driver_fullname"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Driver Type</label>
                                    <input type="text" class="form-control" name="driver_type"
                                           value="{{ old('driver_type', $driver->driver_type) }}">
                                    <div class="invalid-feedback" data-error-for="driver_type"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Birthday</label>
                                    <input type="date" class="form-control" name="birthday"
                                           value="{{ old('birthday', optional($driver->birthday)->format('Y-m-d')) }}">
                                    <div class="invalid-feedback" data-error-for="birthday"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Place of Birth</label>
                                    <input type="text" class="form-control" name="place_of_birth"
                                           value="{{ old('place_of_birth', $driver->place_of_birth) }}">
                                    <div class="invalid-feedback" data-error-for="place_of_birth"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <select class="form-select" name="gender">
                                        <option value="">-- Choose --</option>
                                        @foreach(['Laki-laki','Perempuan'] as $g)
                                            <option value="{{ $g }}" @selected(old('gender', $driver->gender) === $g)>{{ $g }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" data-error-for="gender"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Marital Status</label>
                                    <select class="form-select" name="marital_status">
                                        <option value="">-- Choose --</option>
                                        @foreach(['Lajang','Menikah','Duda','Janda'] as $m)
                                            <option value="{{ $m }}" @selected(old('marital_status', $driver->marital_status) === $m)>{{ $m }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" data-error-for="marital_status"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No. KTP</label>
                                    <input type="text" class="form-control" name="no_ktp"
                                           value="{{ old('no_ktp', $driver->no_ktp) }}">
                                    <div class="invalid-feedback" data-error-for="no_ktp"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Religion</label>
                                    <input type="text" class="form-control" name="religion"
                                           value="{{ old('religion', $driver->religion) }}">
                                    <div class="invalid-feedback" data-error-for="religion"></div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">KTP Photo</label>
                                    <input type="file" class="form-control" name="ktp_photo" accept="image/*">
                                    <div class="invalid-feedback" data-error-for="ktp_photo"></div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="2">{{ old('address', $driver->address) }}</textarea>
                                    <div class="invalid-feedback" data-error-for="address"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Address Type</label>
                                    <select class="form-select" name="address_type">
                                        <option value="">-- Choose --</option>
                                        @foreach(['Pribadi','Ortu','Sewa','Lain','Kost','KPR'] as $t)
                                            <option value="{{ $t }}" @selected(old('address_type', $driver->address_type) === $t)>{{ $t }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" data-error-for="address_type"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">RT/RW</label>
                                    <input type="text" class="form-control" name="rttw"
                                           value="{{ old('rttw', $driver->rttw) }}">
                                    <div class="invalid-feedback" data-error-for="rttw"></div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="city"
                                           value="{{ old('city', $driver->city) }}">
                                    <div class="invalid-feedback" data-error-for="city"></div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Province</label>
                                    <input type="text" class="form-control" name="province"
                                           value="{{ old('province', $driver->province) }}">
                                    <div class="invalid-feedback" data-error-for="province"></div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Zipcode</label>
                                    <input type="text" class="form-control" name="zipcode"
                                           value="{{ old('zipcode', $driver->zipcode) }}">
                                    <div class="invalid-feedback" data-error-for="zipcode"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Last Education</label>
                                    <input type="text" class="form-control" name="last_education"
                                           value="{{ old('last_education', $driver->last_education) }}">
                                    <div class="invalid-feedback" data-error-for="last_education"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Reference Code</label>
                                    <input type="text" class="form-control" name="reference_code"
                                           value="{{ old('reference_code', $driver->reference_code) }}">
                                    <div class="invalid-feedback" data-error-for="reference_code"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Status (Ready) <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status">
                                        <option value="1" @selected((string)old('status', (int)$driver->status) === '1')>Ready</option>
                                        <option value="0" @selected((string)old('status', (int)$driver->status) === '0')>Not Ready</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="status"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Active <span class="text-danger">*</span></label>
                                    <select class="form-select" name="is_active">
                                        <option value="1" @selected((string)old('is_active', (int)$driver->is_active) === '1')>Active</option>
                                        <option value="0" @selected((string)old('is_active', (int)$driver->is_active) === '0')>Inactive</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="is_active"></div>
                                </div>

                                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('superadmin.driver.index') }}" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        <i class="bi bi-save me-1"></i> Update Driver
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
            const updateUrl = @json(route('superadmin.driver.update', $driver->id));
            const indexUrl  = @json(route('superadmin.driver.index'));

            function resetFieldErrors() {
                $('#formEditDriver .is-invalid').removeClass('is-invalid');
                $('#formEditDriver [data-error-for]').text('');
            }

            function setFieldError(field, message) {
                const $input = $('#formEditDriver [name="' + field + '"]');
                $input.addClass('is-invalid');
                $('#formEditDriver [data-error-for="' + field + '"]').text(message);
            }

            $('#formEditDriver').on('submit', function (e) {
                e.preventDefault();
                resetFieldErrors();

                const formData = new FormData(this);
                $('#btnSubmit').prop('disabled', true);

                $.ajax({
                    url: updateUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
                    success: function (res) {
                        $('#btnSubmit').prop('disabled', false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res?.message || 'Driver updated successfully',
                            confirmButtonText: 'OK'
                        }).then(() => window.location.href = indexUrl);
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

                        const msg = xhr.responseJSON?.message || 'Failed to update driver';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg, confirmButtonText: 'OK' });
                    }
                });
            });
        });
    </script>
@endpush
