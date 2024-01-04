<div class="page-header">
    <div class="content-page-header">
        @if (auth()->user()->type === 'inputter')
        <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#standard-modal"><i
                class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add
            Certificate</button>
        @endif
        {{-- modal --}}
        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Add Certificate</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('inputter.certificate.mgt.create') }}" method="POST" id="create"
                        class="needs-validation confirmation" novalidate>
                        @csrf
                        <div class="modal-body">
                            <div class="form-row row">
                                {{-- code --}}
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">Security Description</label>
                                    <input type="text" name="description" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">Auctioner</label>
                                    <select name="auctioneer" id="validationCustom01" class="form-control" required>
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
                                    <select name="securityType" id="validationCustom01" class="form-control" required>
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
                                    <input type="text" name="securityCode" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">ISIN Number</label>
                                    <input type="number" name="isinNumber" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="invalid-feedback">
                                        This field is required
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Issue Date</label>
                                    <input type="date" name="issueDate" class="form-control" id="validationCustom01"
                                        required>
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
                                    <input type="number" name="offerAmount" class="form-control" id="validationCustom01"
                                        required>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>