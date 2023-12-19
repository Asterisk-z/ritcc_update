@extends('layouts.app')
@section('title','RITCC Profile Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        @include('fmdq.profile.cards')
        @include('fmdq.profile.buttons')
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
                                        <td>{{ $profile->firstName.' '.$profile->lastName }}</td>
                                        <td>{{ $profile->email }}</td>
                                        <td>{{ $profile->package->Name }}</td>
                                        <td>{{ date('F d, Y',strtotime($profile->inputDate))}}</td>
                                        @if ($profile->status ==='0')
                                        <td><span class="badge bg-3">Pending Approval</span></td>
                                        @elseif($profile->status ==='1')
                                        <td><span class="badge bg-1">Approved</span></td>
                                        @elseif($profile->status ==='2')
                                        <td><span class="badge bg-2">Rejected</span></td>
                                        @elseif ($profile->status ==='3')
                                        <td><span class="badge bg-3">Pending Update</span></td>
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
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                        @if ($user->type ==='authoriser' || $user->type ==='super')
                                                        @if ($profile->status === '0')
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approve{{ $profile->id }}" href=""><i
                                                                    class="fa fa-check me-2"></i>Approve </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#reject{{ $profile->id }}" href=""><i
                                                                    class="fa fa-times me-2"></i>Reject</a>
                                                        </li>
                                                        @elseif ($profile->status === '3')
                                                        <li>
                                                            {{--
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#viewUpdate{{ $profile->id }}"
                                                                href=""><i class="far fa-edit me-2"></i>View Update</a>
                                                        </li> --}}
                                                        <a class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#approveUpdate{{ $profile->id }}" href=""><i
                                                                class="fa fa-check me-2"></i>Approve
                                                            Update</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectUpdate{{ $profile->id }}"
                                                                href=""><i class="fa fa-times me-2"></i>Reject
                                                                Update</a>
                                                        </li>
                                                        @elseif ($profile->status === '4')
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approveDelete{{ $profile->id }}"
                                                                href=""><i class="fa fa-check me-2"></i>Approve
                                                                Delete</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectDelete{{ $profile->id }}"
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
                                        <div id="view{{ $profile->id }}" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="standard-modalLabel">View
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
                                                            <br>
                                                            <h6>REJECTED BY: <strong>{{
                                                                    $profile->authoriser ?? 'No
                                                                    information available'
                                                                    }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>REJECTED REASON: <strong>{{
                                                                    $profile->rejectReason ?? 'No
                                                                    information available'
                                                                    }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>REJECTED DATE: <strong>{{
                                                                    date('F d, Y',strtotime( $profile->authoriserDate))
                                                                    ?? 'No
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
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-lg"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- approve --}}
                                        <div id="approve{{ $profile->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="standard-modalLabel">Approve
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('profile.approveCreate',$profile->id) }}"
                                                        method="POST" class="needs-validation" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <h6 class="text-center">Are you sure you want to approve
                                                                this
                                                                profile?</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                onclick="changeText(this);">Approve</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- reject --}}
                                        <div id="reject{{ $profile->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="standard-modalLabel">Approve
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('profile.rejectCreate',$profile->id) }}"
                                                        method="POST" class="needs-validation" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <h6 class="text-center">Are you sure you want to reject
                                                                this
                                                                profile?</h6>
                                                            <label for="">Reason for Rejection</label>
                                                            <input type="text" class="form-control" name="reason"
                                                                required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                onclick="changeText(this);">Reject</button>
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