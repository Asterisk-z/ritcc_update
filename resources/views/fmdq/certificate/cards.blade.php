<div class="row">
    {{-- all --}}
    <div class="col-xl-3 col-sm-3 col-12">
        <div class="card bg-4">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-4">
                        <i class="fas fa-key"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5>All<br>Certificates</h5>
                        </div>
                        <div class="dash-counts">
                            <h5>{{ $all }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                {{-- inputter --}}
                @if (auth()->user()->type ==='inputter')
                <h6><a href="{{ route('inputter.certificate.mgt.dashboard') }}" class="text-uppercase"> View
                        More <i class="fa fa-arrow-circle-right"></i></a></h6>
                @elseif (auth()->user()->type ==='firs')
                <h6><a href="{{ route('firs.certificate.mgt.dashboard') }}" class="text-uppercase">View More <i
                            class="fa fa-arrow-circle-right"></i></a></h6>
                @endif
            </div>
        </div>
    </div>
    {{-- pending --}}
    <div class="col-xl-3 col-sm-3 col-12">
        <div class="card bg-3">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-3">
                        <i class="fas fa-key"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5>Pending Certificates</h5>
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
                <h6><a href="{{ route('inputter.certificate.mgt.pending') }}" class="text-uppercase">View More <i
                            class="fa fa-arrow-circle-right"></i></a></h6>
                @elseif (auth()->user()->type ==='firs')
                <h6><a href="{{ route('firs.certificate.mgt.pending') }}" class="text-uppercase">View More <i
                            class="fa fa-arrow-circle-right"></i></a></h6>
                @endif
            </div>
        </div>
    </div>
    {{-- approved --}}
    <div class="col-xl-3 col-sm-3 col-12">
        <div class="card bg-1">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-1">
                        <i class="fas fa-key"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5 class="text-white">Approved Certificates</h5>
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
                <h6><a href="{{ route('inputter.certificate.mgt.approved') }}" class="text-uppercase text-white">View
                        More <i class="fa fa-arrow-circle-right"></i></a></h6>
                @elseif (auth()->user()->type ==='firs')
                <h6><a href="{{ route('firs.certificate.mgt.approved') }}" class="text-uppercase text-white">View More
                        <i class="fa fa-arrow-circle-right"></i></a>
                </h6>
                @endif
            </div>
        </div>
    </div>
    {{-- rejected --}}
    <div class="col-xl-3 col-sm-3 col-12">
        <div class="card bg-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon bg-2">
                        <i class="fas fa-key"></i>
                    </span>
                    <div class="dash-count">
                        <div class="dash-title">
                            <h5>Rejected Certificates</h5>
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
                <h6><a href="{{ route('inputter.certificate.mgt.rejected') }}" class="text-uppercase ">View More <i
                            class="fa fa-arrow-circle-right"></i></a></h6>
                @elseif (auth()->user()->type ==='firs')
                <h6><a href="{{ route('firs.certificate.mgt.rejected') }}" class="text-uppercase ">View More <i
                            class="fa fa-arrow-circle-right"></i></a></h6>
                @endif
            </div>
        </div>
    </div>

</div>