@extends('layouts.app')
@section('title','RITCC Profile Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
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
                                <div class="dash-title">All Profiles</div>
                                <div class="dash-counts">
                                    <p>{{ $all }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- pending --}}
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-3">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Pending Profiles</div>
                                <div class="dash-counts">
                                    <p>{{ $pending }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- approved --}}
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-1">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Approved Profiles</div>
                                <div class="dash-counts">
                                    <p>{{ $approved }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- rejected --}}
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-2">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Rejected Profiles</div>
                                <div class="dash-counts">
                                    <p>{{ $rejected }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- tables --}}
        {{-- --}}
        <div class="page-header">
            <div class="content-page-header">
                {{-- <h5>Pages list</h5> --}}
                <a class="btn btn-primary" href="add-pages.html"><i class="fa fa-plus-circle me-2"
                        aria-hidden="true"></i>Add Profiles</a>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="{{ route('profile.index') }}"><i class="fas fa-users me-2"
                                    aria-hidden="true"></i>All</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="add-pages.html"><i class="fa fa-pause me-2"
                                    aria-hidden="true"></i>Pending</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="add-pages.html"><i class="fa fa-check me-2"
                                    aria-hidden="true"></i>Approved</a>
                        </li>
                        <li>
                            <a class="btn btn-outline-primary" href="add-pages.html"><i class="fa fa-times me-2"
                                    aria-hidden="true"></i>Rejected</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-center table-stripped table-bordered" id="example2">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Package</th>
                                        {{-- <th>Inputter</th> --}}
                                        {{-- <th>Authoriser</th> --}}
                                        <th>Date Created</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @forelse ($profiles as $profile)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>
                                            <h2 class="table-avatar">{{ $profile->firstName.' '.$profile->lastName }}
                                            </h2>
                                        </td>
                                        <td>{{ $profile->email }}</td>
                                        <td>{{ $profile->package->Name }}</td>
                                        <td>{{ date('F d, Y',strtotime($profile->InputDate))}}</td>
                                        @if ($profile->status ==='0')
                                        <td><span class="badge bg-2">Pending Approval</span></td>
                                        @elseif($profile->status ==='1')
                                        <td><span class="badge bg-1">Approved</span></td>
                                        @elseif($profile->status ==='2')
                                        <td><span class="badge bg-2">Rejected</span></td>
                                        @elseif ($profile->status ==='3')
                                        <td><span class="badge bg-1">Pending Update</span></td>
                                        @elseif($profile->status ==='4')
                                        <td><span class="badge bg-1">Pending Delete</span></td>
                                        @endif
                                        <td class="d-flex align-items-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item" href="edit-user.html"><i
                                                                    class="far fa-edit me-2"></i>View</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="edit-user.html"><i
                                                                    class="far fa-edit me-2"></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                                data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    {{ 'No information available yet' }}
                                    @endforelse
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