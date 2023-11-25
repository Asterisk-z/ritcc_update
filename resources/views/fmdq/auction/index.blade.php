@extends('layouts.app')
@section('title','RITCC Institution Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        <div class="row">
            {{-- all --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-4">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">All Auctions</div>
                                <div class="dash-counts">
                                    <p>{{ $all }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- pending --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-3">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Pending Auctions</div>
                                <div class="dash-counts">
                                    <p>{{ $pending }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- approved --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-1">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Approved Auctions</div>
                                <div class="dash-counts">
                                    <p>{{ $approved }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- rejected --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-2">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Rejected Auctions</div>
                                <div class="dash-counts">
                                    <p>{{ $rejected }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- rejected --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-2">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Running Auctions</div>
                                <div class="dash-counts">
                                    <p>{{ $rejected }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- rejected --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-2">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Closed Auctions</div>
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
                {{-- <h5>Pages list</h5> --}}
                <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal"
                    data-bs-target="#standard-modal"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Auction</button>
                {{-- modal --}}
                <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="standard-modalLabel">Add Auction</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('institution.create') }}" method="POST" id="myForm"
                                class="needs-validation" novalidate>
                                @csrf
                                <div class="modal-body">
                                    <div class="form-row row">
                                        {{-- code --}}
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom01">Security</label>
                                            <select name="securityId" id="validationCustom01" class="form-control"
                                                required>
                                                <option value="">--Select--</option>
                                                @forelse ($securities as $security)
                                                <option value="{{ $security->id }}">{{ $security->securityCode ." | ".$security->auctioneer->email }}</option>
                                                @empty

                                                @endforelse
                                            </select>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Offer Amount ((₦‘mm)</label>
                                            <input type="text" name="amount" class="form-control" id="validationCustom01"
                                                required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Offer Date</label>
                                            <input type="date" name="offerDate" class="form-control" id="validationCustom01"
                                                required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Auction Start Time</label>
                                            <input type="datetime-local" name="auction_start_time" class="form-control" id="validationCustom01"
                                                required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Bids Close Time</label>
                                            <input type="datetime-local" name="bids_close_time" class="form-control" id="validationCustom01"
                                                required>
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

                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="{{ route('institution.index') }}"><i
                                    class="fas fa-users me-2" aria-hidden="true"></i>All</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('institution.pending') }}"><i
                                    class="fa fa-pause me-2" aria-hidden="true"></i>Pending</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{ route('institution.approved') }}"><i
                                    class="fa fa-check me-2" aria-hidden="true"></i>Approved</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="{{route('institution.rejected') }}"><i
                                    class="fa fa-times me-2" aria-hidden="true"></i>Rejected</a>
                        </li>
                    </ul>
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
                                                        @if (!($institution->status === '0'||$institution->status ===
                                                        '3' || $institution->status ===
                                                        '4'))

                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $institution->ID }}" href=""><i
                                                                    class="far fa-edit me-2"></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete{{ $institution->ID }}"
                                                                href=""><i class="far fa-trash-alt me-2"></i>Delete</a>
                                                        </li>

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
                                                        {{-- <h4 class="modal-title" id="standard-modalLabel">View
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h6>Institution Code: <strong class="text-uppercase">{{
                                                                    $institution->code
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Institution Name: <strong class="text-uppercase">{{
                                                                    $institution->institutionName
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Institution Address: <strong class="text-uppercase">{{
                                                                    $institution->address
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Institution Email: <strong class="text-uppercase">{{
                                                                    $institution->institutionEmail
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Chief Dealer Email: <strong class="text-uppercase">{{
                                                                    $institution->chiefDealerEmail
                                                                    }}</strong></h6>
                                                            <br><br>

                                                            @if ($institution->status === '1' || $institution->status
                                                            === '3' || $institution->status === '4')
                                                            <h6>Approved by: <strong class="text-uppercase">{{
                                                                    $institution->approvedBy
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Approved Date: <strong class="text-uppercase">{{
                                                                    date('F d, Y',
                                                                    strtotime($institution->approvedDate))
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            @elseif($institution->status === '2')
                                                            <h6>Reason: <strong class="text-uppercase">{{
                                                                    $institution->reason
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Rejected By: <strong class="text-uppercase">{{
                                                                    $institution->approvedBy
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6 class="text-uppercase">Rejected Date: <strong>{{
                                                                    date('F d, Y',
                                                                    strtotime($institution->approvedDate))
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            @endif
                                                            <h6>Created by: <strong class="text-uppercase">{{
                                                                    $institution->createdBy
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Created Date: <strong class="text-uppercase">{{ date('F
                                                                    d,Y',strtotime($institution->createdDate))}}</strong>
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
                                        {{-- edit --}}
                                        <div id="edit{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Update
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    {{--  <form action="{{ route('institution.update',$institution->ID) }}"
                                                        method="POST" class="needs-validation" id="update" novalidate>  --}}
                                                    <form action="#"
                                                        method="POST" class="needs-validation" id="update" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-row row">
                                                                {{-- code --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Institution
                                                                        Code</label>
                                                                    <input type="text" name="code" class="form-control"
                                                                        id="validationCustom01"
                                                                        value="{{ $institution->code }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Institution
                                                                        Name</label>
                                                                    <input type="text" name="name" class="form-control"
                                                                        id="validationCustom01"
                                                                        value="{{ $institution->institutionName }}"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Address</label>
                                                                    <input type="text" name="address"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $institution->address }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- code --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Institution
                                                                        Email</label>
                                                                    <input type="email" name="institutionEmail"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $institution->institutionEmail }}"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Chief Dealer
                                                                        Email</label>
                                                                    <input type="email" name="chiefDealerEmail"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $institution->chiefDealerEmail }}"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Authoriser</label>
                                                                    <select name="authoriser" id="validationCustom01"
                                                                        class="form-control" required>
                                                                        <option value="">--Select--</option>
                                                                        @forelse ($authorisers as $authoriser)
                                                                        <option value="{{ $authoriser->email }}">{{
                                                                            $authoriser->firstName.'
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
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Update</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- delete --}}
                                        <div id="delete{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Delete
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="#"
                                                        method="POST" class="needs-validation" id="myForm" novalidate>
                                                    {{--  <form action="{{ route('institution.delete',$institution->ID) }}"
                                                        method="POST" class="needs-validation" id="myForm" novalidate>  --}}
                                                        @csrf
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this institution?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Delete
                                                                Institution</button>
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


@section('style')

@endsection


@section('script')

<script>
    //$(function() {
        //$('.OfferDateX').datetimepicker({
         //   timepicker: true,
         //   startDate: moment().format("YYYY/MM/D"),
        //    minDate: moment().format("YYYY/MM/D"),
        //    format: 'M d, Y H:i',
            // onSelectDate: function(dp, tp) {},
            // onSelectTime: function(dp, tp) {}
            // startDate: moment().format("YYYY/MM/D")
        //});

        // let offerDate = $('#OfferDate').val();

        //$('#OfferDate').change(function(event) {
        //    if (!$('#OfferDate').val()) {
        //        return
        //    }
        //     $('#AuctionStartTime').prop('disabled', false)
        //});

        //$('#AuctionStartTime').change(function(event) {

        //    if (!$('#OfferDate').val()) {
        //        $('#AuctionStartTime').val('')
        //        $('#AuctionStartTime').prop('disabled', true)
        //        return
        //    }

        //    let offerDate = moment(new Date($('#OfferDate').val())).valueOf();
        //    let auctionStartTime = moment(new Date($('#AuctionStartTime').val())).valueOf();

        //    console.dir(offerDate)
        //    console.dir(auctionStartTime)
        //    console.log(auctionStartTime > offerDate)
        //    if (offerDate < auctionStartTime) {
        //        swal("Auction Start Date can not be less than Offer date");
        //        return
        //    }


        //    $('#BidsCloseTime').prop('disabled', false)

        //});


        //$('#BidsCloseTimeX').datetimepicker({
        //    timepicker: true,
        //    minDate: moment().format("YYYY/MM/D"),
        //    startDate: moment().format("YYYY/MM/D"),
        //    format: 'M d, Y  H:i',
        //});


    //})
</script>

@endsection