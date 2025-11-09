@extends('backend.layout.app')
@section('title', 'Register Users')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">All Registered Users</h1>

    <!-- DataTable Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Registered Users</h6>
            <div class="d-flex">
                <!-- Export Button -->
                <button
                    type="button"
                    class="btn btn-warning confirm-action ml-2"
                    data-toggle="modal"
                    data-target="#confirmModal"
                    data-href="{{ route('admin.register.users.export') }}"
                    data-message="Are you sure you want to export all registered users?"
                >Export</button>

                <!-- Import Button -->
                <button
                    type="button"
                    class="btn btn-info ml-2"
                    data-toggle="modal"
                    data-target="#importModal"
                >Import</button>

                <!-- Clear Events Button -->
                <button
                    type="button"
                    class="btn btn-danger confirm-action ml-2"
                    data-toggle="modal"
                    data-target="#confirmModal"
                    data-href="{{ route('admin.clear.event') }}"
                    data-message="Are you sure you want to clear all events? This cannot be undone."
                >Clear Events</button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Id Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Gender</th>
                            <th>Department</th>
                            <th>Lucky Number</th>
                            <th>Has Checked</th>
                            <th>Category</th>
                            <th>Table Name</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr No</th>
                            <th>Id Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Gender</th>
                            <th>Department</th>
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
                                <td>{{ $eventUser->id_number }}</td>
                                <td>{{ $eventUser->name }}</td>
                                <td>{{ $eventUser->email }}</td>
                                <td>{{ $eventUser->phone_number }}</td>
                                <td>{{ $eventUser->gender }}</td>
                                <td>{{ $eventUser->department }}</td>
                                <td>{{ $eventUser->lucky_number }}</td>
                                <td>
                                    @if ($eventUser->qr_status)
                                        <span class="text-success">&#10004;</span>
                                    @else
                                        <span class="text-danger">&#10008;</span>
                                    @endif
                                </td>
                                <td>{{ $eventUser->type }}</td>
                                <td>{{ $eventUser->sittingTable->first()->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Confirmation Modal (BS4) --}}
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog"
     aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Please Confirm</h5>
        <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- message injected here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
                data-dismiss="modal">Cancel</button>
        <a href="#" id="confirmBtn" class="btn btn-primary">
          Yes, Proceed
        </a>
      </div>
    </div>
  </div>
</div>

{{-- Import Modal (BS4) --}}
<div class="modal fade" id="importModal" tabindex="-1" role="dialog"
     aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="importForm" action="{{ route('admin.register.users.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="importModalLabel">Import Users</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="users_file">Select Excel/CSV File</label>
            <input type="file" class="form-control-file" id="users_file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
          </div>
          <div id="importStatus" class="mt-3" style="display: none;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" id="importSubmit" class="btn btn-info">
            <span id="importText">Import</span>
            <span id="importLoading" class="spinner-border spinner-border-sm text-light ml-2" style="display: none;"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
// Ensure CSRF token is sent with every AJAX request
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).ready(function() {
  $(document).on('show.bs.modal', '#confirmModal', function(event) {
    var button  = $(event.relatedTarget);
    var message = button.data('message');
    var href    = button.data('href');

    $(this).find('.modal-body').text(message);
    $(this).find('#confirmBtn').attr('href', href);
  });

  // AJAX import form
$('#importForm').on('submit', function(e) {
    e.preventDefault();
    
    var form = $(this);
    var submitBtn = $('#importSubmit');
    var loading = $('#importLoading');
    var statusDiv = $('#importStatus');
    
    // Show loading state
    submitBtn.prop('disabled', true);
    loading.show();
    statusDiv.hide().empty();
    
    var formData = new FormData(this);
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                statusDiv.html('<div class="alert alert-success">' + response.message + '</div>').show();
                
                // Option 1: Reload after delay
                setTimeout(function() {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        location.reload();
                    }
                }, 2000);
                
                // Option 2: Just show success message and let user close manually
                // form.trigger('reset');
            } else {
                var errorHtml = '<div class="alert alert-danger">' + response.message;
                if (response.errors) {
                    errorHtml += '<ul>';
                    $.each(response.errors, function(index, error) {
                        errorHtml += '<li>' + error + '</li>';
                    });
                    errorHtml += '</ul>';
                }
                errorHtml += '</div>';
                statusDiv.html(errorHtml).show();
            }
        },
        error: function(xhr) {
            var errorMessage = 'Import failed. Please check your file and try again.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
                if (xhr.responseJSON.errors) {
                    errorMessage += '<ul>';
                    $.each(xhr.responseJSON.errors, function(index, error) {
                        errorMessage += '<li>' + error + '</li>';
                    });
                    errorMessage += '</ul>';
                }
            }
            statusDiv.html('<div class="alert alert-danger">' + errorMessage + '</div>').show();
        },
        complete: function() {
            submitBtn.prop('disabled', false);
            loading.hide();
        }
    });
});
  
  $('#importModal').on('hidden.bs.modal', function () {
    $('#importForm').trigger('reset');
    $('#importStatus').hide().empty();
    $('#importSubmit').prop('disabled', false);
    $('#importLoading').hide();
  });
});
</script>
@endsection