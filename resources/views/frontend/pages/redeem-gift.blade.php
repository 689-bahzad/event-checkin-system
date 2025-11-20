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
            margin-top: 220px;
            margin-bottom: 0;
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
            z-index: 10;
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
            z-index: 10;
        }

        @media only screen and (max-width: 750px) {
            .box_border_redeem {
                right: 0px;
            }
            .box_border_redeemed {
                right: 0px;
            }

        }

        .glass-container-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 30px;
            padding: 20px 0;
            width: 100%;
            clear: both;
        }

        .glass-container {
            position: relative;
            text-align: center;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
            width: auto;
            height: auto;
        }

        .glass-container.redeem-drink {
            position: relative;
        }
        
        .section_draw {
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .section_draw .container {
            position: relative;
        }

        .drink-status {
            text-align: center;
            color: #fff;
            margin-top: 10px;
            font-size: 14px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
            min-height: 20px;
        }

        .glass-container img {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .glass-container.clicked::after {
            content: '✕';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 40px;
            color: #ff0000;
            font-weight: bold;
            z-index: 1001;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            pointer-events: none;
        }

        .glass-container.clicked img {
            filter: grayscale(100%);
            opacity: 0.5;
        }

        @media only screen and (max-width: 750px) {
            .glass-container-wrapper {
                gap: 20px;
                padding: 15px 0;
                margin-top: 15px;
            }
            .glass-container img {
                max-width: 80px;
            }
            .drink-redemption-info {
                font-size: 12px;
                margin-top: 8px;
            }
            .wrapper_box {
                margin-top: 180px;
            }
        }
        
        @media only screen and (max-width: 480px) {
            .glass-container-wrapper {
                gap: 15px;
                /* flex-direction: column; */
                padding: 10px 0;
                margin-top: 10px;
            }
            .glass-container img {
                max-width: 60px;
            }
            .drink-redemption-info {
                font-size: 11px;
                margin-top: 5px;
            }
            .wrapper_box {
                margin-top: 150px;
            }
            .box_border_redeem,
            .box_border_redeemed {
                width: 95%;
                padding: 8px 12px;
            }
        }
        
        @media only screen and (min-width: 1200px) {
            .glass-container-wrapper {
                gap: 40px;
                padding: 30px 0;
            }
            .glass-container img {
                max-width: 120px;
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
            @php
                $canRedeem = isset($registration->can_redeem_drinks) ? (bool)$registration->can_redeem_drinks : false;
                $drinksRedeemed = isset($registration->drinks_redeemed) ? (int)$registration->drinks_redeemed : 0;
            @endphp
            @if($canRedeem)
            <div class="glass-container-wrapper">
                <div class="glass-container redeem-drink" id="glass-container-1" data-glass-number="1">
                    <img src="{{ asset('assets/frontend/images/glass.png') }}" alt="Drink Glass" id="glass-image-1" 
                         data-registration-id="{{ $registration->id }}"
                         data-drinks-redeemed="{{ $drinksRedeemed }}">
                </div>
                <div class="glass-container redeem-drink" id="glass-container-2" data-glass-number="2">
                    <img src="{{ asset('assets/frontend/images/glass.png') }}" alt="Redeem Drink" id="glass-image-2" 
                         data-registration-id="{{ $registration->id }}"
                         data-drinks-redeemed="{{ $drinksRedeemed }}">
                </div>
            </div>
            @endif
        </div>
    </Section>

    <!-- Drink Redemption Confirmation Modal -->
    @if($canRedeem)
    <div class="modal fade" id="drinkRedemptionModal" tabindex="-1" aria-labelledby="drinkRedemptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="drinkRedemptionModalLabel">Confirm Drink Redemption</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Do you want to redeem this drink?</p>
                    <p class="text-muted">You have redeemed <span id="modal-drinks-count">{{ $drinksRedeemed }}</span> out of 2 drinks.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmDrinkRedemption">Yes, Redeem</button>
                </div>
            </div>
        </div>
    </div>
    @endif
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Drink redemption functionality for both glasses
            const glass1 = document.getElementById('glass-image-1');
            const glass2 = document.getElementById('glass-image-2');
            const glassContainer1 = document.getElementById('glass-container-1');
            const glassContainer2 = document.getElementById('glass-container-2');
            const confirmDrinkRedemptionBtn = document.getElementById('confirmDrinkRedemption');
            
            let registrationId = null;
            let drinksRedeemed = 0;
            let currentGlassNumber = null;
            
            // Initialize from either glass
            if (glass1) {
                registrationId = glass1.getAttribute('data-registration-id');
                drinksRedeemed = parseInt(glass1.getAttribute('data-drinks-redeemed')) || 0;
            } else if (glass2) {
                registrationId = glass2.getAttribute('data-registration-id');
                drinksRedeemed = parseInt(glass2.getAttribute('data-drinks-redeemed')) || 0;
            }

            // Update initial status display - grey out glasses based on redemption count
            function updateStatusDisplay() {
                if (drinksRedeemed >= 1) {
                    // First glass greyed out
                    if (glassContainer1) {
                        glassContainer1.classList.add('clicked');
                        glassContainer1.style.cursor = 'not-allowed';
                    }
                }
                if (drinksRedeemed >= 2) {
                    // Both glasses greyed out
                    if (glassContainer1) {
                        glassContainer1.classList.add('clicked');
                        glassContainer1.style.cursor = 'not-allowed';
                    }
                    if (glassContainer2) {
                        glassContainer2.classList.add('clicked');
                        glassContainer2.style.cursor = 'not-allowed';
                    }
                }
            }

            // Initialize status on page load
            updateStatusDisplay();

            // Function to handle glass click
            function handleGlassClick(glassNumber) {
                if (drinksRedeemed >= 2) {
                    toastr.warning('You have already redeemed the maximum number of drinks (2).');
                    return;
                }

                currentGlassNumber = glassNumber;
                
                // Update modal text
                document.getElementById('modal-drinks-count').textContent = drinksRedeemed;
                
                // Show confirmation modal (Bootstrap 5)
                const modal = new bootstrap.Modal(document.getElementById('drinkRedemptionModal'));
                modal.show();
            }

            // Add click listeners to both glasses
            if (glass1) {
                glass1.addEventListener('click', function() {
                    handleGlassClick(1);
                });
            }

            if (glass2) {
                glass2.addEventListener('click', function() {
                    handleGlassClick(2);
                });
            }

            // Handle confirmation button
            if (confirmDrinkRedemptionBtn) {
                confirmDrinkRedemptionBtn.addEventListener('click', function() {
                    if (drinksRedeemed >= 2) {
                        toastr.warning('You have already redeemed the maximum number of drinks (2).');
                        const modal = bootstrap.Modal.getInstance(document.getElementById('drinkRedemptionModal'));
                        if (modal) modal.hide();
                        return;
                    }

                    // Disable button during request
                    confirmDrinkRedemptionBtn.disabled = true;
                    confirmDrinkRedemptionBtn.textContent = 'Processing...';

                    // Make AJAX call to redeem drink
                    fetch(`/redeem-drink/${registrationId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            drinksRedeemed = data.drinks_redeemed;
                            
                            // Update data attributes
                            if (glass1) glass1.setAttribute('data-drinks-redeemed', drinksRedeemed);
                            if (glass2) glass2.setAttribute('data-drinks-redeemed', drinksRedeemed);
                            
                            // Update visual status - grey out glasses
                            if (drinksRedeemed === 1) {
                                // First glass greyed out with X
                                if (glassContainer1) {
                                    glassContainer1.classList.add('clicked');
                                    glassContainer1.style.cursor = 'not-allowed';
                                }
                            } else if (drinksRedeemed === 2) {
                                // Both glasses greyed out with X
                                if (glassContainer1) {
                                    glassContainer1.classList.add('clicked');
                                    glassContainer1.style.cursor = 'not-allowed';
                                }
                                if (glassContainer2) {
                                    glassContainer2.classList.add('clicked');
                                    glassContainer2.style.cursor = 'not-allowed';
                                }
                            }
                            
                            toastr.success(data.message);
                            const modal = bootstrap.Modal.getInstance(document.getElementById('drinkRedemptionModal'));
                            if (modal) modal.hide();
                        } else {
                            toastr.error(data.message || 'Failed to redeem drink');
                            const modal = bootstrap.Modal.getInstance(document.getElementById('drinkRedemptionModal'));
                            if (modal) modal.hide();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred while redeeming the drink');
                    })
                    .finally(() => {
                        confirmDrinkRedemptionBtn.disabled = false;
                        confirmDrinkRedemptionBtn.textContent = 'Yes, Redeem';
                    });
                });
            }
        });
    </script>

@endsection
