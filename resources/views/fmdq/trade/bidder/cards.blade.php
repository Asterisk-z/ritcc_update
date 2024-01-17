<div class="row">
    {{-- all --}}
    <div class="col-xl-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-4">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5>All Trades</h5>
                        </div>
                        <div class="dash-counts">
                            <h5>{{ $all }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-4">
                <h6><a href="{{ route('bidderDashboard') }}" class="text-uppercase"> View
                        More <i class="fa fa-arrow-circle-right"></i></a></h6>
            </div>
        </div>
    </div>
    {{-- pending --}}
    <div class="col-xl-4 col-sm-6 col-12">
        <div class="card bg-3">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5>Pending Trades</h5>
                        </div>
                        <div class="dash-counts">
                            <h5>{{ $pending }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-3">
                <h6><a href="{{ route('myPendingTrades') }}" class="text-uppercase text-white">View More
                        <i class="fa fa-arrow-circle-right"></i></a></h6>
            </div>
        </div>
    </div>

    {{-- awarded --}}
    <div class="col-xl-4 col-sm-6 col-12">
        <div class="card bg-1">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-1">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5 class="text-white">Awarded Trades</h5>
                        </div>
                        <div class="dash-counts">
                            <h5 class="text-white">{{ $approved }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-1">
                <h6><a href="{{ route('myAwardedTrades') }}" class="text-uppercase text-white">View More
                        <i class="fa fa-arrow-circle-right"></i></a></h6>
            </div>
        </div>
    </div>
</div>