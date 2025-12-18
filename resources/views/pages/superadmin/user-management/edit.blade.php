@extends('layouts.master-super')

@section('title', 'Edit User')
@section('subtitle', 'Edit User')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h4 class="mb-0">Edit User</h4>
                            <p class="text-muted mb-0">
                                Update user information below. (ID: {{ $user->id }})
                            </p>
                        </div>

                        <a href="{{ route('superadmin.user-management.index') }}" class="btn btn-light">
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
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username"
                                           value="{{ old('username', $user->username) }}" placeholder="username">
                                    <div class="invalid-feedback" data-error-for="username"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="fullname"
                                           value="{{ old('fullname', $user->fullname) }}" placeholder="John Doe">
                                    <div class="invalid-feedback" data-error-for="fullname"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email"
                                           value="{{ old('email', $user->email) }}" placeholder="email@example.com">
                                    <div class="invalid-feedback" data-error-for="email"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Password <small class="text-muted">(optional)</small>
                                    </label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="Leave empty if unchanged">
                                    <div class="invalid-feedback" data-error-for="password"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select" name="role">
                                        <option value="">-- Choose role --</option>
                                        <option value="SUPERADMIN" @selected(old('role', $user->role) === 'SUPERADMIN')>SUPERADMIN</option>
                                        <option value="ADMIN" @selected(old('role', $user->role) === 'ADMIN')>ADMIN</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="role"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Photo <small class="text-muted">(optional)</small></label>
                                    <input type="file" class="form-control" name="photo_text" accept="image/*">
                                    <div class="invalid-feedback" data-error-for="photo_text"></div>

                                    @if($user->photo_text)
                                        <small class="text-muted d-block mt-1">
                                            Current:
                                            <a href="{{ asset('storage/' . $user->photo_text) }}" target="_blank" rel="noopener">
                                                View Photo
                                            </a>
                                        </small>
                                    @else
                                        <small class="text-muted d-block mt-1">No photo uploaded.</small>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Active <span class="text-danger">*</span></label>
                                    <select class="form-select" name="is_active">
                                        <option value="1" @selected((string)old('is_active', (int)$user->is_active) === '1')>Active</option>
                                        <option value="0" @selected((string)old('is_active', (int)$user->is_active) === '0')>Inactive</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="is_active"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">NIPEG (optional)</label>
                                    <input type="text" class="form-control" name="nipeg"
                                           value="{{ old('nipeg', $user->nipeg) }}" placeholder="nipeg">
                                    <div class="invalid-feedback" data-error-for="nipeg"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone Number (optional)</label>
                                    <input type="text" class="form-control" name="phone_num"
                                           value="{{ old('phone_num', $user->phone_num) }}" placeholder="08xx / 62xx">
                                    <div class="invalid-feedback" data-error-for="phone_num"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Reference Code (optional)</label>
                                    <input type="text" class="form-control" name="reference_code"
                                           value="{{ old('reference_code', $user->reference_code) }}" placeholder="reference code">
                                    <div class="invalid-feedback" data-error-for="reference_code"></div>
                                </div>

                                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('superadmin.user-management.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        <i class="bi bi-save me-1"></i> Update User
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
            const updateUrl = @json(route('superadmin.user-management.update', $user->id));
            const indexUrl  = @json(route('superadmin.user-management.index'));

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
                    method: 'POST', // pakai POST + _method=PUT
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
                            text: res?.message || 'User updated successfully',
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

                        const msg = xhr.responseJSON?.message || 'Failed to update user';

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
