@extends('layouts.app')
@section('title','RITCC Profile Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        @include('fmdq.profile.cards')
        @include('fmdq.profile.buttons')
        {{-- --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-center table-stripped table-bordered" id="example1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Package</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($profiles as $profile)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $profile->firstName .' '.$profile->lastName }}</td>
                                        <td>{{ $profile->email }}</td>
                                        <td>{{ $profile->package->Name }}</td>
                                        <td>{{ date('F d, Y',strtotime($profile->inputDate))}}</td>
                                        @if ($profile->status ==='0')
                                        <td><span class="badge bg-3">Pending Approval</span></td>
                                        @elseif($profile->status ==='1')
                                        <td><span class="badge bg-1">Approved</span></td>
                                        @elseif($profile->status ==='2')
                                        <td><span class="badge bg-2">Rejected</span></td>
                                        @elseif($profile->status ==='4')
                                        <td><span class="badge bg-3">Pending Delete</span></td>
                                        @endif
                                        @include('fmdq.profile.actions')
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection