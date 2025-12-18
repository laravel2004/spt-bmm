@extends('layouts.master-super')

@section('title', 'Add Customer')
@section('subtitle', 'Add Customer')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h4 class="mb-0">Create New Customer</h4>
                            <p class="text-muted mb-0">Fill the form below to add a new customer.</p>
                        </div>

                        <a href="{{ route('superadmin.transportir.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-light-success d-none" id="successBox"></div>
                        <div class="alert alert-light-danger d-none" id="errorBox"></div>

                        <form id="formAddUser" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Customer Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="cust_code" placeholder="BMM123QWE">
                                    <div class="invalid-feedback" data-error-for="cust_code"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Customer Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="cust_name" placeholder="PT Berkah Manis Makmur">
                                    <div class="invalid-feedback" data-error-for="cust_name"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address" placeholder="Jl. Ir Soekarno No.123">
                                    <div class="invalid-feedback" data-error-for="address"></div>
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
                                    <a href="{{ route('superadmin.transportir.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        <i class="bi bi-save me-1"></i> Save Customer
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
            const storeUrl = @json(route('superadmin.customer.store'));
            const indexUrl = @json(route('superadmin.customer.index'));

            function resetFieldErrors() {
                $('#formAddUser .is-invalid').removeClass('is-invalid');
                $('#formAddUser [data-error-for]').text('');
            }

            function setFieldError(field, message) {
                const $input = $('#formAddUser [name="' + field + '"]');
                $input.addClass('is-invalid');
                $('#formAddUser [data-error-for="' + field + '"]').text(message);
            }

            $('#formAddUser').on('submit', function (e) {
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
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function (res) {
                        $('#btnSubmit').prop('disabled', false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res?.message || 'Customer created successfully',
                            showConfirmButton: true,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = indexUrl;
                        });
                    },
                    error: function (xhr) {
                        $('#btnSubmit').prop('disabled', false);

                        // Validation error
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

                        // Other errors (500, 403, etc.)
                        const msg = xhr.responseJSON?.message || 'Failed to create customer';

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

