@extends('frontend.layouts.app')
@section('title', 'Registration')

<style>
    .wrapper {
        position: relative;
        width: 100%;
        text-align: center;
    }

    .my-form {
        position: absolute;
        top: 40%;
        left: 56%;
        transform: translate(-50%, -50%);
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        width: 100%;
        max-width: 100%;
    }
    input.form-control {
        text-align: center;
    }
    @media (max-width: 760px) {
        .my-form {
           left: 50%; /* Adjusts the form width for smaller devices */
        }
    }
</style>

@section('content')

    <div class="section_book_event px-3">
        <div class="wrapper position-relative">
            <img class="img-fluid" src="{{ $checkIn_page->getFirstMediaUrl('images') }}" alt="" srcset="">
            <div class="my-form">
              <form class="verify-form" action="{{ route('verify.user') }}" method="POST">
                @csrf
                <div class="row mb-1">
                    <div class="form-group col-md-9 col-sm-9">
                        <input class="form-control" type="text" name="phone_number" value="" placeholder="Enter Staff ID"/ required>
                        <button type="submit" class="btn btn-primary mt-3">Verify</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection