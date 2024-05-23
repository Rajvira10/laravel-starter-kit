@extends('layout')
@section('title', 'Edit User')
@section('content')


    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Users</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                                class="ri-home-5-fill"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                                    <li class="breadcrumb-item active">Edit User</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- @include('include.message') --}}
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header">
                                <h3>{{ __('Edit User') }}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('users.update', $user->id) }}" method="post" class="form-group"
                                    onsubmit="return disableOnSubmit()" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="username">
                                                    Username
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input id="username" type="text"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    name="username" value="{{ $user->username }}" placeholder="">
                                                <div class="help-block with-errors"></div>
                                                @error('username')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="email">
                                                    Email
                                                </label>
                                                <input id="email" type="text"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ $user->email }}" placeholder="">
                                                <div class="help-block with-errors"></div>
                                                @error('email')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="role_id">
                                                    Role
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="role_id" id="role_id"
                                                    class="select-category form-control @error('role_id') is-invalid @enderror">
                                                    <option value="" selected disabled>Select Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                            {{ $role->display_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                                @error('role_id')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="image">
                                                    {{ __('Image') }}
                                                </label>
                                                <input id="image" type="file"
                                                    class="form-control @error('image') is-invalid @enderror" name="image"
                                                    value="{{ old('image') }}" placeholder="">
                                                <span class="info-text">* Max File Size:
                                                    100KB | File Type:
                                                    jpg, jpeg, png, svg</span>
                                                <div class="help-block with-errors"></div>
                                                @error('image')
                                                    <span class="text-red-error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="status">
                                                    Status
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="status" id="status"
                                                    class="select-category form-control @error('status') is-invalid @enderror">
                                                    <option value="active"
                                                        {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive"
                                                        {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive
                                                    </option>
                                                </select>
                                                <div class="help-block with-errors"></div>
                                                @error('status')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="password">
                                                    Password
                                                </label>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" placeholder="">
                                                <div class="help-block with-errors"></div>
                                                @error('password')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="password_confirmation">
                                                    Confirm Password
                                                </label>
                                                <input id="password_confirmation" type="password" class="form-control"
                                                    name="password_confirmation" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit"
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
