@extends('frontend.layouts.app')
@section('title', 'Registration')
@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card text-white" style="border-radius: 1rem; background-color:af1d22">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Admin Login</h2>
                                <x-auth-session-status class="mb-4" :status="session('status')" />
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-outline form-white mb-4">
                                        <input type="email" id="typeEmailX" class="form-control form-control-lg"
                                            name="email" :value="old('email')" required />
                                        <label class="form-label" for="typeEmailX">Email</label>
                                        {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" name="password" class="form-control form-control-lg"
                                            autocomplete="current-password" />
                                        <label class="form-label" for="typePasswordX">Password</label>
                                        {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input id="remember_me" type="checkbox"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            name="remember">
                                        <label class="form-label" for="typePasswordX">Remember me</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <p class="small mb-5 pb-lg-2"><a class="text-white-50"
                                                href="{{ route('password.request') }}">Forgot password?</a></p>
                                    @endif
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<style>
    .gradient-custom {
        /* fallback for old browsers */
        background: #151515;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgb(42, 42, 43), rgb(47, 48, 49));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgb(45, 45, 45), rgb(28, 28, 29))
    }
</style>
