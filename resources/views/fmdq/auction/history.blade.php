@extends('layouts.app')
@section('title','RITCC Institution Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        <div class="row">
            {{-- all --}}
            <div class="col-xl-3 col-sm-3 col-12">
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
            <div class="col-xl-3 col-sm-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-3">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Not Started Auctions</div>
                                <div class="dash-counts">
                                    <p>{{ $pending }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- approved --}}
            <div class="col-xl-3 col-sm-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-1">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Running Auctions</div>
                                <div class="dash-counts">
                                    <p>{{ $approved }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- rejected --}}
            <div class="col-xl-3 col-sm-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-2">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Complated Auctions</div>
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

                <button type="button" class="btn btn-primary mt-1" style="background-color: transparent; border: transparent;"></button>

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
                                        <th>Email</th>
                                        <th>ISIN Number</th>
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
                                        <td>{{ date('F d, Y',strtotime($auction->createdDate))}}</td>
                                        <td>
                                            <span class="badge bg-1">Ongoing</span>
                                            {{-- <span class="badge bg-2">Completed</span>
                                            <span class="badge bg-3">Not Started</span>  --}}
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view{{ $auction->id }}" href=""><i class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{route('auction.mgt.bids', $auction->id)}}"><i class="far fa-eye me-2"></i>Bids</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#close{{ $auction->id }}" href=""><i class="far fa-times me-2"></i>Close Auction</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                        <div id="view{{ $auction->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">View
                                                        </h4>
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
