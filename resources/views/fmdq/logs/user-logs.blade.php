@extends('layouts.app')
@section('title','RITCC log Management')

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
                                    @forelse ($logs as $log)
                                    <tr>
                                        <td>{{ $i++; }}</td>
                                        <td>{{ $log->username }}</td>
                                        <td>{{ $log->type }}</td>
                                        <td>{{ $log->activity }}</td>
                                        <td>{{ date('F d, Y',strtotime($log->date))}}</td>
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