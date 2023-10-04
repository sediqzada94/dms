@extends('layouts.master')
@section('title')
    د خدماتو ریاست - ریاست خدمات
@endsection
@section('content')
    <div class="wrapper" id="app">
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title ps-3">{{__('general_words.home')}}</div>
                        <div class="pe-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">404 Error</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-xl-12 mx-auto">
                        <div class="card border-top border-0 bg-login pace-done">
                            <div class="card-body">
                            <div class="p-4 row">
                                <!-- col-md-7 end -->
                                <div class="error-404 d-flex align-items-center justify-content-center">
                                    <div class="card shadow-none bg-transparent">
                                        <div class="card-body text-center">
                                            <h1 class="display-4 mt-5">404 Error</h1>
                                            <div class="row">
                                                <div class="col-12 col-lg-12 mx-auto">
                                                <img src="assets/images/4042.png" style="width: 200px;margin-left: auto;margin-right: auto;">
                                                <h2>Page not Found</h2>
                                                <p>You can search for the page you want here or return to the <span href="/">homepage</span>.</p>
                                                    <div class="col mb-5 d-flex justify-content-center">
                                                        <button type="button"
                                                        class="btn btn-outline-success position-relative px-4 detail-btn"> {{ __('general_words.home')}} </button>

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
</div>

@endsection

