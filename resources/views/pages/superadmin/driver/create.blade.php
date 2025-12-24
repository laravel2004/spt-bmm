@extends('layouts.master-super')

@section('title', 'Add Driver')
@section('subtitle', 'Add Driver')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h4 class="mb-0">Create New Driver</h4>
                            <p class="text-muted mb-0">Fill the form below to add a new driver (User + Driver).</p>
                        </div>

                        <a href="{{ route('superadmin.driver.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>

                    <div class="card-body">
                        <form id="formAddDriver" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">

                                {{-- USERS --}}
                                <div class="col-12">
                                    <h6 class="mb-0">Account (Users)</h6>
                                    <small class="text-muted">Data login driver</small>
                                    <hr>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" placeholder="driver01">
                                    <div class="invalid-feedback" data-error-for="username"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fullname <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="user_fullname" placeholder="Budi Santoso">
                                    <div class="invalid-feedback" data-error-for="user_fullname"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" placeholder="driver@mail.com">
                                    <div class="invalid-feedback" data-error-for="email"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone_num" placeholder="08xxxx">
                                    <div class="invalid-feedback" data-error-for="phone_num"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" placeholder="********">
                                    <div class="invalid-feedback" data-error-for="password"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Password Confirmation <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="********">
                                    <div class="invalid-feedback" data-error-for="password_confirmation"></div>
                                </div>

                                {{-- DRIVERS --}}
                                <div class="col-12 mt-3">
                                    <h6 class="mb-0">Driver Profile (Drivers)</h6>
                                    <small class="text-muted">Data profil & operasional driver</small>
                                    <hr>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Driver Fullname</label>
                                    <input type="text" class="form-control" name="driver_fullname" placeholder="(opsional)">
                                    <div class="invalid-feedback" data-error-for="driver_fullname"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Driver Type</label>
                                    <input type="text" class="form-control" name="driver_type" placeholder="harian / kontrak / dll">
                                    <div class="invalid-feedback" data-error-for="driver_type"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Birthday</label>
                                    <input type="date" class="form-control" name="birthday">
                                    <div class="invalid-feedback" data-error-for="birthday"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Place of Birth</label>
                                    <input type="text" class="form-control" name="place_of_birth" placeholder="Surabaya">
                                    <div class="invalid-feedback" data-error-for="place_of_birth"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <select class="form-select" name="gender">
                                        <option value="">-- Choose --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="gender"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Marital Status</label>
                                    <select class="form-select" name="marital_status">
                                        <option value="">-- Choose --</option>
                                        <option value="Lajang">Lajang</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Duda">Duda</option>
                                        <option value="Janda">Janda</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="marital_status"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No. KTP</label>
                                    <input type="text" class="form-control" name="no_ktp" placeholder="35xxxxxxxxxxxxxx">
                                    <div class="invalid-feedback" data-error-for="no_ktp"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Religion</label>
                                    <input type="text" class="form-control" name="religion" placeholder="Islam / Kristen / dll">
                                    <div class="invalid-feedback" data-error-for="religion"></div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">KTP Photo</label>
                                    <input type="file" class="form-control" name="ktp_photo" accept="image/*">
                                    <div class="invalid-feedback" data-error-for="ktp_photo"></div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="2" placeholder="Alamat lengkap"></textarea>
                                    <div class="invalid-feedback" data-error-for="address"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Address Type</label>
                                    <select class="form-select" name="address_type">
                                        <option value="">-- Choose --</option>
                                        @foreach(['Pribadi','Ortu','Sewa','Lain','Kost','KPR'] as $t)
                                            <option value="{{ $t }}">{{ $t }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" data-error-for="address_type"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">RT/RW</label>
                                    <input type="text" class="form-control" name="rttw" placeholder="001/002">
                                    <div class="invalid-feedback" data-error-for="rttw"></div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" placeholder="Surabaya">
                                    <div class="invalid-feedback" data-error-for="city"></div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Province</label>
                                    <input type="text" class="form-control" name="province" placeholder="Jawa Timur">
                                    <div class="invalid-feedback" data-error-for="province"></div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Zipcode</label>
                                    <input type="text" class="form-control" name="zipcode" placeholder="60xxx">
                                    <div class="invalid-feedback" data-error-for="zipcode"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Last Education</label>
                                    <input type="text" class="form-control" name="last_education" placeholder="SMA / SMK / S1">
                                    <div class="invalid-feedback" data-error-for="last_education"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Reference Code</label>
                                    <input type="text" class="form-control" name="reference_code" placeholder="REF-xxx">
                                    <div class="invalid-feedback" data-error-for="reference_code"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Status (Ready) <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status">
                                        <option value="1">Ready</option>
                                        <option value="0">Not Ready</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="status"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Active <span class="text-danger">*</span></label>
                                    <select class="form-select" name="is_active">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="is_active"></div>
                                </div>

                                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('superadmin.driver.index') }}" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        <i class="bi bi-save me-1"></i> Save Driver
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
            const storeUrl = @json(route('superadmin.driver.store'));
            const indexUrl = @json(route('superadmin.driver.index'));

            function resetFieldErrors() {
                $('#formAddDriver .is-invalid').removeClass('is-invalid');
                $('#formAddDriver [data-error-for]').text('');
            }

            function setFieldError(field, message) {
                const $input = $('#formAddDriver [name="' + field + '"]');
                $input.addClass('is-invalid');
                $('#formAddDriver [data-error-for="' + field + '"]').text(message);
            }

            $('#formAddDriver').on('submit', function (e) {
                e.preventDefault();
                resetFieldErrors();

                const formData = new FormData(this);
                $('#btnSubmit').prop('disabled', true);

                $.ajax({
                    url: storeUrl,
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
                            text: res?.message || 'Driver created successfully',
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

                        const msg = xhr.responseJSON?.message || 'Failed to create driver';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg, confirmButtonText: 'OK' });
                    }
                });
            });
        });
    </script>
@endpush
