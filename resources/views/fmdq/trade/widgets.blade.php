<div class="row">
    {{-- all --}}
    <div class="col-xl-3 col-sm-3 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-4">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">All Auctions</div>
                        <div class="dash-counts">
                            <p>{{ $all }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- pending --}}
    <div class="col-xl-3 col-sm-3 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-3">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">Pending Auctions</div>
                        <div class="dash-counts">
                            <p>{{ $pending }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- approved --}}
    <div class="col-xl-3 col-sm-3 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-1">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">Approved Auctions</div>
                        <div class="dash-counts">
                            <p>{{ $approved }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- rejected --}}
    <div class="col-xl-3 col-sm-3 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-2">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">Rejected Auctions</div>
                        <div class="dash-counts">
                            <p>{{ $rejected }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>