@extends('frontend.layouts.app')
@section('title', 'Lucky Draw')
@section('css')
<link href="{{ asset('assets/backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<style>
    .back-arrow {
    /* Existing styles */
        transition: transform 0.3s, color 0.3s;
    }

    .back-arrow:hover {
        /* Existing hover styles */
        transform: translateX(-5px); /* Slide the arrow slightly on hover */
    }
    .section_draw .container {
        height: auto;
    }
    
    @media only screen and (max-width: 600px) {
        .box_border {
            right: 0px;
            bottom: 45px;
        }
    }
</style>
@endsection
@section('content')

<Section class="section_draw">
    <div class="container" id="container">
        {{-- Background image will be set by JavaScript --}}
         {{-- Back Arrow --}}
         <a href="{{ route('direct.check.in') }}" class="back-arrow" aria-label="Go to Check-In Page">
            <i class="fas fa-arrow-left"></i>
        </a>
         {{-- <img class="img_wrapper" src="{{ asset('assets/frontend/images/bg-dark.jpg') }}" alt="lucky draw box"> --}}
        <div class="wrapper_box">
            <div class="main_box">
                <div class="main_box_inner">
                    <h3 class="heading_seconday">
                         </h3>
                    <h4 class="heading_seconday"></h4>
                    <div class="box_num box_border">
                        <h3 class="draw_heading">
                            {{ $registration->name }}
                        </h3>
                    </div>
                    <div class="box_num box_border">
                        <h3 class="draw_heading">
                            YOUR LUCKY DRAW NUMBER
                        </h3>
                        <input class="text-center" type="number" value="{{ $registration->lucky_number }}" name="" id="" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</Section>

@section('js')
<script>
    var src = "{{ $luckyNumber_page->getFirstMediaUrl('images') }}";
    console.log(src);

    document.addEventListener("DOMContentLoaded", function() {
        // Wait for the DOM content to be fully loaded
        var sectionDraw = document.getElementById("container");
        if (sectionDraw) {
            // Check if the element exists
            sectionDraw.style.backgroundImage = "url('" + src + "')";
        } else {
            console.error("Element with ID 'sectionDraw' not found.");
        }
    });
</script>

@endsection
@endsection
