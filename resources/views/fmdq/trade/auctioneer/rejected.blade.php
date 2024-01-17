@extends('layouts.app')
@section('title','RITCC Auctioneer Dashboard')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        @include('fmdq.trade.auctioneer.cards')
        {{-- tables --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $page }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-center table-stripped table-bordered" id="example1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Security Code</th>
                                        <th>ISIN Number</th>
                                        <th>Offer Amount (₦‘mm)</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
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
                                        <td>{{ $auction->securityCode }}</td>
                                        <td>{{ $auction->isinNumber }}</td>
                                        <td>{{ number_format($auction->offerAmount,2) }}</td>
                                        <td>
                                            @if ($auction->approveFlag == 1)
                                            <span class="badge bg-1">{{ 'Approved' }}</span>
                                            @elseif ($auction->rejectionFlag == 1)
                                            <span class="badge bg-2">{{ 'Rejected' }}</span>
                                            @else
                                            <span class="badge bg-3">{{ 'Pending' }}</span>
                                            @endif
                                        </td>
                                        <td>{{ date('F d, Y',strtotime($auction->createdDate))}}</td>
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
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- view modal --}}
                                        <div id="view{{ $auction->id }}" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">View</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h6>Security Code : <strong>{{ $auction->securityCode
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Offer Amount : <strong>{{ $auction->institutionCode
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Auctioneer Email : <strong>{{
                                                                    $auction->settlementAccount
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Security ISIN NUmber : <strong>{{
                                                                    $auction->nominalAmount
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Ofer Date : <strong>{{
                                                                    number_format($auction->discountRate,
                                                                    2)
                                                                    }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>Auction Start Time : <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($auction->timestamp)) }}</strong>
                                                            </h6>
                                                            <br>
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