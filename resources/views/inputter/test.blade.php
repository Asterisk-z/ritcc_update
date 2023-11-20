<div class="row">
    <div class="col-sm-12">
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title">Profiles List</h4>
            </div> --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-stripped table-bordered" id="example2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Type</th>
                                {{-- <th>Inputter</th> --}}
                                {{-- <th>Authoriser</th> --}}
                                <th>Date Created</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($profiles as $profile)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{ $profile->email }} </td>
                                <td></td>
                                {{-- <td>{{ $profile->InputterID }}</td> --}}
                                {{-- <td>{{ $profile->AuthoriserID }}</td> --}}


                                <td>
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="edit-invoice.html"><i
                                                    class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-file-alt me-2"></i>Convert to
                                                Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark as
                                                sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Estimate</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark as
                                                Accepted</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-times-circle me-2"></i>Mark as
                                                Rejected</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>