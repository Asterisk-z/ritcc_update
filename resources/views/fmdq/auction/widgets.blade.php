        <div class="row">
            {{-- all --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card bg-2">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-4">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title text-white">All Auctions</div>
                                <div class="dash-counts">
                                    <p class="text-white" style="font-size:25px">{{ $all }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- pending --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card  bg-1">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-3">
                                <i class="fas fa-users text-white"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title text-white">Pending Auctions</div>
                                <div class="dash-counts">
                                    <p class="text-white" style="font-size:25px">{{ $pending }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- approved --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card  bg-3">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-1">
                                <i class="fas fa-users text-white"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title text-white">Approved Auctions</div>
                                <div class="dash-counts">
                                    <p class="text-white" style="font-size:25px">{{ $approved }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- rejected --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card bg-2">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-4">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title text-white">Rejected Auctions</div>
                                <div class="dash-counts">
                                    <p class="text-white" style="font-size:25px">{{ $rejected }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- rejected --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card  bg-1">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-3">
                                <i class="fas fa-users text-white"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title text-white">Running Auctions</div>
                                <div class="dash-counts">
                                    <p class="text-white" style="font-size:25px">{{ $rejected }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- rejected --}}
            <div class="col-xl-4 col-sm-3 col-12">
                <div class="card  bg-3">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-1">
                                <i class="fas fa-users text-white"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title text-white">Closed Auctions</div>
                                <div class="dash-counts">
                                    <p class="text-white" style="font-size:25px">{{ $rejected }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
