@extends('layouts.app')
@section('title','RITCC System Settings')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            {{-- --}}
            <div class="col-xl-4 col-sm-4 col-12">
                <a href="{{ route('packages') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div class="dash-count">
                                    <h2 class="text-uppercase">Packages</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            {{-- --}}
            <div class="col-xl-4 col-sm-4 col-12">
                <a href="{{ route('auctionWindows') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div class="dash-count">
                                    <h2 class="text-uppercase">Auction Windows</h2>

                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            {{-- --}}
            <div class="col-xl-4 col-sm-4 col-12">
                <a href="{{ route('publicHolidays') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div class="dash-count">
                                    <h2 class="text-uppercase">Public Holidays</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            {{-- --}}
            <div class="col-xl-4 col-sm-4 col-12">
                <a href="{{ route('securityType') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <div class="dash-count">
                                    <h2 class="text-uppercase">Security Type</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection