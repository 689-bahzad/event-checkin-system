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
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        padding: 20px;
        border-radius: 10px;
    }

    h3 {
        margin-bottom: 20px;
    }

    @media (max-width: 512px) {
        .my-form svg{
            width: 264px; /* Adjusts the form width for smaller devices */
        }
    }
    @media (min-width: 900px) {
        .my-form svg{
            width: 364px; /* Adjusts the form width for smaller devices */
        }
    }
</style>
@section('content')
<div class="section_book_event px-3">
    <div class="wrapper position-relative">
        <!-- Background image -->
        <img class="img-fluid" src="{{ $qrCode_page->getFirstMediaUrl('images') }}" alt="Background Image">

        <!-- QR Code Centered -->
        <div class="my-form">
            {!! $qrCode !!}
        </div>
    </div>
</div>
@endsection
