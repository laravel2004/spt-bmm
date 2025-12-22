@extends('layouts.master-super')

@section('title', 'Add User')
@section('subtitle', 'Add User')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h4 class="mb-0">Create New User</h4>
                            <p class="text-muted mb-0">Fill the form below to add a new user.</p>
                        </div>

                        <a href="{{ route('admin.user-management.index') }}" class="btn btn-light">
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
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" placeholder="username">
                                    <div class="invalid-feedback" data-error-for="username"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="fullname" placeholder="John Doe">
                                    <div class="invalid-feedback" data-error-for="fullname"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" placeholder="email@example.com">
                                    <div class="invalid-feedback" data-error-for="email"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" placeholder="min 8 chars">
                                    <div class="invalid-feedback" data-error-for="password"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select" name="role">
                                        <option value="">-- Choose role --</option>
                                        <option value="ADMIN">ADMIN</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="role"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Photo (optional)</label>
                                    <input type="file" class="form-control" name="photo_text" accept="image/*">
                                    <div class="invalid-feedback" data-error-for="photo_text"></div>
                                    <small class="text-muted">Max 2MB, image only</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Active <span class="text-danger">*</span></label>
                                    <select class="form-select" name="is_active">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="is_active"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">NIPEG (optional)</label>
                                    <input type="text" class="form-control" name="nipeg" placeholder="nipeg">
                                    <div class="invalid-feedback" data-error-for="nipeg"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone Number (optional)</label>
                                    <input type="text" class="form-control" name="phone_num" placeholder="08xx / 62xx">
                                    <div class="invalid-feedback" data-error-for="phone_num"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Reference Code (optional)</label>
                                    <input type="text" class="form-control" name="reference_code" placeholder="reference code">
                                    <div class="invalid-feedback" data-error-for="reference_code"></div>
                                </div>

                                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('admin.user-management.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        <i class="bi bi-save me-1"></i> Save User
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
            const storeUrl = @json(route('admin.user-management.store'));
            const indexUrl = @json(route('admin.user-management.index'));

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
                            text: res?.message || 'User created successfully',
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
                        const msg = xhr.responseJSON?.message || 'Failed to create user';

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

