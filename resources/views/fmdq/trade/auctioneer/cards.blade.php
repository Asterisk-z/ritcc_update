<div class="row">
    {{-- all --}}
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-4">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5>My Auctions</h5>
                        </div>
                        <div class="dash-counts">
                            <h5>{{ $all }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-4">
                <h6><a href="{{ route('myAuctions') }}" class="text-uppercase"> View
                        More <i class="fa fa-arrow-circle-right"></i></a></h6>
            </div>
        </div>
    </div>
    {{-- pending --}}
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card bg-3">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5>Pending Auctions</h5>
                        </div>
                        <div class="dash-counts">
                            <h5>{{ $pending }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-3">
                <h6><a href="{{ route('myPendingAuctions') }}" class="text-uppercase text-white">View More
                        <i class="fa fa-arrow-circle-right"></i></a></h6>
            </div>
        </div>
    </div>

    {{-- awarded --}}
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card bg-1">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-1">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5 class="text-white">Approved Auctions</h5>
                        </div>
                        <div class="dash-counts">
                            <h5 class="text-white">{{ $approved }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-1">
                <h6><a href="{{ route('myApprovedAuctions') }}" class="text-uppercase text-white">View More
                        <i class="fa fa-arrow-circle-right"></i></a></h6>
            </div>
        </div>
    </div>

    {{-- rejected --}}
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card bg-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-2">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5 class="text-white">Rejected Auctions</h5>
                        </div>
                        <div class="dash-counts">
                            <h5 class="text-white">{{ $rejected }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-2">
                <h6><a href="{{ route('myRejectedAuctions') }}" class="text-uppercase text-white">View More
                        <i class="fa fa-arrow-circle-right"></i></a></h6>
            </div>
        </div>
    </div>
</div>