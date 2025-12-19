@extends('layouts.master-super')

@section('title', 'Edit Mapping Transportir')
@section('subtitle', 'Edit Mapping Transportir')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h4 class="mb-0">Edit Mapping Transportir</h4>
                            <p class="text-muted mb-0">Update driver dan transportir untuk mapping ini.</p>
                        </div>

                        <a href="{{ route('superadmin.mapping-transportir.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-light-success d-none" id="successBox"></div>
                        <div class="alert alert-light-danger d-none" id="errorBox"></div>

                        <form id="formEditMapping">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">

                            <div class="row g-3">
                                {{-- DRIVER --}}
                                <div class="col-md-6">
                                    <label class="form-label">Driver <span class="text-danger">*</span></label>
                                    <select class="form-select" name="driver_id">
                                        <option value="">-- Select Driver --</option>
                                        @foreach($drivers as $d)
                                            <option value="{{ $d->id }}" @selected((string)$mapping->driver_id === (string)$d->id)>
                                                {{ $d->fullname ?? '-' }} ({{ $d->phone_num ?? '-' }})
                                                — {{ (int)($d->is_active ?? 0) === 1 ? 'Active' : 'Inactive' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" data-error-for="driver_id"></div>
                                </div>

                                {{-- TRANSPORTIR --}}
                                <div class="col-md-6">
                                    <label class="form-label">Transportir <span class="text-danger">*</span></label>
                                    <select class="form-select" name="transportir_id">
                                        <option value="">-- Select Transportir --</option>
                                        @foreach($transportirs as $t)
                                            <option value="{{ $t->id }}" @selected((string)$mapping->transportir_id === (string)$t->id)>
                                                {{ $t->code ?? '-' }} — {{ $t->tranportir_name ?? '-' }}
                                                — {{ (int)($t->is_active ?? 0) === 1 ? 'Active' : 'Inactive' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" data-error-for="transportir_id"></div>
                                </div>

                                {{-- STATUS --}}
                                <div class="col-md-12">
                                    <label class="form-label">Active <span class="text-danger">*</span></label>
                                    <select class="form-select" name="is_active">
                                        <option value="1" @selected((string)($mapping->is_active ?? 1) === "1")>Active</option>
                                        <option value="0" @selected((string)($mapping->is_active ?? 1) === "0")>Inactive</option>
                                    </select>
                                    <div class="invalid-feedback" data-error-for="is_active"></div>
                                </div>

                                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('superadmin.mapping-transportir.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        <i class="bi bi-save me-1"></i> Update Mapping
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
            const updateUrl = @json(route('superadmin.mapping-transportir.update', $mapping->id));
            const indexUrl  = @json(route('superadmin.mapping-transportir.index'));

            function resetFieldErrors() {
                $('#formEditMapping .is-invalid').removeClass('is-invalid');
                $('#formEditMapping [data-error-for]').text('');
            }

            function setFieldError(field, message) {
                const $input = $('#formEditMapping [name="' + field + '"]');
                $input.addClass('is-invalid');
                $('#formEditMapping [data-error-for="' + field + '"]').text(message);
            }

            $('#formEditMapping').on('submit', function (e) {
                e.preventDefault();
                resetFieldErrors();

                const formData = new FormData(this);
                $('#btnSubmit').prop('disabled', true);

                $.ajax({
                    url: updateUrl,
                    method: 'POST', // pakai POST + _method=PUT
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
                            text: res?.message || 'Mapping updated successfully',
                            showConfirmButton: true,
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

                        const msg = xhr.responseJSON?.message || 'Failed to update mapping';

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
