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

                <button type="button" class="btn btn-primary mt-1"
                    style="background-color: transparent; border: transparent;"></button>


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
                                    @forelse ($securities as $certificate)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        @if($certificate->modifyingFlag || $certificate->deletingFlag)
                                        @php
                                        $updateCertificate = $certificate->modifyingFlag ?
                                        json_decode($certificate->modifyingData) : [];

                                        @endphp
                                        <td>{{ $certificate->modifyingFlag ? $updateCertificate->securityCode :
                                            $certificate->securityCode }}</td>
                                        <td>{{ $certificate->modifyingFlag ? $updateCertificate->auctioneerEmail :
                                            $certificate->auctioneer->email }}</td>
                                        <td>{{ $certificate->modifyingFlag ? $updateCertificate->isinNumber :
                                            $certificate->isinNumber }}</td>
                                        <td>{{ $certificate->modifyingFlag ? $updateCertificate->issuerCode :
                                            $certificate->issuerCode }}</td>
                                        <td>{{ $certificate->modifyingFlag ? $updateCertificate->offerAmount :
                                            $certificate->offerAmount }}</td>
                                        <td>{{ $certificate->modifyingFlag ? date('F d,
                                            Y',strtotime($updateCertificate->createdDate)) : date('F d,
                                            Y',strtotime($certificate->createdDate))}}</td>
                                        <td><span class="badge bg-3"> {{ $certificate->modifyingFlag ? 'Pending Update'
                                                : 'Pending Delete' }}</span></td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#view{{ $certificate->id }}" href=""><i
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                        @if ($certificate->modifyingFlag)
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#viewUpdate{{ $certificate->id }}"
                                                                href=""><i class="far fa-edit me-2"></i>View Update</a>
                                                        </li>
                                                        @endif

                                                        @if (auth()->user()->type === 'firs' || auth()->user()->type ==
                                                        'super')

                                                        @if ($certificate->modifyingFlag)
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approveUpdate{{ $certificate->id }}"
                                                                href=""><i class="fa fa-check me-2"></i>Approve
                                                                Update</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectUpdate{{ $certificate->id }}"
                                                                href=""><i class="fa fa-times me-2"></i>Reject
                                                                Update</a>
                                                        </li>
                                                        @endif

                                                        @if ($certificate->deletingFlag)
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approveDelete{{ $certificate->id }}"
                                                                href=""><i class="fa fa-check me-2"></i>Approve
                                                                Delete</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectDelete{{ $certificate->id }}"
                                                                href=""><i class="fa fa-times me-2"></i>Reject
                                                                Delete</a>
                                                        </li>
                                                        @endif

                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                        @if ($certificate->modifyingFlag)
                                        <div id="viewUpdate{{ $certificate->id }}" class="modal fade" tabindex="-1"
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
                                                            <h6>Security Code : <strong>{{
                                                                    $updateCertificate->securityCode }}</strong></h6>
                                                            <br>
                                                            <h6>Offer Amount : <strong>{{
                                                                    $updateCertificate->offerAmount }}</strong></h6>
                                                            <br>
                                                            <h6>Auctioneer Email : <strong>{{
                                                                    $updateCertificate->auctioneerEmail }}</strong></h6>
                                                            <br>
                                                            <h6>Security ISIN NUmber : <strong>{{
                                                                    $updateCertificate->isinNumber }}</strong></h6>
                                                            <br>
                                                            <h6>Issue Date: <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($updateCertificate->issueDate ))
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Inputter: <strong>{{ $updateCertificate->createdBy
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Created Date: <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($updateCertificate->createdDate
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

                                        <div id="approveUpdate{{ $certificate->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Approve
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('firs.certificate.mgt.approve.update') }}"
                                                        method="POST" class="needs-validation" id="update" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='security_ref'
                                                            value="{{ $certificate->id }}" />
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

                                        <div id="rejectUpdate{{ $certificate->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Reject
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('firs..certificate.mgt.reject.update') }}"
                                                        method="POST" class="needs-validation" id="myForm" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='security_ref'
                                                            value="{{ $certificate->id }}" />
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

                                        <div id="approveDelete{{ $certificate->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Approve Delete
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('firs.certificate.mgt.approve.delete') }}"
                                                        method="POST" class="needs-validation" id="update" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='security_ref'
                                                            value="{{ $certificate->id }}" />
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

                                        <div id="rejectDelete{{ $certificate->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Reject Delete
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('firs.certificate.mgt.reject.delete') }}"
                                                        method="POST" class="needs-validation" id="myForm" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='security_ref'
                                                            value="{{ $certificate->id }}" />
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

                                        <td>{{ $certificate->securityCode }}</td>
                                        <td>{{ $certificate->auctioneer->email }}</td>
                                        <td>{{ $certificate->isinNumber }}</td>
                                        <td>{{ $certificate->issuerCode }}</td>
                                        <td>{{ $certificate->offerAmount }}</td>
                                        <td>{{ date('F d, Y',strtotime($certificate->createdDate))}}</td>
                                        @if ($certificate->rejectionFlag == 0 && $certificate->approveFlag == 0)
                                        <td><span class="badge bg-3">Pending Approval</span></td>
                                        @elseif($certificate->approveFlag == 1)
                                        <td><span class="badge bg-1">Approved</span></td>
                                        @elseif($certificate->rejectionFlag == 1)
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
                                                                data-bs-target="#view{{ $certificate->id }}" href=""><i
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                        @if (auth()->user()->type == 'firs' ||
                                                        auth()->user()->type == 'super')
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#approve{{ $certificate->id }}"
                                                                href=""><i class="fa fa-check me-2"></i>Approve </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#reject{{ $certificate->id }}"
                                                                href=""><i class="fa fa-times me-2"></i>Reject</a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- approve --}}
                                        <div id="approve{{ $certificate->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Approve
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('firs.certificate.mgt.approve.create') }}"
                                                        method="POST" class="needs-validation" id="update" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='security_ref'
                                                            value="{{ $certificate->id }}" />
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
                                        <div id="reject{{ $certificate->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Reject
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('firs.certificate.mgt.reject.create') }}"
                                                        method="POST" class="needs-validation" id="myForm" novalidate>
                                                        @csrf
                                                        <input type='hidden' name='security_ref'
                                                            value="{{ $certificate->id }}" />
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


                                        <div id="view{{ $certificate->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
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
                                                            <h6>Security Code : <strong>{{ $certificate->securityCode
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Offer Amount : <strong>{{ $certificate->offerAmount
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Auctioneer Email : <strong>{{
                                                                    $certificate->auctioneerEmail }}</strong></h6>
                                                            <br>
                                                            <h6>Security ISIN NUmber : <strong>{{
                                                                    $certificate->isinNumber }}</strong></h6>
                                                            <br>
                                                            <h6>Issue Date: <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($certificate->issueDate ))
                                                                    }}</strong></h6>
                                                            <br>
                                                            <h6>Inputter: <strong>{{ $certificate->createdBy }}</strong>
                                                            </h6>
                                                            <br>
                                                            <h6>Created Date: <strong>{{ date('F d, Y
                                                                    h:m:s',strtotime($certificate->createdDate))}}</strong>
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
