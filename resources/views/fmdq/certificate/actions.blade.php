<td class="d-flex align-items-center">
    <div class="dropdown dropdown-action">
        <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <ul>
                <li>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view{{ $security->id }}" href=""><i class="far fa-edit me-2"></i>View</a>

                </li>
                @if (auth()->user()->type === 'inputter' && !$security->approvedBy)
                <li>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit{{ $security->id }}" href=""><i class="far fa-edit me-2"></i>Edit</a>
                </li>
                <li>
                    <a class="dropdown-item" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete{{ $security->id }}" href=""><i class="far fa-trash-alt me-2"></i>Delete</a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</td>
