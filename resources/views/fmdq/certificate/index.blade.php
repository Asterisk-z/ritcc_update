@extends('layouts.app')
@section('title','RITCC Certificate Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        @include('fmdq.certificate.widgets')
        {{-- tables --}}
        {{-- --}}
        <div class="page-header">
            <div class="content-page-header">

                <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal"
                    data-bs-target="#standard-modal"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add
                    Certificate</button>
                {{-- modal --}}
                <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="standard-modalLabel">Add Certificate</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('inputter.certificate.mgt.create') }}" method="POST" id="create"
                                class="needs-validation" novalidate>
                                @csrf
                                <div class="modal-body">
                                    <div class="form-row row">
                                        {{-- code --}}
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom01">Security Description</label>
                                            <input type="text" name="description" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom01">Auctioner</label>
                                            <select name="auctioneer" id="validationCustom01" class="form-control"
                                                required>
                                                <option value="">--Select--</option>
                                                @foreach ($auctioneers as $auctioneer)
                                                <option value="{{ $auctioneer->id }}">{{ $auctioneer->email ." |
                                                    ".$auctioneer->user_inst->institutionName }}</option>

                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Security Type</label>
                                            <select name="securityType" id="validationCustom01" class="form-control"
                                                required>
                                                <option value="">--Select--</option>
                                                @foreach ($securityTypes as $securityType)
                                                <option value="{{ $securityType->securityTypeCode }}">{{
                                                    $securityType->description }}</option>

                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Security Code</label>
                                            <input type="text" name="securityCode" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">ISIN Number</label>
                                            <input type="number" name="isinNumber" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>
                                        {{-- --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Issue Date</label>
                                            <input type="date" name="issueDate" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Transaction And Settlement Fee Rate</label>
                                            <input type="number" name="transactionFee" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Offer Amount (₦‘mm)</label>
                                            <input type="number" name="offerAmount" class="form-control"
                                                id="validationCustom01" required>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>

                                        {{-- --}}

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Security Valudation Status</label>
                                            <select name="validationStatus" id="validationCustom01" class="form-control"
                                                required>
                                                <option value="">--Select--</option>
                                                <option value="1">Available</option>
                                                <option value="0">Unavailable</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Create Certificate</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="list-btn">
                    @include('fmdq.certificate.buttons')

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
                                        <th>Isser Code</th>
                                        <th>Offer Amount</th>
                                        <th>Date Created</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($securities as $security)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $security->securityCode }}</td>
                                        <td>{{ $security->auctioneer->email }}</td>
                                        <td>{{ $security->isinNumber }}</td>
                                        <td>{{ $security->issuerCode }}</td>
                                        <td>{{ $security->offerAmount }}</td>
                                        <td>{{ date('F d, Y',strtotime($security->createdDate))}}</td>
                                        <td><span class="badge bg-3">Pending Approval</span></td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#view{{ $security->id }}" href=""><i
                                                                    class="far fa-edit me-2"></i>View</a>

                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $security->id }}" href=""><i
                                                                    class="far fa-edit me-2"></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete{{ $security->id }}" href=""><i
                                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- view modal --}}
                                        <div id="view{{ $security->id }}" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h4 class="modal-title" id="standard-modalLabel">View
                                                        </h4> --}}
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h6>Security Description : <strong>{{ $security->description
                                                                    }}</strong></h6>
                                                            <br>

                                                            <h6>Security Code : <strong>{{ $security->securityCode
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Offer Amount : <strong>{{ $security->offerAmount
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Auctioneer Email : <strong>{{
                                                                    $security->auctioneer->email }}</strong></h6>
                                                            <br>
                                                            <h6>Institution : <strong>{{
                                                                    $security->auctioneer->user_inst->institutionName
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Security ISIN NUmber : <strong>{{ $security->isinNumber
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Issuer Number : <strong>{{ $security->issueCode
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Issue Date : <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($security->issueDate)) }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>Inputter: <strong>{{ $security->createdBy }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>Created Date: <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($security->createdDate))}}</strong>
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
                                        {{-- edit --}}
                                        <div id="edit{{ $security->id }}" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Update
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('inputter.certificate.mgt.update') }}"
                                                        method="POST" class="needs-validation" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='security_ref'
                                                            value="{{ $security->id }}" />
                                                        <div class="modal-body">
                                                            <div class="form-row row">
                                                                {{-- code --}}

                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Security
                                                                        Description</label>
                                                                    <input type="text" name="description"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $security->description }}" required>

                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Auctioner</label>
                                                                    <select name="auctioneer" id="validationCustom01"
                                                                        class="form-control" required>
                                                                        <option value="">--Select--</option>
                                                                        @foreach ($auctioneers as $auctioneer)
                                                                        <option value="{{ $auctioneer->id }}" {{
                                                                            ($security->auctioneerRef ==
                                                                            $auctioneer->id) ? 'selected' : '' }}>{{
                                                                            $auctioneer->email ." |
                                                                            ".$auctioneer->user_inst->institutionName }}
                                                                        </option>

                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Security
                                                                        Type</label>
                                                                    <select name="securityType" id="validationCustom01"
                                                                        class="form-control" required>
                                                                        <option value="">--Select--</option>
                                                                        @foreach ($securityTypes as $securityType)
                                                                        <option
                                                                            value="{{ $securityType->securityTypeCode }}"
                                                                            {{ ($security->securityType ==
                                                                            $securityType->securityTypeCode) ?
                                                                            'selected' : '' }}>{{
                                                                            $securityType->description }}</option>

                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Security
                                                                        Code</label>
                                                                    <input type="text" name="securityCode"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $security->securityCode }}" required>

                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">ISIN Number</label>
                                                                    <input type="number" name="isinNumber"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $security->isinNumber }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Issue Date</label>
                                                                    <input type="date" name="issueDate"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $security->issueDate }}" required>

                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Transaction And
                                                                        Settlement Fee Rate</label>
                                                                    <input type="number" name="transactionFee"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $security->transactionSettlementFeeRate }}"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Offer Amount
                                                                        (₦‘mm)</label>
                                                                    <input type="number" name="offerAmount"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $security->offerAmount }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>

                                                                {{-- --}}

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Security Valudation
                                                                        Status</label>
                                                                    <select name="validationStatus"
                                                                        id="validationCustom01" class="form-control"
                                                                        required>
                                                                        <option value="">--Select--</option>
                                                                        <option value="1">Available</option>
                                                                        <option value="0">Unavailable</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Update Security</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- delete --}}
                                        <div id="delete{{ $security->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Delete
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('inputter.certificate.mgt.delete') }}"
                                                        method="POST" class="needs-validation" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='security_ref'
                                                            value="{{ $security->id }}" />
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this security?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Delete
                                                                Certficate</button>
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