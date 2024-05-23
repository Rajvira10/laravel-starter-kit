@extends('layout')
@section('title', 'Add Role')
@section('content')


    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Roles</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                                class="ri-home-5-fill"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                                    <li class="breadcrumb-item active">Add Role</li>
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
                                <h3>{{ __('Add Role') }}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('roles.store') }}" method="post" class="form-group"
                                    onsubmit="return disableOnSubmit()">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="name">
                                                    Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" placeholder="">
                                                <div class="help-block with-errors"></div>
                                                @error('name')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="display_name">
                                                    Display Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input id="display_name" type="text"
                                                    class="form-control @error('display_name') is-invalid @enderror"
                                                    name="display_name" value="{{ old('display_name') }}" placeholder="">
                                                <div class="help-block with-errors"></div>
                                                @error('display_name')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="status">
                                                    Status
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="status" id="status"
                                                    class="select-category form-control @error('status') is-invalid @enderror">
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                                <div class="help-block with-errors"></div>
                                                @error('status')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="description">
                                                    Description
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                                                    name="description" placeholder="">{{ old('description') }}</textarea>
                                                <div class="help-block with-errors"></div>
                                                @error('status')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="card">
                                        <div class="card-body">
                                            <table class="table">
                                                <tr>
                                                    <td>{{ __('S/N') }}</td>
                                                    <td>Menu</td>
                                                    <td>View</td>
                                                    <td>Create</td>
                                                    <td>Edit</td>
                                                    <td>Delete</td>
                                                    <td>Download</td>
                                                    <td>All</td>
                                                </tr>
                                                @foreach ($menus as $menu)
                                                    <tr class="permissions-row">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $menu->name }}</td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $menu->id }}][view]"></td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $menu->id }}][create]"></td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $menu->id }}][edit]"></td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $menu->id }}][delete]"></td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $menu->id }}][download]"></td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $menu->id }}][all]"></td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button id="submit" type="submit"
                                                class="btn btn-primary waves-effect waves-light">Submit</button>
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
            // const permissionsRows = document.querySelectorAll('.permissions-row');

            // permissionsRows.forEach((row, index) => {
            //     const checkboxes = row.querySelectorAll('input[type="checkbox"]');
            //     checkboxes.forEach((checkbox, index) => {
            //         checkbox.checked = false;
            //     });

            //     checkboxes[checkboxes.length - 1].addEventListener('change', function() {
            //         checkboxes.forEach((checkbox, index) => {
            //             checkbox.checked = this.checked;
            //         });
            //     });
            // });
        });
    </script>
@endsection
