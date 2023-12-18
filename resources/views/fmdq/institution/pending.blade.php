@extends('layouts.app')
@section('title','RITCC Institution Management')

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
                                <div class="dash-title">All Institutions</div>
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
                                <div class="dash-title">Pending Institutions</div>
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
                                <div class="dash-title">Approved Institutions</div>
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
                                <div class="dash-title">Rejected Institutions</div>
                                <div class="dash-counts">
                                    <p>{{ $rejected }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- tables --}}
        {{-- --}}
        <div class="page-header">
            <div class="content-page-header">
                @if (auth()->user()->type === 'inputter')
                {{-- <h5>Pages list</h5> --}}
                <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal"
                    data-bs-target="#standard-modal"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add
                    Institution</button>
                {{-- modal --}}
                <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="standard-modalLabel">Add Institution</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('inputter.institution.create') }}" method="POST" id="myForm"
                                class="needs-validation" novalidate>
                                @csrf
                                <div class="modal-body">
                                    <div class="form-row row">
                                        {{-- code --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Institution Code</label>
                                            <input type="text" name="code" class="form-control" id="validationCustom01"
                                                required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Institution Name</label>
                                            <input type="text" name="name" class="form-control" id="validationCustom01"
                                                required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom01">Address</label>
                                            <input type="text" name="address" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- code --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Institution Email</label>
                                            <input type="email" name="institutionEmail" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Chief Dealer Email</label>
                                            <input type="email" name="chiefDealerEmail" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
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
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Create Institution</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <div class="list-btn">
                    {{-- iqx --}}
                    @if (auth()->user()->type ==='super')
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('institution.index') }}"><i
                                    class="fas fa-users me-2" aria-hidden="true"></i>All</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="{{ route('institution.pending')}}"><i
                                    class="fa fa-pause me-2" aria-hidden="true"></i>Pending</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('institution.approved') }}"><i
                                    class="fa fa-check me-2" aria-hidden="true"></i>Approved</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('institution.rejected') }}"><i
                                    class="fa fa-times me-2" aria-hidden="true"></i>Rejected</a>
                        </li>
                    </ul>
                    @endif

                    {{-- inputter --}}
                    @if (auth()->user()->type ==='inputter')
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('inputter.institution.index') }}"><i
                                    class="fas fa-users me-2" aria-hidden="true"></i>All</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="{{ route('inputter.institution.pending')}}"><i
                                    class="fa fa-pause me-2" aria-hidden="true"></i>Pending</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('inputter.institution.approved') }}"><i
                                    class="fa fa-check me-2" aria-hidden="true"></i>Approved</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('inputter.institution.rejected') }}"><i
                                    class="fa fa-times me-2" aria-hidden="true"></i>Rejected</a>
                        </li>
                    </ul>
                    @endif

                    {{-- authoriser --}}
                    @if (auth()->user()->type ==='authoriser')
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('authoriser.institution.index') }}"><i
                                    class="fas fa-users me-2" aria-hidden="true"></i>All</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="{{ route('authoriser.institution.pending')}}"><i
                                    class="fa fa-pause me-2" aria-hidden="true"></i>Pending</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('authoriser.institution.approved') }}"><i
                                    class="fa fa-check me-2" aria-hidden="true"></i>Approved</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('authoriser.institution.rejected') }}"><i
                                    class="fa fa-times me-2" aria-hidden="true"></i>Rejected</a>
                        </li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        {{-- --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-center table-stripped table-bordered" id="example2">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        {{-- <th>Inputter</th> --}}
                                        {{-- <th>Authoriser</th> --}}
                                        <th>Date Created</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @forelse ($institutions as $institution)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $institution->code }}</td>
                                        <td>{{ $institution->institutionName }}</td>
                                        <td>{{ $institution->institutionEmail }}</td>
                                        <td>{{ date('F d, Y',strtotime($institution->createdDate))}}</td>
                                        @if ($institution->status ==='0')
                                        <td><span class="badge bg-3">Pending Approval</span></td>
                                        @elseif($institution->status ==='1')
                                        <td><span class="badge bg-1">Approved</span></td>
                                        @elseif($institution->status ==='2')
                                        <td><span class="badge bg-2">Rejected</span></td>
                                        @elseif ($institution->status ==='3')
                                        <td><span class="badge bg-3">Pending Update</span></td>
                                        @elseif($institution->status ==='4')
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
                                                                data-bs-target="#view{{ $institution->ID }}" href=""><i
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                        @if ($user->type ==='authoriser' || $user->type ==='super')
                                                        @if ($institution->status === '0')
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approve{{ $institution->ID }}"
                                                                href=""><i class="fa fa-check me-2"></i>Approve </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#reject{{ $institution->ID }}"
                                                                href=""><i class="fa fa-times me-2"></i>Reject</a>
                                                        </li>
                                                        @elseif ($institution->status === '3')
                                                        <li>
                                                            {{--
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#viewUpdate{{ $institution->ID }}"
                                                                href=""><i class="far fa-edit me-2"></i>View Update</a>
                                                        </li> --}}
                                                        <a class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#approveUpdate{{ $institution->ID }}"
                                                            href=""><i class="fa fa-check me-2"></i>Approve
                                                            Update</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectUpdate{{ $institution->ID }}"
                                                                href=""><i class="fa fa-times me-2"></i>Reject
                                                                Update</a>
                                                        </li>
                                                        @elseif ($institution->status === '4')
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approveDelete{{ $institution->ID }}"
                                                                href=""><i class="fa fa-check me-2"></i>Approve
                                                                Delete</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectDelete{{ $institution->ID }}"
                                                                href=""><i class="fa fa-times me-2"></i>Reject
                                                                Delete</a>
                                                        </li>
                                                        @endif

                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- view modal --}}
                                        <div id="view{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">View
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h6>Institution Code: <strong>{{ $institution->code
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Institution Name: <strong>{{
                                                                    $institution->institutionName
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Institution Address: <strong>{{ $institution->address
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Institution Email: <strong>{{
                                                                    $institution->institutionEmail
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Chief Dealer Email: <strong>{{
                                                                    $institution->chiefDealerEmail
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Inputter: <strong>{{
                                                                    $institution->createdBy
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Created Date: <strong>{{ date('F d,
                                                                    Y
                                                                    h:m:s',strtotime($institution->createdDate))}}</strong>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-lg"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- approve --}}
                                        <div id="approve{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="standard-modalLabel">Approve
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('authoriser.institution.approveCreate',$institution->ID) }}"
                                                        method="POST" class="needs-validation confirmation" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <h4>Are you sure you want to approve this
                                                                institution <strong>{{ $institution->institutionName
                                                                    }}</strong>?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary">Approve</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- reject --}}
                                        <div id="reject{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Reject
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('authoriser.institution.rejectCreate',$institution->ID) }}"
                                                        method="POST" class="needs-validation confirmation" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <label for="">Reason for Rejection</label>
                                                            <input type="text" name="reason" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-lg">Reject</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- approve update --}}
                                        <div id="approveUpdate{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Approve
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('authoriser.institution.approveUpdate',$institution->ID) }}"
                                                        method="POST" class="needs-validation confirmation" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <h5>Are you sure you want to approve this update?</h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary">Approve</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- reject update --}}
                                        <div id="rejectUpdate{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="standard-modalLabel">Reject
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('authoriser.institution.rejectUpdate',$institution->ID) }}"
                                                        method="POST" class="needs-validation confirmation" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <label for="">Reason for Rejection</label>
                                                            <input type="text" name="reason" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary">Reject</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- approve delete --}}
                                        <div id="approveDelete{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="standard-modalLabel">Approve
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('authoriser.institution.approveDelete',$institution->ID) }}"
                                                        method="POST" class="needs-validation confirmation" novalidate>
                                                        @csrf
                                                        <div class="modal-body text-center">
                                                            <h5>Are you sure you want to approve this delete?</h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Approve</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- reject delete --}}
                                        <div id="rejectDelete{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="standard-modalLabel">Reject
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('authoriser.institution.rejectDelete',$institution->ID) }}"
                                                        method="POST" class="needs-validation confirmation" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <label for="">Reason for Rejection</label>
                                                            <input type="text" name="reason" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary">Reject</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                    @empty
                                    {{ 'No information available yet' }}
                                    @endforelse
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


@section('script')
<script>

</script>
@endsection