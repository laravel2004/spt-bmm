@extends('layouts.master-super')

@section('title', 'Edit Customer')
@section('subtitle', 'Edit Customer')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h4 class="mb-0">Edit Customer</h4>
                            <p class="text-muted mb-0">
                                Update transportir information below. (ID: {{ $customer->id }})
                            </p>
                        </div>

                        <a href="{{ route('superadmin.customer.index') }}" class="btn btn-light">
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
                                    <label class="form-label">Customer Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="cust_code"
                                           value="{{ old('cust_code', $customer->cust_code) }}" placeholder="BMM123QWE">
                                    <div class="invalid-feedback" data-error-for="cust_code"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" name="cust_name"
                                           value="{{ old('cust_name', $customer->cust_name) }}" placeholder="1000">
                                    <div class="invalid-feedback" data-error-for="cust_name"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address"
                                           value="{{ old('address', $customer->address) }}" placeholder="1000">
                                    <div class="invalid-feedback" data-error-for="address"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Active <span class="text-danger">*</span></label>
                                    <select class="form-select" name="is_active">
                                        <option value="1" @selected((string)old('is_active', (int)$customer->is_active) === '1')>Active</option>
                                        <option value="0" @selected((string)old('is_active', (int)$customer->is_active) === '0')>Inactive</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="is_active"></div>
                                </div>

                                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('superadmin.customer.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        <i class="bi bi-save me-1"></i> Update Customer
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
            const updateUrl = @json(route('superadmin.customer.update', $customer->id));
            const indexUrl  = @json(route('superadmin.customer.index'));

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
                            text: res?.message || 'Customer updated successfully',
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

                            console.log(errors);
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: 'Please check the highlighted fields.',
                                confirmButtonText: 'OK'
                            });

                            return;
                        }

                        const msg = xhr.responseJSON?.message || 'Failed to update customer';

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
