@if (auth()->user()->type ==='super')
<ul class="filter-list">
    {{-- @dd(str_contains(request()->url(), 'pending')) --}}
    <li>
        <a class="btn btn-outline-primary" href="{{ route('certificate.mgt.dashboard') }}"><i class="fas fa-users me-2"
                aria-hidden="true"></i>All</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{ route('certificate.mgt.pending') }}"><i class="fa fa-pause me-2"
                aria-hidden="true"></i>Pending</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{ route('certificate.mgt.approved') }}"><i class="fa fa-check me-2"
                aria-hidden="true"></i>Approved</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{route('certificate.mgt.rejected') }}"><i class="fa fa-times me-2"
                aria-hidden="true"></i>Rejected</a>
    </li>
</ul>
@elseif (auth()->user()->type ==='inputter')
<ul class="filter-list">
    {{-- @dd(str_contains(request()->url(), 'pending')) --}}
    <li>
        <a class="btn btn-outline-primary" href="{{ route('inputter.certificate.mgt.dashboard') }}"><i
                class="fas fa-users me-2" aria-hidden="true"></i>All</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{ route('inputter.certificate.mgt.pending') }}"><i
                class="fa fa-pause me-2" aria-hidden="true"></i>Pending</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{ route('inputter.certificate.mgt.approved') }}"><i
                class="fa fa-check me-2" aria-hidden="true"></i>Approved</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{route('inputter.certificate.mgt.rejected') }}"><i
                class="fa fa-times me-2" aria-hidden="true"></i>Rejected</a>
    </li>
</ul>
@elseif (auth()->user()->type ==='firs')
<ul class="filter-list">
    {{-- @dd(str_contains(request()->url(), 'pending')) --}}
    <li>
        <a class="btn btn-outline-primary" href="{{ route('firs.certificate.mgt.dashboard') }}"><i
                class="fas fa-users me-2" aria-hidden="true"></i>All</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{ route('firs.certificate.mgt.pending') }}"><i
                class="fa fa-pause me-2" aria-hidden="true"></i>Pending</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{ route('firs.certificate.mgt.approved') }}"><i
                class="fa fa-check me-2" aria-hidden="true"></i>Approved</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{route('firs.certificate.mgt.rejected') }}"><i
                class="fa fa-times me-2" aria-hidden="true"></i>Rejected</a>
    </li>
</ul>
@endif
