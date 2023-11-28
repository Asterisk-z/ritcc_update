@extends('layouts.app')
@section('title','RITCC Institution Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        @include('fmdq.auction.widgets')
        {{-- tables --}}
        {{-- --}}
        <div class="page-header">
            <div class="content-page-header">

                <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#standard-modal"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Auction</button>
                {{-- modal --}}
                <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="standard-modalLabel">Add Auction</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('auction.mgt.create') }}" method="POST" id="myForm" class="needs-validation" novalidate>
                                @csrf
                                <div class="modal-body">
                                    <div class="form-row row">
                                        {{-- code --}}
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom01">Security</label>
                                            <select name="securityId" id="validationCustom01" class="form-control" required>
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
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Offer Date</label>
                                            <input type="date" name="offerDate" class="form-control" id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Auction Start Time</label>
                                            <input type="datetime-local" name="auction_start_time" class="form-control" id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Bids Close Time</label>
                                            <input type="datetime-local" name="bids_close_time" class="form-control" id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Bids Result Time</label>
                                            <input type="datetime-local" name="bids_result_time" class="form-control" id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Minimum Rate</label>
                                            <input type="number" name="minimum_rate" class="form-control" id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Maximum Rate</label>
                                            <input type="number" name="maximum_rate" class="form-control" id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Create Auction</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="list-btn">
                    @include('fmdq.auction.buttons')
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
                                        <th>Security Code</th>
                                        <th>Auctioneer</th>
                                        <th>ISIN Number</th>
                                        <th>Offer Amount</th>
                                        <th>Auction Start Time</th>
                                        <th>Date Created</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @forelse ($auctions as $auction)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $auction->securityCode }}</td>
                                        <td>{{ $auction->auctioneerEmail }}</td>
                                        <td>{{ $auction->isinNumber }}</td>
                                        <td>{{ $auction->offerAmount }}</td>
                                        <td>{{ date('F d, Y h:m',strtotime($auction->auctionStartTime))}}</td>
                                        <td>{{ date('F d, Y',strtotime($auction->createdDate))}}</td>
                                        <td><span class="badge bg-3">Pending Approval</span></td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view{{ $auction->id }}" href=""><i class="far fa-edit me-2"></i>View</a>

                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit{{ $auction->id }}" href=""><i class="far fa-edit me-2"></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete{{ $auction->id }}" href=""><i class="far fa-trash-alt me-2"></i>Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- view modal --}}
                                        <div id="view{{ $auction->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="standard-modalLabel">View
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h6>Security Code : <strong>{{ $auction->securityCode }}</strong></h6>
                                                            <br>
                                                            <h6>Offer Amount : <strong>{{ $auction->offerAmount }}</strong></h6>
                                                            <br>
                                                            <h6>Auctioneer Email : <strong>{{ $auction->auctioneerEmail }}</strong></h6>
                                                            <br>
                                                            <h6>Security ISIN NUmber : <strong>{{ $auction->isinNumber }}</strong></h6>
                                                            <br>
                                                            <h6>Ofer Date : <strong>{{ $auction->offerDate }}</strong></h6>
                                                            <br>
                                                            <h6>Auction Start Time : <strong>{{ date('F d, Y h:m:s',strtotime($auction->auctionStartTime)) }}</strong></h6>
                                                            <br>
                                                            <h6>Bid Close Time : <strong>{{ date('F d, Y h:m:s',strtotime($auction->bidCloseTime)) }}</strong></h6>
                                                            <br>
                                                            <h6>Bid Result Time : <strong>{{ date('F d, Y h:m:s',strtotime($auction->bidResultTime)) }}</strong></h6>
                                                            <br>
                                                            <h6>Minimum Rate : <strong>{{ $auction->minimumRate }}</strong></h6>
                                                            <br>
                                                            <h6>Maximum Rate : <strong>{{ $auction->maximumRate }}</strong></h6>
                                                            <br>
                                                            <h6>Inputter: <strong>{{ $auction->createdBy }}</strong></h6>
                                                            <br>
                                                            <h6>Created Date: <strong>{{ date('F d, Y h:m:s',strtotime($auction->createdDate))}}</strong></h6>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- edit --}}
                                        <div id="edit{{ $auction->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Update
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('auction.mgt.update') }}" method="POST" class="needs-validation" id="update" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='auction_ref' value="{{ $auction->id }}" />
                                                        <input type='hidden' name='securityId' value="{{ $auction->securityRef }}" />
                                                        <div class="modal-body">
                                                            <div class="form-row row">
                                                                {{-- --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Offer Date</label>
                                                                    <input type="date" name="offerDate" class="form-control" id="validationCustom01" value="{{ $auction->offerDate }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Auction Start Time</label>
                                                                    <input type="datetime-local" name="auction_start_time" class="form-control" id="validationCustom01" value="{{ $auction->auctionStartTime }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Bids Close Time</label>
                                                                    <input type="datetime-local" name="bids_close_time" class="form-control" id="validationCustom01" value="{{ $auction->bidCloseTime }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Bids Result Time</label>
                                                                    <input type="datetime-local" name="bids_result_time" class="form-control" id="validationCustom01" value="{{ $auction->bidResultTime }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Minimum Rate</label>
                                                                    <input type="number" name="minimum_rate" class="form-control" id="validationCustom01" value="{{ $auction->minimumRate }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Maximum Rate</label>
                                                                    <input type="number" name="maximum_rate" class="form-control" id="validationCustom01" value="{{ $auction->maximumRate }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" id="updateButton">Update Auction</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- delete --}}
                                        <div id="delete{{ $auction->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Delete
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('auction.mgt.delete') }}" method="POST" class="needs-validation" id="myForm" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='auction_ref' value="{{ $auction->id }}" />
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this institution?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" id="updateButton">Delete
                                                                Institution</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
