@extends('layouts.app')
@section('title','RITCC Institution Management')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- cards --}}
        @include('fmdq.institution.cards')
        @include('fmdq.institution.buttons')

        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-center table-stripped table-bordered" id="example1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date Created</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($institutions as $institution)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $institution->code }}</td>
                                        <td>{{ $institution->institutionName }}</td>
                                        <td>{{ $institution->institutionEmail }}</td>
                                        <td>{{ date('F d, Y',strtotime($institution->createdDate))}}</td>
                                        @if ($institution->status ==='0')
                                        <td><span class="badge bg-3">Pending Approval</span></td>
                                        @elseif($institution->status ==='1')
                                        <td><span class="badge bg-1">Approved</span></td>
                                        @elseif($institution->status ==='2')
                                        <td><span class="badge bg-2">Rejected</span></td>
                                        @elseif ($institution->status ==='3')
                                        <td><span class="badge bg-3">Pending Update</span></td>
                                        @elseif($institution->status ==='4')
                                        <td><span class="badge bg-3">Pending Delete</span></td>
                                        @endif
                                        @include('fmdq.institution.actions')
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


@section('script')
<script>

</script>
@endsection