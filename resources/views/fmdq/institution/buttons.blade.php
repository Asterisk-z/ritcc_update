<div class="page-header">
    <div class="content-page-header">
        @if (auth()->user()->type === 'inputter')
        {{-- <h5>Pages list</h5> --}}
        <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#standard-modal"><i
                class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add
            Institution</button>
        {{-- modal --}}
        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Add Institution</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('inputter.institution.create') }}" method="POST"
                        class="needs-validation confirmation" novalidate>
                        @csrf
                        <div class="modal-body">
                            <div class="form-row row">
                                {{-- code --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Institution Code</label>
                                    <input type="text" name="code" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Institution Name</label>
                                    <input type="text" name="name" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">Address</label>
                                    <input type="text" name="address" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- code --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Institution Email</label>
                                    <input type="email" name="institutionEmail" class="form-control"
                                        id="validationCustom01" required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Chief Dealer Email</label>
                                    <input type="email" name="chiefDealerEmail" class="form-control"
                                        id="validationCustom01" required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 mb-3">
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
                                </div> --}}
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
        @endif

    </div>
</div>