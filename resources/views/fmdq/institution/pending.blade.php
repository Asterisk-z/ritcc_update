@extends('layouts.app')
@section('title','RITCC Institution Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        @include('fmdq.institution.cards')
        @include('fmdq.institution.buttons')
        {{-- --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-center table-stripped table-bordered" id="example1">
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
                                    @foreach ($institutions as $institution)
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


@section('script')
<script>

</script>
@endsection