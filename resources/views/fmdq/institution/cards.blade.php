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
                            <h5>All Institutions</h5>
                        </div>
                        <div class="dash-counts">
                            <h5>{{ $all }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-4">
                {{-- inputter --}}
                @if (auth()->user()->type ==='inputter')
                <h6><a href="{{ route('inputter.institution.index') }}" class="text-uppercase"> View
                        More <i class="fa fa-arrow-circle-right"></i></a></h6>
                @elseif (auth()->user()->type ==='authoriser')
                <h6><a href="{{ route('authoriser.institution.index') }}" class="text-uppercase">View More <i
                            class="fa fa-arrow-circle-right"></i></a></h6>
                @endif
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
                            <h5>Pending Institutions</h5>
                        </div>
                        <div class="dash-counts">
                            <h5>{{ $pending }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-3">
                {{-- inputter --}}
                @if (auth()->user()->type ==='inputter')
                <h6><a href="{{ route('inputter.institution.pending') }}" class="text-uppercase">View More <i
                            class="fa fa-arrow-circle-right"></i></a></h6>
                @elseif (auth()->user()->type ==='authoriser')
                <h6><a href="{{ route('authoriser.institution.pending') }}" class="text-uppercase">View More <i
                            class="fa fa-arrow-circle-right"></i></a></h6>
                @endif
            </div>
        </div>
    </div>
    {{-- approved --}}
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card bg-1">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-1">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5 class="text-white">Approved Institutions</h5>
                        </div>
                        <div class="dash-counts">
                            <h5 class="text-white">{{ $approved }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-1">
                {{-- inputter --}}
                @if (auth()->user()->type ==='inputter')
                <h6><a href="{{ route('inputter.institution.approved') }}" class="text-uppercase text-white">View More
                        <i class="fa fa-arrow-circle-right"></i></a></h6>
                @elseif (auth()->user()->type ==='authoriser')
                <h6><a href="{{ route('authoriser.institution.approved') }}" class="text-uppercase text-white">View More
                        <i class="fa fa-arrow-circle-right"></i></a>
                </h6>
                @endif
            </div>
        </div>
    </div>
    {{-- rejected --}}
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card bg-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5>Rejected Institutions</h5>
                        </div>
                        <div class="dash-counts">
                            <h5>{{ $rejected }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center bg-2">
                {{-- inputter --}}
                @if (auth()->user()->type ==='inputter')
                <h6><a href="{{ route('inputter.institution.rejected') }}" class="text-uppercase ">View More <i
                            class="fa fa-arrow-circle-right"></i></a></h6>
                @elseif (auth()->user()->type ==='authoriser')
                <h6><a href="{{ route('authoriser.institution.rejected') }}" class="text-uppercase ">View More <i
                            class="fa fa-arrow-circle-right"></i></a></h6>
                @endif
            </div>
        </div>
    </div>
</div>