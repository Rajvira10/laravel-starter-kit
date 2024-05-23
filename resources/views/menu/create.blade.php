@extends('layout')
@section('title', 'Add Menu')
@section('content')


    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Menus</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                                class="ri-home-5-fill"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('menus.index') }}">Menus</a></li>
                                    <li class="breadcrumb-item active">Add Menu</li>
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
                                <h3>{{ __('Add Menu') }}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('menus.store') }}" method="post" class="form-group"
                                    onsubmit="return disableOnSubmit()">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="name">
                                                    Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input id="menuname" type="text"
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
                                                <label for="url">
                                                    Url
                                                </label>
                                                <input id="url" type="text"
                                                    class="form-control @error('url') is-invalid @enderror" name="url"
                                                    value="{{ old('url') ?? '#' }}" placeholder="">
                                                <div class="help-block with-errors"></div>
                                                @error('url')
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
                                                <label for="parent_id">
                                                    Parent
                                                </label>
                                                <select name="parent_id" id="parent_id"
                                                    class="select-category form-control @error('parent_id') is-invalid @enderror">
                                                    <option value="" selected disabled>Select Parent</option>
                                                    @foreach ($menus as $menu)
                                                        @if ($menu->parent_id == null)
                                                            <option value="{{ $menu->id }}">{{ $menu->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                                @error('status')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="icon">
                                                    Icon
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <button type="button"
                                                            style="cursor:not-allowed; background: rgb(240,240,240);"
                                                            class="btn btn-outline-secondary">
                                                            <i class="mdi mdi-arrow-right-thin leftIcon"></i>
                                                        </button>
                                                    </div>
                                                    <input id="iconInput" type="text"
                                                        class="form-control @error('icon') is-invalid @enderror"
                                                        name="icon"
                                                        value="{{ old('icon') ?? 'mdi mdi-arrow-right-thin' }}"
                                                        placeholder="" readonly>
                                                    <div class="input-group-append">
                                                        <button type="button" class="iconBtn btn btn-outline-secondary"
                                                            data-bs-toggle="modal" data-bs-target="#iconModal">
                                                            <i class="fa fa-eye"></i> Select Icon
                                                        </button>

                                                    </div>
                                                </div>
                                                <div class="help-block with-errors"></div>
                                                @error('icon')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="hierarchy">
                                                    Hierarchy
                                                </label>
                                                <input id="hierarchy" type="number"
                                                    class="form-control @error('hierarchy') is-invalid @enderror"
                                                    name="hierarchy" value="{{ old('hierarchy') }}" placeholder="">
                                                <div class="help-block with-errors"></div>
                                                @error('hierarchy')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table">
                                                <tr>
                                                    <td>{{ __('S/N') }}</td>
                                                    <td>Role</td>
                                                    <td>View</td>
                                                    <td>Create</td>
                                                    <td>Edit</td>
                                                    <td>Delete</td>
                                                    <td>Download</td>
                                                    <td>All</td>
                                                </tr>
                                                @foreach ($roles as $role)
                                                    <tr class="permissions-row">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $role->name }}</td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $role->id }}][view]"></td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $role->id }}][create]"></td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $role->id }}][edit]"></td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $role->id }}][delete]"></td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $role->id }}][download]"></td>
                                                        <td><input type="checkbox"
                                                                name="permissions[{{ $role->id }}][all]"></td>
                                                    </tr>
                                                @endforeach
                                                @if ($roles->count() == 0)
                                                    <tr>
                                                        <td colspan="8" class="text-center">No roles found</td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
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
    <div class="modal fade" id="iconModal" tabindex="-1" aria-labelledby="iconModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="iconModalLabel">Click on an Icon</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="icons"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script src={{ asset('assets/js/pages/remix-icons-listing.js') }}></script>
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

            const permissionsRows = document.querySelectorAll('.permissions-row');

            permissionsRows.forEach((row, index) => {
                const checkboxes = row.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach((checkbox, index) => {
                    checkbox.checked = false;
                });

                checkboxes[checkboxes.length - 1].addEventListener('change', function() {
                    checkboxes.forEach((checkbox, index) => {
                        checkbox.checked = this.checked;
                    });
                });
            });
            const leftIcon = document.querySelector('.leftIcon');
            //remove hover styles of leftIcon
            $('.leftIcon').hover(function() {
                //backgroud color
                $(this).css('color', 'blue');
            });
            const iconBtn = document.querySelector('.iconBtn');
            iconBtn.addEventListener('click', function() {
                const icons = document.querySelectorAll('i:not(.leftIcon)');
                console.log(icons);
                const iconInput = document.querySelector('#iconInput');
                icons.forEach((icon, index) => {
                    icon.style.cursor = 'copy';
                    icon.addEventListener('click', function() {
                        iconInput.value = icon.classList.value
                        leftIcon.classList.value = icon.classList.value
                        $('#iconModal').modal('hide');
                    });
                });

            });
        });
    </script>
@endsection
