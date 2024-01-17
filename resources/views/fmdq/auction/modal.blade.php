{{-- view modal --}}
<div id="view{{ $auction->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h4 class="modal-title" id="standard-modalLabel">View
                </h4> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h6>Security Code : <strong>{{ $auction->securityCode
                            }}</strong></h6>
                    <br>
                    <h6>Offer Amount : <strong>{{ $auction->offerAmount
                            }}</strong></h6>
                    <br>
                    <h6>Auctioneer Email : <strong>{{ $auction->auctioneerEmail
                            }}</strong></h6>
                    <br>
                    <h6>Security ISIN NUmber : <strong>{{ $auction->isinNumber
                            }}</strong></h6>
                    <br>
                    <h6>Ofer Date : <strong>{{ date('F d, Y',strtotime($auction->offerDate)) }}</strong>
                    </h6>
                    <br>
                    <h6>Auction Start Time : <strong>{{ date('F d, Y
                            h:i',strtotime($auction->auctionStartTime))
                            }}</strong></h6>
                    <br>
                    <h6>Bid Close Time : <strong>{{ date('F d, Y
                            h:i',strtotime($auction->bidCloseTime))
                            }}</strong></h6>
                    <br>
                    <h6>Bid Result Time : <strong>{{ date('F d, Y
                            h:i',strtotime($auction->bidResultTime))
                            }}</strong></h6>
                    <br>
                    <h6>Minimum Rate : <strong>{{ $auction->minimumRate
                            }}</strong></h6>
                    <br>
                    <h6>Maximum Rate : <strong>{{ $auction->maximumRate
                            }}</strong></h6>
                    <br>
                    <h6>Inputter: <strong>{{ $auction->createdBy }}</strong>
                    </h6>
                    <br>
                    <h6>Created Date: <strong>{{ date('F d, Y',strtotime($auction->createdDate))}}</strong>
                    </h6>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>