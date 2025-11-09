@extends('frontend.layouts.app')
@section('title', 'Lucky Draw')
@section('css')
    <link href="{{ asset('assets/backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        form {
            display: flex;
            margin-bottom: 30px;
            justify-content: center;
        }

        input {
            margin: 0 0.5rem;
            padding: 0.5rem;
            border: 1px solid #333;
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 3rem;
        }

        .special {
            opacity: 1;
            visibility: visible;
            transition: all 0.3s ease;

            i {
                font-size: 1rem;
                cursor: pointer;
            }

            &.hidden {
                opacity: 0;
                visibility: hidden;
            }
        }

        .redeem_code {
            font-size: 10px;
            font-family: sans-serif;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        .section_draw .container {
            height: auto;
        }

        .wrapper_box {
            margin-top: 220px
        }

        .box_border_redeem {
            border-width: 7px;
            border-style: solid;
            position: relative;
            bottom: 22px;
            right: 35px;
            background-color: aliceblue;
            border-image-slice: 1;
            border-radius: 12px;
            padding: 10px 15px;
            width: 90%;
            margin: auto;
            text-align: center;
            border-color: #C2832D;
        }
        .box_border_redeemed {
            border-width: 7px;
            border-style: solid;
            position: relative;
            bottom: 22px;
            right: 82px;
            background-color: aliceblue;
            border-image-slice: 1;
            border-radius: 12px;
            padding: 10px 15px;
            width: 90%;
            margin: auto;
            text-align: center;
            border-color: #C2832D;
        }

        @media only screen and (max-width: 750px) {
            .box_border_redeem {
                right: 0px;
            }
            .box_border_redeemed {
                right: 0px;
            }

        }
    </style>
    @if ($registration->status == true)
        <style>
            .draw_heading {
                margin-bottom: 20px !important;
            }
        </style>
    @endif
@endsection
@section('content')
    <Section class="section_draw">
        <div class="container" id="container">
            <a href="{{ route('direct.check.in') }}" class="back-arrow" aria-label="Go to Check-In Page">
                <i class="fas fa-arrow-left"></i>
            </a>
            {{-- <img class="img_wrapper" src="{{ asset('assets/frontend/images/bg-dark.jpg') }}" alt="lucky draw box"> --}}
            <div class="wrapper_box">
                <div class="main_box">
                    <div class="main_box_inner">
                       @if ($registration->status == false)
                        <div class="box_ticket box_border_redeem">
                            <h3 class="draw_heading">THIS IS YOUR DOOR GIFT TICKET</h3>
                            <h5 class="redeem_code">Enter the code to redeem your door gift</h5>
                            <form>
                                <input type="text" maxlength="1" />
                                <input type="text" maxlength="1" />
                                {{-- <input type="text" maxlength="1" />
                                <input type="text" maxlength="1" /> --}}
                            </form>
                            <a id="redeem-link" class="disabled" style="background-color: #3609cc" target="_blank">Redeem Door Gift</a>
                            <p>Please note that only committee members/persons in charge are allowed to press this button.</p>
                        </div>
                    @endif

                    @if ($registration->status == true)
                        <div class="box_ticket box_border_redeemed">
                            <h3 class="draw_heading">THIS IS YOUR DOOR GIFT TICKET</h3>
                            <a href="{{ route('lucky.draw', ['registration' => $registration->id]) }}"
                            style="background-color: #af1d22" target="_blank">Gift has been redeemed</a>
                            <p>Please note that only committee members/persons in charge are allowed to press this button.</p>
                        </div>
                    @endif

                    </div>
                </div>
            </div>
        </div>
    </Section>
@endsection
@section('js')
    <script>
        var src = "{{ $luckyDraw_page->getFirstMediaUrl('images') }}";
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
    <script>
        const inputs = document.querySelectorAll("input");
        const redeemLink = document.getElementById("redeem-link");

        function checkCode() {
            const code = [...inputs].map(input => input.value).join("");
            if (code.length === 2) {
                // Make AJAX call to validate the code
                fetch('validate-code', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            code
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.valid) {
                            redeemLink.classList.remove('disabled');
                            redeemLink.setAttribute('href',
                                "{{ route('lucky.draw', ['registration' => $registration->id]) }}");
                        } else {
                            toastr.error('Invalid code');
                            redeemLink.classList.add('disabled');
                            redeemLink.removeAttribute('href');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred while validating the code');
                    });
            } else {
                redeemLink.classList.add('disabled');
                redeemLink.removeAttribute('href');
            }
        }

        inputs.forEach((input, key) => {
            input.addEventListener("keyup", function() {
                if (input.value && key < inputs.length - 1) {
                    inputs[key + 1].focus();
                }
                checkCode();
            });

            input.addEventListener("keydown", function(e) {
                if (e.key === "Backspace" && !input.value && key > 0) {
                    inputs[key - 1].focus();
                }
            });
        });
    </script>

@endsection
