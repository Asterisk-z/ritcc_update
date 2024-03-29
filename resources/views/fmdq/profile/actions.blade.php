<td class="d-flex align-items-center">
    <div class="dropdown dropdown-action">
        <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i
                class="fas fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <ul>
                <li>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view{{ $profile->id }}" href=""><i
                            class="far fa-eye me-2"></i>View</a>
                </li>
                {{-- --}}
                @if (auth()->user()->type === 'inputter')
                @if (!($profile->status === '0'|| $profile->status ===
                '4'))
                @if ($profile->updateFlag != '0')
                <li>
                    <a class="dropdown-item" class="dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#edit{{ $profile->id }}" href=""><i class="far fa-edit me-2"></i>Edit</a>
                </li>
                <li>
                    <a class="dropdown-item" class="dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#delete{{ $profile->id }}" href=""><i
                            class="far fa-trash-alt me-2"></i>Deactivate</a>
                </li>
                @endif
                @endif
                @endif

                @if (auth()->user()->type === 'authoriser')
                @if ($profile->status === '0')
                <li>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#approve{{ $profile->id }}"
                        href=""><i class="fa fa-check me-2"></i>Approve </a>
                </li>
                <li>
                    <a class="dropdown-item" class="dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#reject{{ $profile->id }}" href=""><i class="fa fa-times me-2"></i>Reject</a>
                </li>
                @elseif ($profile->updateFlag === '0')
                <li>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#approveUpdate{{ $profile->id }}"
                        href=""><i class="fa fa-check me-2"></i>Approve
                        Update</a>
                </li>
                <li>
                    <a class="dropdown-item" class="dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#rejectUpdate{{ $profile->id }}" href=""><i class="fa fa-times me-2"></i>Reject
                        Update</a>
                </li>
                @elseif ($profile->deleteFlag === '0')
                <li>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#approveDelete{{ $profile->id }}"
                        href=""><i class="fa fa-check me-2"></i>Approve
                        Delete</a>
                </li>
                <li>
                    <a class="dropdown-item" class="dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#rejectDelete{{ $profile->id }}" href=""><i class="fa fa-times me-2"></i>Reject
                        Delete</a>
                </li>
                @endif
                @endif
            </ul>
        </div>
    </div>
</td>
{{-- view --}}
<div class="modal fade" id="view{{ $profile->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h4 class="modal-title" id="myCenterModalLabel">Center
                    modal
                </h4> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-text">
                    <h6>NAME: <strong>{{ $profile->firstName.'
                            '.$profile->lastName }}</strong></h6>
                    <br>
                    <h6>CONTACT EMAIL: <strong>{{ $profile->email }}</strong>
                    </h6>
                    <br>
                    <h6>CONTACT PHONE NUMBER: <strong>{{ $profile->mobile ?? 'No
                            information available'
                            }}</strong>
                    </h6>
                    <br>
                    <h6>ROLE: <strong>{{ $profile->package->Name ?? 'No
                            information available'
                            }}</strong>
                    </h6>
                    <br>
                    <h6>INSTIUTION: <strong>{{
                            $profile->institution->institutionName ?? 'No
                            information available'
                            }}</strong>
                    </h6>
                    <hr>
                    <h6>CREATED BY: <strong>{{
                            $profile->inputter ?? 'No
                            information available'
                            }}</strong>
                    </h6>
                    <br>
                    <h6>CREATED DATE: <strong>{{
                            date('F d, Y',strtotime( $profile->inputDate)) ??
                            'No
                            information available'
                            }}</strong>
                    </h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- update --}}
