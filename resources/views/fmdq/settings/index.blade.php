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
                                    <h4>Packages</h4>
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
                                    <h4>Auction Windows</h4>

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
                                    <h4>Public Holidays</h4>
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