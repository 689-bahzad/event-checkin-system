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
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        padding: 20px;
        border-radius: 10px;
    }

    #video {
        width: 520px !important;
        /* Adjust as needed */
        height: auto !important;
        border: 1px solid gray;
    }

    /* Overlay styles */
    .overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        /* Adjust width as needed */
        height: 300px;
        /* Adjust height as needed */
        border: 2px solid #ffffff;
        /* Green border for visibility */
        border-radius: 10px;
        pointer-events: none;
        /* Allows clicks to pass through */
        box-sizing: border-box;
    }

    /* Optional: Dim the area outside the overlay for better focus */
    .dimmed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        clip-path: polygon(0% 0%,
                100% 0%,
                100% 100%,
                0% 100%,
                0% 0%,
                /* Define the hole for the overlay */
                0% 0%,
                0% 0%,
                0% 0%,
                0% 0%);
        /* Adjust clip-path to create a transparent rectangle */
        clip-path: inset(40% 30% 40% 30%);
    }

    h3 {
        margin-bottom: 20px;
    }
    @media(max-width:512px) {
       .my-form{
                top:48%;
                
                #video {
                width:400px !important;
                border:none;
                
              }
              
            }
             
            .overlay{
                /*border:none;*/
            }   
     }
</style>

@section('content')

    <div class="section_book_event px-3">
        <div class="wrapper position-relative">
            <img class="img-fluid" src="{{ $checkIn_page->getFirstMediaUrl('images') }}" alt="" srcset="">
            <div class="my-form">
               <video
                id="video"
                autoplay
                muted
                playsinline
                style="width:520px; border:1px solid gray;"
              ></video>
                <canvas id="canvas" width="520" height="520" style="display: none;"></canvas>
                <div class="overlay"></div>
                <!-- Optional: Dimmed background -->
                <div class="dimmed"></div>
                <!-- Optional: Brightness Slider -->

            </div>
        </div>
    </div>

    <form class="verify-form" action="{{ route('verify.user') }}" method="POST">
        @csrf
        <input class="form-control" type="hidden" name="phone_number" value="" placeholder="Enter Guest ID"/>
    </form>
@endsection


<script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
  // 1) Create the ZXing reader
  const codeReader = new ZXing.BrowserQRCodeReader();
  const form      = document.querySelector('.verify-form');
  const input     = form.querySelector('input[name="phone_number"]');

  try {
    // 2) List all video inputs (cameras)
    const videoInputDevices = await codeReader.getVideoInputDevices();
    // 3) Pick the back/rear camera if available, otherwise the first one
    const backCamera = videoInputDevices.find(device =>
      /back|rear|environment/i.test(device.label)
    ) || videoInputDevices[0];

    // 4) Start streaming & decoding from that device at 640×480
    codeReader.decodeFromVideoDevice(
      backCamera.deviceId,
      'video',
      (result, err) => {
        console.log(result, input.value);
        if (result) {
          // Got a QR code!
          input.value = result.getText();
          codeReader.reset();
          form.submit();
        }
        // Only log “real” errors (ignore NotFound exceptions)
        else if (err && !(err instanceof ZXing.NotFoundException)) {
          console.error(err);
        }
      },
      {
        video: {
          width:  { ideal: 640 },
          height: { ideal: 480 },
          facingMode: 'environment'
        }
      }
    );
  } catch (e) {
    console.error('Error initializing QR scanner:', e);
  }
});
</script>
