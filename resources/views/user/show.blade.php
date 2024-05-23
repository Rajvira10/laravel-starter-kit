@extends('layout')
@section('title', 'User')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0"></h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                                class="ri-home-5-fill"></i></a></li>
                                    <li class="breadcrumb-item"><a href={{ route('users.index') }}>Users</a></li>
                                    <li class="breadcrumb-item active">User Details</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="profile-foreground position-relative mx-n4 mt-n4">
                    <div class="profile-wid-bg">
                        <img src={{ asset('assets/images/profile-bg.jpg') }} alt="" class="profile-wid-img" />
                    </div>
                </div>
                <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
                    <div class="row g-4">
                        <div class="col-auto">
                            <div class="avatar-lg" data-bs-toggle="modal" data-bs-target="#userImageModal">
                                @if ($user->image != null)
                                    <img src={{ asset($user->image) }} alt="user-img"
                                        class="img-thumbnail rounded-circle" />
                                @else
                                    <img src={{ asset('assets/images/user-dummy-img.jpg') }} alt="user-img"
                                        class="img-thumbnail rounded-circle" />
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-2">
                                <h3 class="text-white mb-1">{{ $user->username }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <div class="d-flex">
                                <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1"
                                    role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab"
                                            role="tab">
                                            <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                                class="d-none d-md-inline-block">Overview</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content pt-4 text-muted">
                                <div class="tab-pane active" id="overview-tab" role="tabpanel">
                                    <div class="col-xxl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="card-title mb-3">About</h5>
                                                    <div class="flex-shrink-0">
                                                        @if (auth()->user()->authorize('users.edit'))
                                                            <a href={{ route('users.edit', $user->id) }}
                                                                class="btn btn-success"><i
                                                                    class="ri-edit-box-line align-bottom"></i> Edit </a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row text-black">
                                                    <div class="col-md-6">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <td><strong>Username :</strong></td>
                                                                <td>{{ $user->username }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Email :</strong></td>
                                                                <td>{{ $user->email }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Status :</strong></td>
                                                                @if ($user->status == 'active')
                                                                    <td><span class="badge bg-success">Active</span></td>
                                                                @else
                                                                    <td><span class="badge bg-danger">Inactive</span></td>
                                                                @endif
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userImageModal" tabindex="-1" aria-labelledby="userImageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    @if ($user->image != null)
                        <img src={{ asset($user->image) }} alt="user-img" width="300" height="auto" />
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
