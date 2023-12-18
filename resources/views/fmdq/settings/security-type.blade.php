@extends('layouts.app')
@section('title','RITCC System Settings | Security Types')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- tables --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal"
                            data-bs-target="#standard-modal"><i class="fa fa-plus-circle me-2"
                                aria-hidden="true"></i>Add Security Type
                        </button>
                        {{-- modal --}}
                        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                            aria-labelledby="standard-modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        {{-- <h4 class="modal-title" id="standard-modalLabel">Create Profile</h4> --}}
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('storeSecurityType') }}" method="POST" id="create"
                                        class="needs-validation confirmation" novalidate>
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-row row">
                                                {{-- --}}
                                                <div class="col-lg-12 mb-3">
                                                    <label for="validationCustom01">Code</label>
                                                    <input type="text" name="securityTypeCode" class="form-control"
                                                        id="validationCustom01" required>
                                                    <div class="invalid-feedback">
                                                        This field is required
                                                    </div>
                                                </div>
                                                {{-- --}}
                                                <div class="col-lg-12 mb-3">
                                                    <label for="validationCustom01">Description</label>
                                                    <input type="text" name="description" class="form-control"
                                                        id="validationCustom01" required>
                                                    <div class="invalid-feedback">
                                                        This field is required
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Create</button>
                                            &nbsp;&nbsp;&nbsp;
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-stripped" id="example2">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($types as $type)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $type->securityTypeCode }}</td>
                                        <td>{{ $type->description }}</td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        @if ($user->type === 'super' || $user->type === 'inputter')
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $type->id }}" href=""><i
                                                                    class="fa fa-edit me-2"></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete{{ $type->id }}" href=""><i
                                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- --}}
                                        <div class="modal fade" id="edit{{ $type->id }}" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="myCenterModalLabel">Center
                                                            modal
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('updateSecurityType') }}" method="POST"
                                                        class="needs-validation confirmation" novalidate>
                                                        @csrf
                                                        {{-- --}}
                                                        <input type="hidden" value="{{ $type->id }}" name="id">
                                                        <div class="modal-body">
                                                            <div class="form-row row">
                                                                {{-- --}}
                                                                <input type="hidden" name="id" value="{{ $type->id }}">
                                                                <div class="col-lg-12 mb-3">
                                                                    <label for="validationCustom01">Code</label>
                                                                    <input type="text" name="securityTypeCode"
                                                                        value="{{ $type->securityTypeCode }}"
                                                                        class="form-control" id="validationCustom01"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-lg-12 mb-3">
                                                                    <label for="validationCustom01">Description</label>
                                                                    <input type="type" name="description"
                                                                        value="{{ $type->description }}"
                                                                        class="form-control" id="validationCustom01"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary">Update</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="modal fade" id="delete{{ $type->id }}" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="myCenterModalLabel">Center
                                                            modal
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('deleteSecurityType') }}" method="POST"
                                                        class="needs-validation confirmation" novalidate>
                                                        @csrf
                                                        {{-- --}}
                                                        <input type="hidden" value="{{ $type->id }}" name="id">
                                                        <div class="modal-body">
                                                            <div class="form-row row">
                                                                {{-- --}}
                                                                <div class="col-lg-12 mb-3">
                                                                    <label for="validationCustom01">Reason</label>
                                                                    <input type="text" name="reason"
                                                                        class="form-control" id="validationCustom01"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary">Delete</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection