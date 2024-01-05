@extends('layouts.app')
@section('title','RITCC All Activities')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        {{-- tables --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-stripped" id="example2">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $log->username }}</td>
                                        <td>{{ $log->type }}</td>
                                        <td>{{ $log->activity }}</td>
                                        <td>{{ date('F d, Y',strtotime($log->date))}}</td>
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