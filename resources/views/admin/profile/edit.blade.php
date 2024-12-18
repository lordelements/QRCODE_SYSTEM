@extends('admin.theme.default')

@section('content')


<div class="container-fluid">
    <!-- <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div> -->
    <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar position-relative">
                    <img
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-profile.png') }}"
                        alt="Profile Picture"
                        class="profile-picture img-fluid rounded-circle h-9">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        {{ Auth::user()->name }}
                    </h5>
                    <p class="mb-0 font-weight-bold text-sm">
                        CEO / Co-Founder
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-xl-4">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="text-lg font-medium text-gray-900 dark:text-gray-100">Profile Information</h6>
                        </div>
                        <div class="col-md-4 text-end">
                            <!-- <a href="">
                                        <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                                    </a> -->
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <p class="text-sm">
                        Hi, I’m {{ Auth::user()->name }}, Decisions: If you can’t decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).
                    </p>
                    <ul class="list-group">
                        @include('admin.profile.partials.update-profile-information-form')
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 d-flex align-items-center">
                            <header>
                                <h6 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Update Password') }}
                                </h6>
                            </header>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <p class="text-sm">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                    <ul class="list-group">
                        @include('admin.profile.partials.update-password-form')
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 d-flex align-items-center">
                            <header>
                                <h6 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Delete Account') }}
                                </h6>
                            </header>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <p class="text-sm">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. 
                                Before deleting your account, please download any data or information that you wish to retain.') }}
                    </p>
                    <ul class="list-group">
                        @include('admin.profile.partials.delete-user-form')
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    .profile-picture {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }
</style>

@endsection