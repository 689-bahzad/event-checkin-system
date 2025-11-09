@extends('backend.layout.app')
@section('title','Profile')
@section('content')
<div class="app-content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Account Settings</h2>

                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- account setting page start -->
            <section id="page-account-settings">
                <div class="row">
                    <!-- left menu section -->
                    <div class="col-md-3 mb-2 mb-md-0">
                        <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                            <li class="nav-item">
                                <a class="nav-link d-flex py-75 active" id="account-pill-general" data-toggle="pill"
                                    href="#account-vertical-general" aria-expanded="true">
                                    <i class="feather icon-globe mr-50 font-medium-3"></i>
                                    Change Detail
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex py-75" id="account-pill-password" data-toggle="pill"
                                    href="#account-vertical-password" aria-expanded="false">
                                    <i class="feather icon-lock mr-50 font-medium-3"></i>
                                    Change Password
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex py-75" id="account-pill-code" data-toggle="pill"
                                    href="#account-vertical-code" aria-expanded="false">
                                    <i class="feather icon-lock mr-50 font-medium-3"></i>
                                    Redeem Gift Code
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link d-flex py-75" id="account-check-in-out-pill-code" data-toggle="pill"
                                    href="#account-check-in-out" aria-expanded="false">
                                    <i class="feather icon-lock mr-50 font-medium-3"></i>
                                    Check In Check Out
                                </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link d-flex py-75" id="account-email-notification-pill-code" data-toggle="pill"
                                    href="#account-email-notification" aria-expanded="false">
                                    <i class="feather icon-lock mr-50 font-medium-3"></i>
                                    Email Notifications
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- right content section -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                                            aria-labelledby="account-pill-general" aria-expanded="true">
                                            <div class="media">
                                                @php
                                                    $user = auth()->user();
                                                @endphp
                                                {{-- <a href="javascript: void(0);">
                                                    @if(auth()->user()->image)
                                                    <img src="{{ asset('profiles-images')}}/{{$user->image}}" class="rounded mr-75" alt="profile image" height="64" width="64">
                                                    @else
                                                    <img src="{{ asset('assets/app-assets/images/portrait/small/avatar-s-12.jpg')}}" class="rounded mr-75" alt="profile image" height="64" width="64">
                                                    @endif
                                                </a> --}}
                                                <form  action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                                
                                                    @csrf
                                                    @method('PUT')
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="account-name">Name</label>
                                                            <input type="text" class="form-control" id="account-name"
                                                                name="name" placeholder="Name"
                                                                data-validation-required-message="This name field is required"
                                                                value="{{ Auth::user()->name }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="account-e-mail">Email</label>
                                                            <input type="email" class="form-control"
                                                                id="account-e-mail" placeholder="Email" name="email"
                                                                data-validation-required-message="This email field is required"
                                                                value="{{ auth()->user()->email }}" required>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit"
                                                        class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save Changes</button>
                                                    {{-- <button type="reset" class="btn btn-outline-warning">Cancel</button> --}}
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade " id="account-vertical-password" role="tabpanel"
                                            aria-labelledby="account-pill-password" aria-expanded="false">
                                            <form  action="{{ route('profile.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label for="account-old-password">Old Password</label>
                                                                <input type="password" class="form-control"
                                                                    id="account-old-password" 
                                                                    placeholder="Old Password" name="old_password"
                                                                    data-validation-required-message="This old password field is required" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label for="account-new-password">New Password</label>
                                                                <input type="password"  
                                                                    id="account-new-password" class="form-control"
                                                                    placeholder="New Password" name="new_password" 
                                                                    data-validation-required-message="The password field is required"
                                                                    minlength="6" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label for="account-retype-new-password">Confirm Password
                                                                   </label>
                                                                <input type="password" name="new_password_confirmation"
                                                                    class="form-control" 
                                                                    id="account-retype-new-password"
                                                                    data-validation-match-match="password"
                                                                    placeholder="Confirm Password"
                                                                    data-validation-required-message="The Confirm password field is required"
                                                                    minlength="6" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                        <button type="submit"
                                                            class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save Changes</button>
                                                        {{-- <button type="reset" class="btn btn-outline-warning">Cancel</button> --}}
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade " id="account-vertical-code" role="tabpanel"
                                            aria-labelledby="account-pill-code" aria-expanded="false">
                                            <form  action="{{ route('profile.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label for="account-old-password">Redeem Code</label>
                                                                <input type="text" class="form-control"
                                                                    id="account-old-password" 
                                                                    placeholder="Redeem Code" name="redeem_code"
                                                                    value="{{ Auth::user()->redeem_code }}"
                                                                    data-validation-required-message="This old password field is required" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                        <button type="submit"
                                                            class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save Changes</button>
                                                        {{-- <button type="reset" class="btn btn-outline-warning">Cancel</button> --}}
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade " id="account-check-in-out" role="tabpanel"
                                            aria-labelledby="account-check-in-out-pill-code" aria-expanded="false">
                                            <form  action="{{ route('profile.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_check_in_check_out" value="0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="is_check_in_check_out"  value="1" id="flexCheckDefault" {{ Auth::user()->is_check_in_check_out == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label"  for="flexCheckDefault">
                                                                Check In Check Out Active
                                                            </label>
                                                          </div>
                                                    </div>
                                                    <div
                                                        class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                        <button type="submit"
                                                            class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save Changes</button>
                                                        {{-- <button type="reset" class="btn btn-outline-warning">Cancel</button> --}}
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade " id="account-email-notification" role="tabpanel"
                                            aria-labelledby="account-email-notification-pill-code" aria-expanded="false">
                                            <form  action="{{ route('profile.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_send_email_notification" value="0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="is_send_email_notification"  value="1" id="flexCheckDefault" {{ Auth::user()->is_send_email_notification == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label"  for="flexCheckDefault">
                                                                Send Email Notifications
                                                            </label>
                                                          </div>
                                                    </div>
                                                    <div
                                                        class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                        <button type="submit"
                                                            class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save Changes</button>
                                                        {{-- <button type="reset" class="btn btn-outline-warning">Cancel</button> --}}
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- account setting page end -->

        </div>
    </div>
</div>
@endsection
