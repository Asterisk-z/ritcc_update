<td class="d-flex align-items-center">
    <div class="dropdown dropdown-action">
        <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i
                class="fas fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <ul>
                <li>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view{{ $institution->ID }}"
                        href=""><i class="far fa-edit me-2"></i>View</a>
                </li>
                @if (!($institution->status === '0'||$institution->status ===
                '3' || $institution->status ===
                '4'))

                <li>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit{{ $institution->ID }}"
                        href=""><i class="far fa-edit me-2"></i>Edit</a>
                </li>
                <li>
                    <a class="dropdown-item" class="dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#delete{{ $institution->ID }}" href=""><i
                            class="far fa-trash-alt me-2"></i>Delete</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</td>
{{-- view modal --}}
<div id="view{{ $institution->ID }}" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h4 class="modal-title" id="standard-modalLabel">View
                </h4> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h6>Institution Code: <strong class="text-uppercase">{{
                            $institution->code
                            }}</strong></h6>
                    <br><br>
                    <h6>Institution Name: <strong class="text-uppercase">{{
                            $institution->institutionName
                            }}</strong></h6>
                    <br><br>
                    <h6>Institution Address: <strong class="text-uppercase">{{
                            $institution->address
                            }}</strong></h6>
                    <br><br>
                    <h6>Email Address: <strong class="text-uppercase">{{
                            $institution->institutionEmail
                            }}</strong></h6>
                    <br><br>
                    <h6>Chief Dealer Email: <strong class="text-uppercase">{{
                            $institution->chiefDealerEmail
                            }}</strong></h6>
                    <br><br>

                    @if ($institution->status === '1' || $institution->status
                    === '3' || $institution->status === '4')
                    <h6>Approved by: <strong class="text-uppercase">{{
                            $institution->approvedBy
                            }}</strong></h6>
                    <br><br>
                    <h6>Approved Date: <strong class="text-uppercase">{{
                            date('F d, Y',
                            strtotime($institution->approvedDate))
                            }}</strong></h6>
                    <br><br>
                    @elseif($institution->status === '2')
                    <h6>Reason: <strong class="text-uppercase">{{
                            $institution->reason
                            }}</strong></h6>
                    <br><br>
                    <h6>Rejected By: <strong class="text-uppercase">{{
                            $institution->approvedBy
                            }}</strong></h6>
                    <br><br>
                    <h6 class="text-uppercase">Rejected Date: <strong>{{
                            date('F d, Y',
                            strtotime($institution->approvedDate))
                            }}</strong></h6>
                    <br><br>
                    @endif
                    <h6>Created by: <strong class="text-uppercase">{{
                            $institution->createdBy
                            }}</strong></h6>
                    <br><br>
                    <h6>Created Date: <strong class="text-uppercase">{{ date('F
                            d,Y',strtotime($institution->createdDate))}}</strong>
                    </h6>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- edit --}}
<div id="edit{{ $institution->ID }}" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Update
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inputter.institution.update',$institution->ID) }}" method="POST"
                class="needs-validation confirmation" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="form-row row">
                        {{-- code --}}
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Institution
                                Code</label>
                            <input type="text" name="code" class="form-control" id="validationCustom01"
                                value="{{ $institution->code }}" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- --}}
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Institution
                                Name</label>
                            <input type="text" name="name" class="form-control" id="validationCustom01"
                                value="{{ $institution->institutionName }}" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- --}}
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Address</label>
                            <input type="text" name="address" class="form-control" id="validationCustom01"
                                value="{{ $institution->address }}" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- code --}}
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Email Address</label>
                            <input type="email" name="institutionEmail" class="form-control" id="validationCustom01"
                                value="{{ $institution->institutionEmail }}" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- --}}
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Chief Dealer
                                Email</label>
                            <input type="email" name="chiefDealerEmail" class="form-control" id="validationCustom01"
                                value="{{ $institution->chiefDealerEmail }}" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- --}}
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Authoriser</label>
                            <select name="authoriser" id="validationCustom01" class="form-control" required>
                                <option value="">--Select--</option>
                                @foreach ($authorisers as $authoriser)
                                <option value="{{ $authoriser->email }}">{{
                                    $authoriser->firstName.'
                                    '.$authoriser->lastName }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- delete --}}
<div id="delete{{ $institution->ID }}" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Delete
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inputter.institution.delete',$institution->ID) }}" method="POST"
                class="needs-validation confirmation" novalidate>
                @csrf
                <div class="modal-body">
                    <label for="">Reason</label>
                    <input type="text" name="reason" class="form-control" required>
                    {{-- --}}
                    <label for="">Authoriser</label>
                    <select name="authoriser" id="validationCustom01" class="form-control" required>
                        <option value="">--Select--</option>
                        @foreach ($authorisers as $authoriser)
                        <option value="{{ $authoriser->email }}">{{
                            $authoriser->firstName.'
                            '.$authoriser->lastName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="updateButton">Delete</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>