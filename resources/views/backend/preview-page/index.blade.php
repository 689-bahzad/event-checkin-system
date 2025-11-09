@extends('backend.layout.app')
@section('title', 'Register Users')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">All Register Users</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Register Users</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Lucky Number</th>
                                <th>Has Checked</th>
                                <th>Category</th>
                                <th>Table Name</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Lucky Number</th>
                                <th>Has Checked</th>
                                <th>Category</th>
                                <th>Table Name</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($registerUsers as $eventUser)
                                <tr>
                                    <td>{{ $eventUser->count }}</td>
                                    <td>{{ $eventUser->name }}</td>
                                    <td>{{ $eventUser->email }}</td>
                                    <td>{{ $eventUser->phone_number }}</td>
                                    <td>
                                        @if ($eventUser->qr_status)
                                            {{ $eventUser->lucky_number }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($eventUser->qr_status)
                                            <p>&#10004;</p>
                                        @else
                                        <p>&#10008;</p>
                                        @endif
                                    </td>
                                    <td>{{ $eventUser->type }}</td>
                                    <td>{{ $eventUser->sittingTable->first()->name?? '-' }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
