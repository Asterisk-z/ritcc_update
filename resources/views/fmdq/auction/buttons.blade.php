<ul class="filter-list">
    {{-- @dd(str_contains(request()->url(), 'pending'))  --}}
    <li>
        <a class="btn btn-outline-primary" href="{{ route('auction.mgt.dashboard') }}"><i class="fas fa-users me-2" aria-hidden="true"></i>All</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{ route('auction.mgt.pending') }}"><i class="fa fa-pause me-2" aria-hidden="true"></i>Pending</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{ route('auction.mgt.approved') }}"><i class="fa fa-check me-2" aria-hidden="true"></i>Approved</a>
    </li>
    <li>
        <a class="btn btn-outline-primary" href="{{route('auction.mgt.rejected') }}"><i class="fa fa-times me-2" aria-hidden="true"></i>Rejected</a>
    </li>
</ul>
