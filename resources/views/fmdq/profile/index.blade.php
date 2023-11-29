@extends('layouts.app')
@section('title','RITCC Profile Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        <div class="row">
            {{-- all --}}
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-4">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">All Profiles</div>
                                <div class="dash-counts">
                                    <p>{{ $all }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- pending --}}
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-3">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Pending Profiles</div>
                                <div class="dash-counts">
                                    <p>{{ $pending }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- approved --}}
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-1">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Approved Profiles</div>
                                <div class="dash-counts">
                                    <p>{{ $approved }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- rejected --}}
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-2">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Rejected Profiles</div>
                                <div class="dash-counts">
                                    <p>{{ $rejected }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- --}}
        <div class="page-header">
            <div class="content-page-header">
                @if (auth()->user()->type ==='inputter')
                {{-- <h5>Pages list</h5> --}}
                <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal"
                    data-bs-target="#standard-modal"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add
                    Profile
                </button>
                {{-- modal --}}
                <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="standard-modalLabel">Create Profile</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('inputter.profile.create') }}" method="POST" id="myForm"
                                class="needs-validation" novalidate>
                                @csrf
                                <div class="modal-body">
                                    <div class="form-row row">
                                        {{-- code --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">First Name</label>
                                            <input type="text" name="firstName" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Last Name</label>
                                            <input type="text" name="lastName" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Email Address</label>
                                            <input type="email" name="email" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Package</label>
                                            <select name="package" id="packageSelect" class="form-control" required>
                                                <option value="">--Select--</option>
                                                @foreach ($packages as $package)
                                                <option value="{{ $package->ID }}">{{ $package->Name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Institution</label>
                                            <select name="institution" id="validationCustom01" class="form-control"
                                                required>
                                                <option value="">--Select--</option>
                                                @foreach ($institutions as $institution)
                                                <option value="{{ $institution->ID }}">{{ $institution->institutionName
                                                    }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Authoriser</label>
                                            <select name="authoriser" id="validationCustom01" class="form-control"
                                                required>
                                                <option value="">--Select--</option>
                                                @forelse ($authorisers as $authoriser)
                                                <option value="{{ $authoriser->email }}">{{ $authoriser->firstName.'
                                                    '.$authoriser->lastName }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="role">RTGS Account
                                                    Number</label>
                                                <input type="number" class="form-control" min="0" name="RTGS"
                                                    placeholder="Leave empty if profile is an FMDQ Profile">
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="role">FMDQ Depository
                                                    Custodian Account Number</label>
                                                <input type="number" class="form-control" min="0"
                                                    placeholder="Leave empty if profile is an FMDQ Profile" name="FMDQ">
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div id="accountNumber" style="display: none;">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="role">RTGS Account
                                                        Number</label>
                                                    <input type="number" class="form-control" min="0" name="RTGS"
                                                        placeholder="Leave empty if profile is an FMDQ Profile"
                                                        required>
                                                    <div class="invalid-feedback">
                                                        This field is required
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="role">FMDQ Depository
                                                        Custodian Account Number</label>
                                                    <input type="number" class="form-control" min="0"
                                                        placeholder="Leave empty if profile is an FMDQ Profile"
                                                        name="FMDQ" required>
                                                    <div class="invalid-feedback">
                                                        This field is required
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Create
                                        Profile</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- --}}
                @endif

                <div class="list-btn">
                    {{-- iqx --}}
                    @if (auth()->user()->type ==='super')
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="{{ route('profile.index') }}"><i class="fas fa-users me-2"
                                    aria-hidden="true"></i>All</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('profile.pending')}}"><i
                                    class="fa fa-pause me-2" aria-hidden="true"></i>Pending</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('profile.approved') }}"><i
                                    class="fa fa-check me-2" aria-hidden="true"></i>Approved</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('profile.rejected') }}"><i
                                    class="fa fa-times me-2" aria-hidden="true"></i>Rejected</a>
                        </li>
                    </ul>
                    @endif

                    {{-- inputter --}}
                    @if (auth()->user()->type ==='inputter')
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="{{ route('inputter.profile.index') }}"><i
                                    class="fas fa-users me-2" aria-hidden="true"></i>All</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('inputter.profile.pending')}}"><i
                                    class="fa fa-pause me-2" aria-hidden="true"></i>Pending</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('inputter.profile.approved') }}"><i
                                    class="fa fa-check me-2" aria-hidden="true"></i>Approved</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('inputter.profile.rejected') }}"><i
                                    class="fa fa-times me-2" aria-hidden="true"></i>Rejected</a>
                        </li>
                    </ul>
                    @endif

                    {{-- authoriser --}}
                    @if (auth()->user()->type ==='authoriser')
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="{{ route('authoriser.profile.index') }}"><i
                                    class="fas fa-users me-2" aria-hidden="true"></i>All</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('authoriser.profile.pending')}}"><i
                                    class="fa fa-pause me-2" aria-hidden="true"></i>Pending</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('authoriser.profile.approved') }}"><i
                                    class="fa fa-check me-2" aria-hidden="true"></i>Approved</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('authoriser.profile.rejected') }}"><i
                                    class="fa fa-times me-2" aria-hidden="true"></i>Rejected</a>
                        </li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        {{-- --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-center table-stripped table-bordered" id="example1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Package</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($profiles as $profile)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $profile->firstName .' '.$profile->lastName }}</td>
                                        <td>{{ $profile->email }}</td>
                                        <td>{{ $profile->package->Name }}</td>
                                        <td>{{ date('F d, Y',strtotime($profile->inputDate))}}</td>
                                        @if ($profile->status ==='0')
                                        <td><span class="badge bg-3">Pending Approval</span></td>
                                        @elseif($profile->status ==='1')
                                        <td><span class="badge bg-1">Approved</span></td>
                                        @elseif($profile->status ==='2')
                                        <td><span class="badge bg-2">Rejected</span></td>
                                        @elseif($profile->status ==='4')
                                        <td><span class="badge bg-3">Pending Delete</span></td>
                                        @endif
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#view{{ $profile->id }}" href=""><i
                                                                    class="far fa-eye me-2"></i>View</a>
                                                        </li>
                                                        @if (!($profile->status === '0'|| $profile->status ===
                                                        '4'))
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete{{ $profile->id }}" href=""><i
                                                                    class="far fa-trash-alt me-2"></i>Deactivate</a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- view --}}
                                        <div class="modal fade" id="view{{ $profile->id }}" tabindex="-1" role="dialog"
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
                                                    <div class="modal-body">
                                                        <div class="card-text">
                                                            <h6>NAME: <strong>{{ $profile->firstName.'
                                                                    '.$profile->lastName }}</strong></h6>
                                                            <br>
                                                            <h6>CONTACT EMAIL: <strong>{{ $profile->email }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>CONTACT PHONE NUMBER: <strong>{{ $profile->mobile ?? 'No
                                                                    information available'
                                                                    }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>PACKAGE: <strong>{{ $profile->package->Name ?? 'No
                                                                    information available'
                                                                    }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>INSTIUTION: <strong>{{
                                                                    $profile->institution->institutionName ?? 'No
                                                                    information available'
                                                                    }}</strong>
                                                            </h6>
                                                            <hr>
                                                            <h6>CREATED BY: <strong>{{
                                                                    $profile->inputter ?? 'No
                                                                    information available'
                                                                    }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>CREATED DATE: <strong>{{
                                                                    date('F d, Y',strtotime( $profile->inputDate)) ??
                                                                    'No
                                                                    information available'
                                                                    }}</strong>
                                                            </h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-lg"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- --}}
                                        {{-- <div class="modal fade" id="delete{{ $profile->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myCenterModalLabel">Center modal
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('deactivateProfile',$profile->id) }}"
                                                        method="POST" class="needs-validation" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-row row">
                                                                <div class="col-lg-12 mb-3">
                                                                    <label for="validationCustom01">Package Name</label>
                                                                    <input type="text" name="reason"
                                                                        class="form-control" id="validationCustom01"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Deactivate
                                                                Profile</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> --}}
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