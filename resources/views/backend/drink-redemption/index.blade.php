@extends('backend.layout.app')
@section('title', 'Drink Redemption')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Drink Redemption Management</h1>

    <!-- DataTable Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Users - Drink Redemption</h6>
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
                            <th>Can Redeem Drinks</th>
                            <th>Drinks Redeemed</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr No</th>
                            <th>Id Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Can Redeem Drinks</th>
                            <th>Drinks Redeemed</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($registrations as $registration)
                            <tr>
                                <td>{{ $registration->count }}</td>
                                <td>{{ $registration->id_number }}</td>
                                <td>{{ $registration->name }}</td>
                                <td>{{ $registration->email }}</td>
                                <td>{{ $registration->phone_number }}</td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input drink-permission-toggle" 
                                               id="switch-{{ $registration->id }}"
                                               data-registration-id="{{ $registration->id }}"
                                               {{ $registration->can_redeem_drinks ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="switch-{{ $registration->id }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $registration->drinks_redeemed ?? 0 }}/2</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
.custom-switch {
    padding-left: 2.25rem;
}
.custom-control-input:checked ~ .custom-control-label::before {
    background-color: #28a745;
    border-color: #28a745;
}
.custom-control-input:focus ~ .custom-control-label::before {
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}
.custom-control-label {
    cursor: pointer;
}
.custom-control-label::before {
    background-color: #dc3545;
    border-color: #dc3545;
}
</style>
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
  // Handle drink redemption permission toggle
  $('.drink-permission-toggle').on('change', function() {
    var registrationId = $(this).data('registration-id');
    var isChecked = $(this).is(':checked');
    var switchToggle = $(this);
    
    // Disable switch during request
    switchToggle.prop('disabled', true);
    
    $.ajax({
      url: '{{ route("admin.drink.redemption.toggle") }}',
      type: 'POST',
      data: {
        registration_id: registrationId,
        can_redeem: isChecked ? 1 : 0
      },
      success: function(response) {
        if (response.success) {
          toastr.success(response.message);
        } else {
          switchToggle.prop('checked', !isChecked);
          toastr.error(response.message || 'Failed to update permission');
        }
      },
      error: function() {
        switchToggle.prop('checked', !isChecked);
        toastr.error('An error occurred while updating permission');
      },
      complete: function() {
        // Re-enable switch after request
        switchToggle.prop('disabled', false);
      }
    });
  });
});
</script>
@endsection

