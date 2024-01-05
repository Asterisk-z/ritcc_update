<div class="content-page-header">
    @if (auth()->user()->type == 'inputter' || auth()->user()->type == 'super')
    <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#standard-modal"><i
            class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add
        Auction</button>
    {{-- modal --}}
    <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Add Auction</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('inputter.auction.mgt.create') }}" method="POST" id="myForm"
                    class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="form-row row">
                            {{-- code --}}
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">Security</label>
                                <select name="securityId" id="validationCustom01" class="form-control" required>
                                    <option value="">--Select--</option>
                                    @forelse ($securities as $security)
                                    {{-- <option value="{{ $security->id }}">{{ $security->securityCode ." |
                                        ".$security->auctioneer->email ?? '' }}</option> --}}
                                    @empty

                                    @endforelse
                                </select>
                                <div class="invalid-feedback">
                                    This field is required
                                </div>
                            </div>
                            {{-- --}}
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Offer Date</label>
                                <input type="date" name="offerDate" class="form-control" id="validationCustom01"
                                    required>
                                <div class="invalid-feedback">
                                    This field is required
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Auction Start Time</label>
                                <input type="datetime-local" name="auction_start_time" class="form-control"
                                    id="validationCustom01" required>
                                <div class="invalid-feedback">
                                    This field is required
                                </div>
                            </div>
                            {{-- --}}
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Bids Close Time</label>
                                <input type="datetime-local" name="bids_close_time" class="form-control"
                                    id="validationCustom01" required>
                                <div class="invalid-feedback">
                                    This field is required
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Bids Result Time</label>
                                <input type="datetime-local" name="bids_result_time" class="form-control"
                                    id="validationCustom01" required>
                                <div class="invalid-feedback">
                                    This field is required
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Minimum Rate</label>
                                <input type="number" name="minimum_rate" class="form-control" id="validationCustom01"
                                    required>
                                <div class="invalid-feedback">
                                    This field is required
                                </div>
                            </div>
                            {{-- --}}
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Maximum Rate</label>
                                <input type="number" name="maximum_rate" class="form-control" id="validationCustom01"
                                    required>
                                <div class="invalid-feedback">
                                    This field is required
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Create Auction</button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <button type="button" class="btn btn-primary mt-1"
        style="background-color: transparent; border: transparent;"></button>
    @endif

    <div class="list-btn">
        @include('fmdq.auction.buttons')
    </div>
</div>