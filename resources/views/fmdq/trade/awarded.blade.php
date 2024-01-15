@extends('layouts.app')
@section('title','RITCC Trade Management')

@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">

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
                            <h5>My Quotes/Trades </h5>
                            <table class="datatable table table-center table-stripped table-bordered" id="example1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Security Code</th>
                                        <th>Security Name</th>
                                        <th>Issuer Code</th>
                                        <th>Settlement Account</th>
                                        <th>Nominal Amount (₦‘mm)</th>
                                        <th>Discount Rate (%)</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Awarded Amount (₦‘mm)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($trades as $bid)
                                    <tr>

                                        <td>{{ $i++; }}</td>
                                        <td>{{ $bid->securityCode }}</td>
                                        <td>{{ $bid->auction->security->description }}</td>
                                        <td>{{ $bid->institutionCode }}</td>
                                        <td>{{ $bid->settlementAccount }}</td>
                                        <td>{{ $bid->nominalAmount }}</td>
                                        <td>{{ $bid->discountRate }}</td>
                                        <td>{{ $bid->amountOffered }}</td>
                                        <td>Allocated</td>
                                        <td>{{ date('F d, Y h:m',strtotime($bid->timestamp))}}</td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#view{{ $bid->id }}" href=""><i
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- view modal --}}
                                        <div id="view{{ $bid->id }}" class="modal fade" tabindex="-1" role="dialog"
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
                                                            <h6>Security Name : <strong>{{
                                                                    $bid->auction->security->description }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>Security Code : <strong>{{ $bid->securityCode
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Offer Amount : <strong>{{ $bid->institutionCode
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Auctioneer Email : <strong>{{ $bid->settlementAccount
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Security ISIN NUmber : <strong>{{ $bid->nominalAmount
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Ofer Date : <strong>{{ $bid->discountRate }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>Auction Start Time : <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($bid->timestamp)) }}</strong></h6>
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
                                        {{-- edit --}}
                                        <div id="edit{{ $bid->id }}" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Update
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('trade.mgt.update') }}" method="POST"
                                                        class="needs-validation" id="update" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='transaction_ref'
                                                            value="{{ $bid->id }}" />
                                                        <input type='hidden' name='auction_ref'
                                                            value="{{ $bid->auctionRef }}" />

                                                        <div class="form-row row">
                                                            {{-- code --}}
                                                            {{-- --}}
                                                            <div class="col-md-6 mb-3">
                                                                <label for="validationCustom01">Settlement
                                                                    Account</label>
                                                                <input type="number" name="settlementAccount"
                                                                    class="form-control" id="validationCustom01"
                                                                    value="{{ $bid->settlementAccount }}" required>
                                                                <div class="invalid-feedback">
                                                                    This field is required
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label for="validationCustom01">Nominal Amount
                                                                    (₦‘mm)</label>
                                                                <input type="number" name="nominalAmount"
                                                                    class="form-control" id="validationCustom01"
                                                                    value="{{ $bid->nominalAmount }}" required>
                                                                <div class="invalid-feedback">
                                                                    This field is required
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 mb-3">
                                                                <label for="validationCustom01">Dicount Rate (%)</label>
                                                                <input type="number" name="discountRate"
                                                                    class="form-control" id="validationCustom01"
                                                                    value="{{ $bid->discountRate }}" required>
                                                                <div class="invalid-feedback">
                                                                    This field is required
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Update Bid</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- delete --}}
                                        <div id="delete{{ $bid->id }}" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Delete
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('trade.mgt.delete') }}" method="POST"
                                                        class="needs-validation" id="myForm" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='transaction_ref'
                                                            value="{{ $bid->id }}" />
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this bid?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Delete
                                                                bid</button>
                                                            &nbsp;&nbsp;&nbsp;
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


@section('style')

@endsection


@section('script')

<script>

</script>

@endsection