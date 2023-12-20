@extends('layouts.app')
@section('title','RITCC Certificate Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        @include('fmdq.certificate.cards')
        @include('fmdq.certificate.buttons')
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
                                        <td>{{ $certificate->securityCode }}</td>
                                        <td>{{ $certificate->isinNumber }}</td>
                                        <td>{{ $certificate->issuerCode }}</td>
                                        <td>{{ $certificate->offerAmount }}</td>
                                        <td>{{ date('F d, Y',strtotime($certificate->createdDate))}}</td>
                                        <td><span class="badge bg-1">Approved</span></td>
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view{{ $certificate->id }}" href=""><i class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                        <div id="view{{ $certificate->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">View
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                                    $certificate->auctioneer ? $certificate->auctioneer->email : ""}}</strong></h6>
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
