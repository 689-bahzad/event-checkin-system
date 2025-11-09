@extends('frontend.layouts.app')
@section('title', 'Registration')
@section('content')
<div class="section_book_event px-3 ">
    <div class="wrapper position-relative">
        <img class="img-fluid" src="{{ $home_page->getFirstMediaUrl('images') }}" alt="" srcset="">
        <form class="position-absolute" action="{{ route('registration.store') }}" method="POST">
            @csrf
            <div class="row mb-1">
                <div class="col-md-12 col-sm-12">
                    <!--<label class="form-label">Name</label>-->
                    <input type="text" name="name" class="form-control"  value="{{ old('name') }}"  placeholder="Name"
                        aria-label="full name">
                </div>
                <div class="col-md-12 col-sm-12">
                    <!--<label class="form-label">Email</label>-->
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" aria-label="Email"
                        >
                </div>

                <div class="col-md-12 col-sm-12">
                    <!--<label class="form-label">Contact</label>-->
                    <input type="number" name="phone_number" class="form-control" placeholder="Contact" aria-label="contact">
                </div>

                <div class="col-md-12 col-sm-12">
                    <select class="form-select type" name="type" aria-label="Default select example">
                        <option value="vendor" {{ old('type') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="customer" {{ old('type') == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="ex-staff" {{ old('type') == 'ex-staff' ? 'selected' : '' }}>Ex staff</option>
                    </select>
                </div>                

            </div>
            <div class="text-center submit_event mt-2">
                <button type="submit" class="btn  fs-5 fw-semibold rounded-pill">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection