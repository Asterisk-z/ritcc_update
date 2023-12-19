@extends('layouts.app')
@section('title','RITCC Institution Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        @include('fmdq.institution.cards')
        @include('fmdq.institution.buttons')
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
                                    @forelse ($institutions as $institution)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $institution->code }}</td>
                                        <td>{{ $institution->institutionName }}</td>
                                        <td>{{ $institution->institutionEmail }}</td>
                                        <td>{{ date('F d, Y',strtotime($institution->createdDate))}}</td>
                                        @if ($institution->status ==='0')
                                        <td><span class="badge bg-3">Pending Approval</span></td>
                                        @elseif($institution->status ==='1')
                                        <td><span class="badge bg-1">Approved</span></td>
                                        @elseif($institution->status ==='2')
                                        <td><span class="badge bg-2">Rejected</span></td>
                                        @elseif ($institution->status ==='3')
                                        <td><span class="badge bg-3">Pending Update</span></td>
                                        @elseif($institution->status ==='4')
                                        <td><span class="badge bg-3">Pending Delete</span></td>
                                        @endif
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        @if (!($institution->status === '3' || $institution->status ===
                                                        '4'))
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#view{{ $institution->ID }}" href=""><i
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $institution->ID }}" href=""><i
                                                                    class="far fa-edit me-2"></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete{{ $institution->ID }}"
                                                                href=""><i class="far fa-trash-alt me-2"></i>Delete</a>
                                                        </li>
                                                        @else
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#view{{ $institution->ID }}" href=""><i
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                        @endif



                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- view modal --}}
                                        <div id="view{{ $institution->ID }}" class="modal fade" tabindex="-1"
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
                                                            <h6>Institution Code: <strong>{{ $institution->code
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Institution Name: <strong>{{
                                                                    $institution->institutionName
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Institution Address: <strong>{{ $institution->address
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Institution Email: <strong>{{
                                                                    $institution->institutionEmail
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Chief Dealer Email: <strong>{{
                                                                    $institution->chiefDealerEmail
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Inputter: <strong>{{
                                                                    $institution->createdBy
                                                                    }}</strong></h6>
                                                            <br><br>
                                                            <h6>Created Date: <strong>{{ date('F d,
                                                                    Y
                                                                    h:m:s',strtotime($institution->createdDate))}}</strong>
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
                                        <div id="edit{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Update
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('institution.update',$institution->ID) }}"
                                                        method="POST" class="needs-validation" id="update" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-row row">
                                                                {{-- code --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Institution
                                                                        Code</label>
                                                                    <input type="text" name="code" class="form-control"
                                                                        id="validationCustom01"
                                                                        value="{{ $institution->code }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Institution
                                                                        Name</label>
                                                                    <input type="text" name="name" class="form-control"
                                                                        id="validationCustom01"
                                                                        value="{{ $institution->institutionName }}"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Address</label>
                                                                    <input type="text" name="address"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $institution->address }}" required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- code --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Institution
                                                                        Email</label>
                                                                    <input type="email" name="institutionEmail"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $institution->institutionEmail }}"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                {{-- --}}
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="validationCustom01">Chief Dealer
                                                                        Email</label>
                                                                    <input type="email" name="chiefDealerEmail"
                                                                        class="form-control" id="validationCustom01"
                                                                        value="{{ $institution->chiefDealerEmail }}"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Authoriser</label>
                                                                    <select name="authoriser" id="validationCustom01"
                                                                        class="form-control" required>
                                                                        <option value="">--Select--</option>
                                                                        @forelse ($authorisers as $authoriser)
                                                                        <option value="{{ $authoriser->email }}">{{
                                                                            $authoriser->FirstName.'
                                                                            '.$authoriser->LastName }}</option>
                                                                        @empty

                                                                        @endforelse
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        This field is required
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Update
                                                                Institution</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- delete --}}
                                        <div id="delete{{ $institution->ID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Delete
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('institution.delete',$institution->ID) }}"
                                                        method="POST" class="needs-validation" id="myForm" novalidate>
                                                        @csrf
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this institution?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="updateButton">Delete
                                                                Institution</button>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
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