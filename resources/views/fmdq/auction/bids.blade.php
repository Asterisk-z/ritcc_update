@extends('layouts.app')
@section('title','RITCC Institution Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        {{-- tables --}}
        {{-- --}}
        <div class="page-header">
            <div class="content-page-header">

                {{-- <button type="button" class="btn btn-primary mt-1" style="background-color: transparent; border: transparent;">rrre</button>  --}}
                <h4>Remaining Amount {{ $availableAmount }} (₦‘mm)</h4>


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
                                        <th>S/N</th>
                                        <th>Settlement Account</th>
                                        <th>Security</th>
                                        <th>Bidder Email</th>
                                        <th>Discount Rate (%)</th>
                                        <th>Offer Rate (₦‘mm)</th>
                                        <th>Offered Amount (₦‘mm)</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @forelse ($bids as $item)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $item->settlementAccount }}</td>
                                        <td>{{ $item->securityCode }}</td>
                                        <td>{{ $item->bidder }}</td>
                                        <td>{{ $item->discountRate }}</td>
                                        <td>{{ $item->nominalAmount }}</td>
                                        <td>{{ $item->amountOffered }}</td>
                                        <td>{{ date('F d, Y',strtotime($item->timestamp))}}</td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view{{ $item->id }}" href=""><i class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                        @if(!$item->awardedFlag)
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#award{{ $item->id }}" href=""><i class="far fa-edit me-2"></i>Award Offer</a>
                                                        </li>
                                                        @else
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cancel{{ $item->id }}" href=""><i class="far fa-edit me-2"></i>Cancel Award</a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                        <div id="view{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">View
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h6>Security Code : <strong>{{ $item->securityCode }}</strong></h6>
                                                            <br>
                                                            <h6>Offer Amount : <strong>{{ $item->offerAmount }}</strong></h6>
                                                            <br>
                                                            <h6>Auctioneer Email : <strong>{{ $item->auctioneerEmail }}</strong></h6>
                                                            <br>
                                                            <h6>Security ISIN NUmber : <strong>{{ $item->isinNumber }}</strong></h6>
                                                            <br>
                                                            <h6>Ofer Date : <strong>{{ $item->offerDate }}</strong></h6>
                                                            <br>
                                                            <h6>Auction Start Time : <strong>{{ date('F d, Y h:m:s',strtotime($item->auctionStartTime)) }}</strong></h6>
                                                            <br>
                                                            <h6>Bid Close Time : <strong>{{ date('F d, Y h:m:s',strtotime($item->bidCloseTime)) }}</strong></h6>
                                                            <br>
                                                            <h6>Bid Result Time : <strong>{{ date('F d, Y h:m:s',strtotime($item->bidResultTime)) }}</strong></h6>
                                                            <br>
                                                            <h6>Minimum Rate : <strong>{{ $item->minimumRate }}</strong></h6>
                                                            <br>
                                                            <h6>Maximum Rate : <strong>{{ $item->maximumRate }}</strong></h6>
                                                            <br>
                                                            <h6>Inputter: <strong>{{ $item->createdBy }}</strong></h6>
                                                            <br>
                                                            <h6>Created Date: <strong>{{ date('F d, Y h:m:s',strtotime($item->createdDate))}}</strong></h6>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="award{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Award Offer
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('auction.mgt.award') }}" method="POST" class="needs-validation" id="myForm" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='bid_ref' value="{{ $item->id }}" />
                                                        <input type='hidden' name='bidder_email' value="{{ $item->bidder }}" />
                                                        <div class="modal-body">
                                                            <div class="form-row row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Award Amount</label>
                                                                    <input type="number" name="award_amount" class="form-control" id="validationCustom01" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" id="updateButton">Award</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="cancel{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Delete
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('auction.mgt.cancel.award') }}" method="POST" class="needs-validation" id="myForm" novalidate>

                                                        @csrf
                                                        <input type='hidden' name='bid_ref' value="{{ $item->id }}" />
                                                        <input type='hidden' name='bidder_email' value="{{ $item->bidder }}" />

                                                        <div class="modal-body">
                                                            <p>Are you sure you want cancel auction?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" id="updateButton">cancel Bidding</button>
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


@section('script')
<script>

</script>
@endsection
