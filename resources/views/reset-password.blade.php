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

                                    <form action="{{ route('reset_password_update') }}" method="post" class="g-3 needs-validation"
                                        novalidate>

                                        @csrf

                                        <div class="mb-3">
                                            <input type="hidden" name="email" value={{$email}}>
                                            <input type="hidden" name="token" value={{$token}}>
                                            <label class="form-label" for="password-input">New Password</label>

                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input"
                                                    placeholder="Enter password" id="password-input" name="password"
                                                    required>
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                                <div class="invalid-feedback">
                                                    Please enter password
                                                </div>
                                            </div>


                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label" for="password-input">Confirm Password</label>

                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input"
                                                    placeholder="Enter password" id="password-input" name="confirm_password"
                                                    required>
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                                <div class="invalid-feedback">
                                                    Please enter password
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mt-4">
                                            <button class="btn btn-info w-100" type="submit">Change Password</button>
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
