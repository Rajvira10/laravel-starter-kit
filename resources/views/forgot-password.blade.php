@extends('login-layout')


@section('title', 'Login')


@section('content')

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay" style="background: #2385BA !important"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12">

                    </div>
                </div>

                <div class="row justify-content-center align-items-center mt-5">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4" style="padding-bottom: 30px; margin-bottom: 80px;">

                            <div class="card-body p-4 pt-5">
                                <div class="text-center text-white-50 mt-1">
                                    {{-- <h1 class="text-center text-light pt-4 pb-3">Export Promotion Bureau</h1> --}}
                                    <img src="{{ asset('assets/images/favicon.svg') }}" alt="" height="60">
                                </div>
                                <div class="p-2 mt-5">

                                    <form action="{{ route('reset_password') }}" method="post" class="g-3 needs-validation"
                                        novalidate>

                                        @csrf

                                        <div class="mb-3">
                                            <label for="credential" class="form-label">Username/Email</label>
                                            <input type="text" class="form-control" id="credential" name="credential"
                                                placeholder="Enter username or email" required>
                                            <div class="invalid-feedback">
                                                Please enter username or email
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-info w-100" type="submit">Send Reset Link</button>
                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

    </div>
    <!-- end auth-page-wrapper -->

@endsection
@section('custom-script')
    @include('message')
@endsection
