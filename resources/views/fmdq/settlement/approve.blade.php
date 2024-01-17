@extends('layouts.app')
@section('title','RITCC Settlement Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}

        {{-- --}}
        {{-- <div class="page-header">
            <div class="content-page-header">
                <a href="{{ route('settlement') }}" class="btn btn-primary mt-1">Back</a>
            </div>
        </div> --}}


        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-center table-stripped table-bordered" id="example1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Bidder</th>
                                        <th>Bid Amount (₦‘mm)</th>
                                        <th>Bid Rate (%)</th>
                                        {{-- <th>RTGS Account Number</th>
                                        <th>Custodian Account Number</th> --}}
                                        <th>Settlement Account</th>
                                        <th>Status</th>
                                        <th>Amount Awarded (₦‘mm)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($transactions as $auction)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $auction->bidder_obj->firstName.' '.$auction->bidder_obj->lastName }}
                                        </td>
                                        <td>{{ number_format($auction->nominalAmount,2) }}</td>
                                        <td>{{ number_format($auction->discountRate,2) }}</td>
                                        {{-- <td>{{ $auction->bidder_obj ? $auction->bidder_obj->rtgsNumber : '' }}</td>
                                        <td>{{ $auction->bidder_obj ? $auction->bidder_obj->fmdqNumber : '' }}</td> --}}
                                        <td>{{ $auction->settlementAccount ."" }} </td>
                                        <td>
                                            @if($auction->settlementFlag == 1)
                                            <span class="badge bg-1">Settled</span>
                                            @else
                                            @if($auction->settlementRejectedFlag == 1)
                                            <span class="badge bg-3">Rejected</span>
                                            @elseif ($auction->settlementPendingApprovalFlag == 1)
                                            <span class="badge bg-3">Pending Approval</span>
                                            @else
                                            <span class="badge bg-3">Not Settled</span>
                                            @endif
                                            @endif
                                        </td>
                                        <td>{{ $auction->amountOffered ."" }} </td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>

                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approveSettlement{{ $auction->id }}"
                                                                href=""><i
                                                                    class="far fa-check-circle me-2"></i>Approve</a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#declineSettlement{{ $auction->id }}"
                                                                href=""><i
                                                                    class="far fa-times-circle me-2"></i>Decline</a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#view{{ $auction->id }}" href=""><i
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                        <div id="view{{ $auction->id }}" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="standard-modalLabel" aria-hidden="true">
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
                                                            <h6>Security Code : <strong>{{ $auction->securityCode
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Offer Amount : <strong>{{ $auction->offerAmount
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Auctioneer Email : <strong>{{ $auction->auctioneerEmail
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Security ISIN NUmber : <strong>{{ $auction->isinNumber
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Ofer Date : <strong>{{ $auction->offerDate }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>Auction Start Time : <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($auction->auctionStartTime))
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Bid Close Time : <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($auction->bidCloseTime))
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Bid Result Time : <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($auction->bidResultTime))
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Minimum Rate : <strong>{{ $auction->minimumRate
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Maximum Rate : <strong>{{ $auction->maximumRate
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Inputter: <strong>{{ $auction->createdBy }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>Created Date: <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($auction->createdDate))}}</strong>
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

                                        <div id="approveSettlement{{ $auction->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Approve
                                                            Settlement</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('settlement.approve.settle', $auction->id) }}"
                                                        method="POST" class="needs-validation confirmation" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='bid_ref'
                                                            value="{{ $auction->id }}" />
                                                        <div class="modal-body">
                                                            <h4>Are you sure you want approve settlement?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary me-2">Approve</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="declineSettlement{{ $auction->id }}" class="modal fade" tabindex="-1"
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
                                                        action="{{ route('settlement.decline.settle', $auction->id) }}"
                                                        method="POST" class="needs-validation confirmation" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='bid_ref'
                                                            value="{{ $auction->id }}" />
                                                        <div class="modal-body">
                                                            {{-- <h4>Do you sure you reject the request to settle this
                                                                bid?
                                                            </h4> --}}
                                                            <div class="form-row row">
                                                                {{-- --}}
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Reason</label>
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
                                                            <button type="submit"
                                                                class="btn btn-primary me-2">Reject</button>
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