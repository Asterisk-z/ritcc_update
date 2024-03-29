@extends('layouts.app')
@section('title','RITCC Auction Results')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Auction Results</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-center table-stripped table-bordered" id="example1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>S/N</th>
                                        <th>Auction Reference</th>
                                        <th>Offer Amount</th>
                                        <th>Total Bids (₦‘mm)</th>
                                        <th>Stop Rate (%)</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($auction_list as $item)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ number_format($item->offerAmount,2) }}</td>
                                        <td>{{ number_format($item->total_bid_amount,2) }}</td>
                                        <td>{{ $item->isinNumber }}</td>
                                        <td>{{ date('F d, Y',strtotime($item->bidCloseTime))}}</td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{route('auction.mgt.results', $item->id)}}"><i
                                                                    class="far fa-eye me-2"></i>View Result</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
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