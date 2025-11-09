@extends('backend.layout.app')
@section('title', 'Register Users')

<style>
    .select2-selection {
        height: 37px !important;
    }
</style>
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables Setting</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Table</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('sitting-table.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Table Name</label>
                        <input type="text" class="form-control" placeholder="Enter Table Name" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Assign Table</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('assign.sitting.table') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tableSelect">Select Table</label>
                            <select class="form-control" id="tableSelect" name="sitting_table_id" required>
                                <option value="" selected disabled>Select Table</option>
                                @foreach ($sitting_tables as $table)
                                    <option value="{{ $table->id }}">{{ $table->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="membersSelect">Select Members</label>
                            <select class="form-control" id="membersSelect" name="registration_ids[]" multiple required>
                                @foreach ($registrations as $registration)
                                    <option value="{{ $registration->id }}">{{ $registration->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tables</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Table Name</th>
                                <th>Total Assign Users</th>
                                <th>User List</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr No</th>
                                <th>Table Name</th>
                                <th>Total Assign Users</th>
                                <th>User List</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($sitting_tables as $sitting_table)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sitting_table->name }}</td>
                                    <td>{{ $sitting_table->registrations->count() }}</td>
                                    <td>{{ $sitting_table->registrations->pluck('name')->implode(', ') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $sitting_table->id }}">Edit</button>
                                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $sitting_table->id }}">Delete</button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $sitting_table->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $sitting_table->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $sitting_table->id }}">Edit Table</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('sitting-table.update', $sitting_table->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="name{{ $sitting_table->id }}">Table Name</label>
                                                        <input type="text" class="form-control" id="name{{ $sitting_table->id }}" name="name" value="{{ old('name', $sitting_table->name) }}" required>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Edit Modal -->

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $sitting_table->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $sitting_table->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $sitting_table->id }}">Confirm Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this table?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('sitting-table.destroy', $sitting_table->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Delete Confirmation Modal -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <!-- Include Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#membersSelect').select2();
        });
    </script>
@endsection