<div id="edit{{ $profile->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Edit</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inputterProfileUpdate',$profile->id) }}" method="POST"
                class="needs-validation confirmation" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="form-row row">
                        {{-- code --}}
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">First Name</label>
                            <input type="text" name="firstName" class="form-control" id="validationCustom01"
                                value="{{  $profile->firstName }}" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- --}}
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Last Name</label>
                            <input type="text" name="lastName" class="form-control" value="{{  $profile->lastName }}"
                                id="validationCustom01" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- --}}
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Email Address</label>
                            <input type="email" name="email" class="form-control" id="validationCustom01"
                                value="{{  $profile->email }}" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- --}}
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Phone Number</label>
                            <input type="number" name="mobile" min="1" class="form-control" id="validationCustom01"
                                value="{{  $profile->mobile }}" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- --}}
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Role</label>
                            <select name="package" id="packageSelect" class="form-control" required>
                                <option value="{{ $profile->Package }}" selected>{{ $profile->package->Name }}</option>
                                @foreach ($packages as $package)
                                <option value="{{ $package->ID }}">{{ $package->Name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- --}}
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Institution</label>
                            <select name="institution" id="validationCustom01" class="form-control" required>
                                <option value="{{ $profile->Institution }}" selected>{{
                                    $profile->institution->institutionName }}</option>
                                @foreach ($institutions as $institution)
                                <option value="{{ $institution->ID }}">{{ $institution->institutionName
                                    }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>
                        {{-- --}}
                        <div id="accountNumber" style="display: none;">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="role">RTGS Account
                                        Number</label>
                                    <input type="number" class="form-control" min="0" name="RTGS"
                                        placeholder="Leave empty if profile is an FMDQ Profile">
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="role">FMDQ
                                        Custodian Account Number</label>
                                    <input type="number" class="form-control" min="0"
                                        placeholder="Leave empty if profile is an FMDQ Profile" name="FMDQ">
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- --}}
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Authoriser</label>
                            <select name="authoriser" id="validationCustom01" class="form-control" required>
                                <option value="">--Select--</option>
                                @forelse ($authorisers as $authoriser)
                                <option value="{{ $authoriser->email }}">{{ $authoriser->firstName.'
                                    '.$authoriser->lastName }}</option>
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
                    <button type="submit" class="btn btn-primary me-2">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- deactivate --}}
<div class="modal fade" id="delete{{ $profile->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inputter.profile.deactivateProfile',$profile->id) }}" method="POST"
                class="needs-validation confirmation" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-lg-12 mb-3">
                            <label for="validationCustom01">Reason for
                                Deactivation <span class="text-danger">*</span></label>
                            <input type="text" name="reason" class="form-control" id="validationCustom01" required>
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Authoriser <span class="text-danger">*</span></label>
                            <select name="authoriser" class="form-control" required>
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
                    <button type="submit" class="btn btn-primary">Deactivate</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- approve create --}}
<div id="approve{{ $profile->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Are you sure you want to approve this profile?
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('authoriser.profile.approveCreate',$profile->id) }}" method="POST"
                class="needs-validation confirmation" novalidate>
                @csrf
                <div class="modal-body">
                    {{-- <h4 class="text-center">Are you sure you want to approve this profile?</h4>
                    <br> --}}
                    <div class="text-black">
                        <h5>Details</h5>
                        <br>
                        <h6>NAME: <strong>{{ $profile->firstName.' '.$profile->lastName
                                }}</strong></h6>
                        <br>
                        <h6>EMAIL ADDRESS: <strong>{{ $profile->email}}</strong></h6>
                        <br>
                        <h6>PHONE NUMBER: <strong>{{ $profile->mobile}}</strong></h6>
                        <br>
                        <h6>INSTITUTION: <strong>{{ $profile->institution->institutionName
                                }}</strong></h6>
                        <br>
                        <h6>ROLE: <strong>{{ $profile->package->Name }}</strong></h6>
                        <br>
                        <h6>Inputter: <strong>{{ $profile->inputter }}</strong></h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Approve</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- reject create --}}
<div id="reject{{ $profile->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h4 class="modal-title" id="standard-modalLabel">Approve
                </h4> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('authoriser.profile.rejectCreate',$profile->id) }}" method="POST"
                class="needs-validation confirmation" novalidate>
                @csrf
                <div class="modal-body">
                    <h6 class="text-center">Are you sure you want to reject
                        this
                        profile?</h6>
                    <label for="">Reason for Rejection</label>
                    <input type="text" class="form-control" name="reason" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Reject</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- approve update --}}
