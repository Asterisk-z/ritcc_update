@extends('layouts.app')
@section('title','RITCC Institution Management')

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
                            <table class="datatable table table-center table-stripped table-bordered" id="example1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Security Code</th>
                                        <th>Auctioneer</th>
                                        <th>ISIN Number</th>
                                        <th>Offer Amount (₦‘mm)</th>
                                        <th>Auction Start Time</th>
                                        <th>Bid Close Time</th>
                                        {{-- <th>Date Created</th> --}}
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
                                        <td>{{ $auction->securityCode }}</td>
                                        <td>{{ $auction->auctioneer->firstName.' '.$auction->auctioneer->lastName }}
                                        </td>
                                        <td>{{ $auction->isinNumber }}</td>
                                        <td>{{ number_format($auction->offerAmount,2) }}</td>
                                        {{-- @dd($auction->auctionStartTime) --}}
                                        <td>{{ date('F d, Y h:i',strtotime($auction->auctionStartTime))}}</td>
                                        <td>{{ date('F d, Y h:i',strtotime($auction->bidCloseTime))}}</td>
                                        {{-- <td>{{ date('F d, Y',strtotime($auction->createdDate))}}</td> --}}

                                        @if ($auction->approveFlag ==='1')
                                        <td><span class="badge bg-1">Approved</span></td>
                                        @elseif($auction->rejectionFlag ==='1')
                                        <td><span class="badge bg-3">Rejected</span></td>
                                        @else
                                        <td><span class="badge bg-2">Pending</span></td>
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
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        @include('fmdq.auction.modal')
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