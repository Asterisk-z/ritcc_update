<div class="page-header">
    <div class="content-page-header">
        @if (auth()->user()->type ==='inputter')
        {{-- <h5>Pages list</h5> --}}
        <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#standard-modal"><i
                class="fa fa-plus-circle me-2" aria-hidden="true"></i>Create
            Profile
        </button>
        {{-- modal --}}
        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Create Profile</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('inputter.profile.create') }}" method="POST"
                        class="needs-validation confirmation" novalidate>
                        @csrf
                        <div class="modal-body">
                            <div class="form-row row">
                                {{-- code --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">First Name</label>
                                    <input type="text" name="firstName" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Last Name</label>
                                    <input type="text" name="lastName" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Email Address</label>
                                    <input type="email" name="email" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Phone Number</label>
                                    <input type="number" name="mobile" min="1" class="form-control"
                                        id="validationCustom01" required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Role</label>
                                    <select name="package" id="packageSelect" class="form-control" required>
                                        <option value="">--Select--</option>
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
                                        <option value="">--Select--</option>
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
                            <button type="submit" class="btn btn-primary">Create</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- --}}
        @endif
    </div>
</div>