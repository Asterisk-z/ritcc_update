@extends('layouts.app')
@section('title','RITCC Auction Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        @include('fmdq.auction.cards')

        {{-- tables --}}
        {{-- --}}
        <div class="page-header">
            @include('fmdq.auction.buttons')
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
                                    @foreach ($auctions as $auction)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        @if($auction->modifyingFlag || $auction->deletingFlag)
                                        @php
                                        $updateAuction = $auction->modifyingFlag ? json_decode($auction->modifyingData)
                                        : [];
                                        @endphp
                                        <td>{{ $auction->modifyingFlag ? $updateAuction->securityCode :
                                            $auction->securityCode }}</td>
                                        <td>{{ $auction->modifyingFlag ? $updateAuction->auctioneerEmail :
                                            $auction->auctioneerEmail }}</td>
                                        <td>{{ $auction->modifyingFlag ? $updateAuction->isinNumber :
                                            $auction->isinNumber }}</td>
                                        <td>{{ $auction->modifyingFlag ? date('F d,
                                            Y',strtotime($updateAuction->createdDate)) : date('F d,
                                            Y',strtotime($auction->createdDate))}}</td>
                                        <td><span class="badge bg-3"> {{ $auction->modifyingFlag ? 'Pending Update' :
                                                'Pending Delete' }}</span></td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#view{{ $auction->id }}" href=""><i
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>

                                                        @if ($auction->modifyingFlag)
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#viewUpdate{{ $auction->id }}"
                                                                href=""><i class="far fa-edit me-2"></i>View Update</a>
                                                        </li>
                                                        @endif

                                                        @if (auth()->user()->type == 'authoriser')

                                                        @if ($auction->modifyingFlag)
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approveUpdate{{ $auction->id }}"
                                                                href=""><i class="fa fa-check me-2"></i>Approve
                                                                Update</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectUpdate{{ $auction->id }}"
                                                                href=""><i class="fa fa-times me-2"></i>Reject
                                                                Update</a>
                                                        </li>
                                                        @endif

                                                        @if ($auction->deletingFlag)
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approveDelete{{ $auction->id }}"
                                                                href=""><i class="fa fa-check me-2"></i>Approve
                                                                Delete</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectDelete{{ $auction->id }}"
                                                                href=""><i class="fa fa-times me-2"></i>Reject
                                                                Delete</a>
                                                        </li>
                                                        @endif

                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                        @if ($auction->modifyingFlag)
                                        <div id="viewUpdate{{ $auction->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">View Updating
                                                            Data
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h6>Security Code : <strong>{{ $updateAuction->securityCode
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Offer Amount : <strong>{{ $updateAuction->offerAmount
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Auctioneer Email : <strong>{{
                                                                    $updateAuction->auctioneerEmail }}</strong></h6>
                                                            <br>
                                                            <h6>Security ISIN NUmber : <strong>{{
                                                                    $updateAuction->isinNumber }}</strong></h6>
                                                            <br>
                                                            <h6>Ofer Date : <strong>{{ $updateAuction->offerDate
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Auction Start Time : <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($updateAuction->auctionStartTime ))
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Bid Close Time : <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($updateAuction->bidCloseTime ))
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Bid Result Time : <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($updateAuction->bidResultTime ))
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Minimum Rate : <strong>{{ $updateAuction->minimumRate
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Maximum Rate : <strong>{{ $updateAuction->maximumRate
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Inputter: <strong>{{ $updateAuction->createdBy
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Created Date: <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($updateAuction->createdDate
                                                                    ))}}</strong></h6>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-lg"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div id="approveUpdate{{ $auction->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Approve
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('auction.mgt.approve.update') }}"
                                                        method="POST" class="needs-validation" id="update" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='auction_ref'
                                                            value="{{ $auction->id }}" />
                                                        <div class="modal-body">
                                                            <h6>Are you sure you want to approve this update?</h6>
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

                                        <div id="rejectUpdate{{ $auction->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Reject
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('auction.mgt.reject.update') }}"
                                                        method="POST" class="needs-validation" id="myForm" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='auction_ref'
                                                            value="{{ $auction->id }}" />
                                                        <div class="modal-body">
                                                            <label for="">Reason for Rejection</label>
                                                            <input type="text" name="reason" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Reject</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="approveDelete{{ $auction->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Approve Delete
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('auction.mgt.approve.delete') }}"
                                                        method="POST" class="needs-validation" id="update" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='auction_ref'
                                                            value="{{ $auction->id }}" />
                                                        <div class="modal-body">
                                                            <h6>Are you sure you want to approve this delete?</h6>
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

                                        <div id="rejectDelete{{ $auction->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Reject Delete
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('auction.mgt.reject.delete') }}"
                                                        method="POST" class="needs-validation" id="myForm" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='auction_ref'
                                                            value="{{ $auction->id }}" />
                                                        <div class="modal-body">
                                                            <label for="">Reason for Rejection</label>
                                                            <input type="text" name="reason" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Reject</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>



                                        @else

                                        <td>{{ $auction->securityCode }}</td>
                                        <td>{{ $auction->auctioneerEmail }}</td>
                                        <td>{{ $auction->isinNumber }}</td>
                                        <td>{{ date('F d, Y',strtotime($auction->createdDate))}}</td>
                                        @if ($auction->rejectionFlag == 0 && $auction->approveFlag == 0)
                                        <td><span class="badge bg-3">Pending Approval</span></td>
                                        @elseif($auction->approveFlag == 1)
                                        <td><span class="badge bg-1">Approved</span></td>
                                        @elseif($auction->rejectionFlag == 1)
                                        <td><span class="badge bg-2">Rejected</span></td>
                                        @endif
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#view{{ $auction->id }}" href=""><i
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                        @if (auth()->user()->type == 'authoriser' ||
                                                        auth()->user()->type == 'super')

                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approve{{ $auction->id }}" href=""><i
                                                                    class="fa fa-check me-2"></i>Approve </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#reject{{ $auction->id }}" href=""><i
                                                                    class="fa fa-times me-2"></i>Reject</a>
                                                        </li>

                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- approve --}}
                                        <div id="approve{{ $auction->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Approve
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('auction.mgt.approve.create') }}"
                                                        method="POST" class="needs-validation" id="update" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='auction_ref'
                                                            value="{{ $auction->id }}" />
                                                        <div class="modal-body">
                                                            <h6>Are you sure you want to approve this Auction?</h6>
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
                                        {{-- reject --}}
                                        <div id="reject{{ $auction->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Reject
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('auction.mgt.reject.create') }}"
                                                        method="POST" class="needs-validation" id="myForm" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='auction_ref'
                                                            value="{{ $auction->id }}" />
                                                        <div class="modal-body">
                                                            <label for="">Reason for Rejection</label>
                                                            <input type="text" name="reason" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Reject</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        @endif


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