<div id="approveUpdate{{ $profile->id }}" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Are you sure you want to approve?
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ route('authoriserProfileApproveUpdate',$profile->id) }}" method="POST"
                class="needs-validation confirmation" novalidate>
                @csrf
                @php
                $temps = \App\Models\ProfileTemp::with('packages','institutions')->where('profileRef',
                $profile->id)->get();
                @endphp
                @foreach ($temps as $temp)
                <div class="modal-body">
                    <div class="text-black">
                        <h5 class="text-uppercase text-center">Updated Details</h5>
                        <br>
                        <h6>Name: <strong>{{ $temp->firstName.' '.$temp->lastName
                                }}</strong></h6>
                        <br>
                        <h6>Email Address: <strong>{{ $temp->email}}</strong></h6>
                        <br>
                        <h6>Phone Number: <strong>{{ $temp->mobile}}</strong></h6>
                        <br>
                        <h6>Institution: <strong>{{ $temp->institutions->institutionName
                                }}</strong></h6>
                        <br>
                        <h6>Role: <strong>{{ $temp->packages->Name}}</strong></h6>
                        <br>
                        @if ($temp->type ==='auctioneer' || $temp->type ==='bidder')
                        <h6>FMDQ Custodian Number: <strong>{{ $temp->fmdqNumber}}</strong></h6>
                        <br>
                        <h6>RTGS Number: <strong>{{ $temp->rtgsNumber}}</strong></h6>
                        <br>
                        @endif
                        <h6>Updated By: <strong>{{ $temp->inputter }}</strong></h6>
                    </div>
                </div>
                @endforeach

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-3">Approve</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- reject update --}}
<div id="rejectUpdate{{ $profile->id }}" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h4 class="modal-title" id="standard-modalLabel">Approve
                </h4> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('authoriserProfileRejectUpdate',$profile->id) }}" method="POST"
                class="needs-validation confirmation" novalidate>
                @csrf
                <div class="modal-body">
                    <label for="">Reason for Rejection</label>
                    <input type="text" class="form-control" name="reason" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Reject</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- approve deactivate --}}
<div id="approveDelete{{ $profile->id }}" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h4 class="modal-title" id="standard-modalLabel">Approve
                </h4> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('authoriserProfileApproveDelete',$profile->id) }}" method="POST"
                class="needs-validation confirmation" novalidate>
                @csrf
                <div class="modal-body">
                    <h5 class="text-center text-uppercase">Are you sure you want
                        to approve the
                        deactivation of this profile?</h5>
                    <hr>
                    <div class="card-text">
                        <h6>NAME: <strong>{{ $profile->firstName.'
                                '.$profile->lastName }}</strong></h6>
                        <br>
                        <h6>CONTACT EMAIL: <strong>{{ $profile->email
                                }}</strong>
                        </h6>
                        <br>
                        <h6>CONTACT PHONE NUMBER: <strong>{{ $profile->mobile ??
                                'No
                                information available'
                                }}</strong>
                        </h6>
                        <br>
                        <h6>PACKAGE: <strong>{{ $profile->package->Name ?? 'No
                                information available'
                                }}</strong>
                        </h6>
                        <br>
                        <h6>INSTIUTION: <strong>{{
                                $profile->institution->institutionName ?? 'No
                                information available'
                                }}</strong>
                        </h6>
                        <br>
                        <h6>CREATED BY: <strong>{{
                                $profile->inputter ?? 'No
                                information available'
                                }}</strong>
                        </h6>
                        <br>
                        <h6>CREATED DATE: <strong>{{
                                date('F d, Y',strtotime( $profile->inputDate))
                                ??
                                'No
                                information available'
                                }}</strong>
                        </h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Approve</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- reject deactivate --}}
<div id="rejectDelete{{ $profile->id }}" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h4 class="modal-title" id="standard-modalLabel">Approve
                </h4> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('authoriserProfileRejectDelete',$profile->id) }}" method="POST"
                class="needs-validation confirmation" novalidate>
                @csrf
                <div class="modal-body">
                    <label for="">Reason for Rejection</label>
                    <input type="text" class="form-control" name="reason" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-3">Reject</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>