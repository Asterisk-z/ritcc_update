@extends('layouts.app')
@section('title','RITCC Institution Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        {{-- tables --}}
        {{-- --}}
        <div class="page-header">
            <div class="content-page-header">

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
                                                            <a class="dropdown-item" href="{{route('auction.mgt.results', $item->auctionRef)}}"><i class="far fa-edit me-2"></i>Result</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

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
