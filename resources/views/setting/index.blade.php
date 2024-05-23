@extends('layout')
@section('title', 'Settings')
@section('content')


    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header">
                                <h3>{{ __('Manage Settings') }}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('settings.update') }}" method="post" class="form-group"
                                    onsubmit="return disableOnSubmit()" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label for="logo">
                                                    {{ __('Logo') }}
                                                </label>
                                                <input id="logo" type="file"
                                                    class="form-control @error('logo') is-invalid @enderror" name="logo"
                                                    value="{{ old('logo') }}" placeholder="">
                                                <span class="info-text">* Max File Size:
                                                    100KB | File Type:
                                                    jpg, jpeg, png, svg</span>
                                                <div class="help-block with-errors"></div>
                                                @error('logo')
                                                    <span class="text-red-error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            @if ($settings && $settings->logo)
                                                <img src="{{ asset($settings->logo) }}" alt="logo" class="img-fluid">
                                            @endif
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="favicon">
                                                    {{ __('Favicon') }}
                                                </label>
                                                <input id="favicon" type="file"
                                                    class="form-control @error('favicon') is-invalid @enderror"
                                                    name="favicon" value="{{ old('favicon') }}" placeholder="">
                                                <span class="info-text">* Max File Size:
                                                    100KB | File Type:
                                                    jpg, jpeg, png, svg</span>
                                                <div class="help-block with-errors"></div>
                                                @error('favicon')
                                                    <span class="text-red-error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            @if ($settings && $settings->favicon)
                                                <img src="{{ asset($settings->favicon) }}" alt="logo" class="img-fluid">
                                            @endif
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="brand_color">
                                                    {{ __('Brand Color') }}
                                                </label>
                                                <input id="brand_color" type="color"
                                                    class="form-control @error('brand_color') is-invalid @enderror"
                                                    name="brand_color"
                                                    value="{{ $settings ? $settings->brand_color : '' }}" placeholder="">
                                                <div class="help-block with-errors"></div>
                                                @error('brand_color')
                                                    <span class="text-red-error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button id="submit" type="submit"
                                                class="btn btn-primary waves-effect waves-light">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('custom-script')
    <script>
        const disableOnSubmit = () => {
            const button = document.querySelector('#submit');
            button.disabled = true;
            button.innerHTML =
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`;
            return true;
        }
        document.addEventListener("DOMContentLoaded", function() {
            const selectCategory = document.querySelectorAll(".select-category");
            for (let i = 0; i < selectCategory.length; i++) {
                new Selectr(selectCategory[i]);
            }
        });
    </script>
@endsection
