@extends('frontend.layouts.app')
@section('title', 'Feedback')
@section('content')
<div class="section_book_event px-3 ">
    <div class="wrapper position-relative">
        <img class="img-fluid" src="{{ $feedback_page->getFirstMediaUrl('images') }}" alt="" srcset="">
        <form class="position-absolute mt-5" action="{{ route('feedback.store') }}" method="POST">
            @csrf
            <div class="row mb-1">
                <div class="col-md-12 col-sm-12">
                    <!--<label class="form-label">Name</label>-->
                    <input type="text" name="name" class="form-control"  value="{{ old('name') }}"  placeholder="Name"
                        aria-label="full name" required>
                </div>
            
                <div class="col-md-12 col-sm-12">
                   <textarea name="message" id="feedback" class="form-control" placeholder="Message" cols="35" rows="3"></textarea>
                </div>                

            </div>
            <div class="text-center submit_event mt-2">
                <button type="submit" class="btn  fs-5 fw-semibold rounded-pill">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection