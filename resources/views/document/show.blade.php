@extends('layouts.master')
@section('title')
    د خدماتو ریاست - ریاست خدمات
@endsection
@section('content')
    <!--wrapper-->
    <div class="wrapper">
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content" id="app" >
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
                    <div class="breadcrumb-title ps-3">{{__('general_words.home')}}</div>
                    <div class="pe-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="/dashboard"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">dskdk</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end breadcrumb-->
                <div class="row">
                    <div class="col-xl-12 mx-auto">
                        <div class="card border-top border-0">
                            <div class="card-title d-flex justify-content-between">
                                <div class="d-flex align-items-center mb-0">
                                    <i class="fadeIn animated bx bx-menu"></i>
                                    <h5 class="mb-0 fc-title"></h5>
                                </div>
                               
                                    <div class="hover-text">
                                        <btn
                                            :tooltip_text="'@lang('general_words.go_to_list')'"
                                            btn_class="btn btn" :icon="'fadeIn animated bx bx-left-arrow-alt me-1'"
                                            href="{{url()->previous()}}"></btn>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- col-md-7 end -->
                                <form class="needs-validation p-4" novalidate>
                                    <div class="fc9-form row">
                                        <div class="col-md-3">
                                            <div class="row mb-3 floating-title">
                                                <label for="inputEnterRFPNumber"
                                                       class="col-form-label"> موضوع
                                                    :</label>
                                                <div class="">
                                                    <label class="formedit"> {{ $document->title }} </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- col-md-6 end -->
                                        <div class="col-md-3">
                                            <div class="row mb-3 floating-title">
                                                <label for="inputEmailAddress2"
                                                       class="col-form-label"> ملاحظه 
                                                    : *</label>
                                                <div class="">
                                                    <label class="formedit"> {{ $document->remark }}  </label>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <!-- col-md-6 end -->
                                        <!-- end of col -->
                                    </div>
                                    <div class="item-list">
                                        <h6>جزییات سند</h6>
                                        <div class="table-responsive">
                                            <table class="table mb-0 borderbtm">
                                                <thead class="table-light">
                                                <tr>
                                                    <th class="header" scope="col">شماره</th>
                                                    <th class="header" scope="col">نام فرستنده</th>
                                                    <th class="header" scope="col"> نام گیرنده </th>
                                                    <th class="header" scope="col"> نمبر وارده </th>
                                                    <th class="header" scope="col"> نمبر صادره </th>
                                                    <th class="header" scope="col"> تاریخ وارده </th>
                                                    <th class="header" scope="col"> تاریخ صادره </th>
                                                    <th class="header" scope="col"> مهلت درخواست </th>
                                                    <th class="header" scope="col"> ملاحظه </th>
                                                    <th class="header" scope="col"> تعداد ضمایم </th>
                                                    <th class="header" scope="col"> مهلت </th>
                                                    <th class="header" scope="col"> حالت </th>
                                                    <th class="header" scope="col"> نوع مهلت </th>
                                                    <th class="header" scope="col"> سطح امنیتی </th>
                                                    <th class="header" scope="col"> نوع تعقیب </th>
                                                    <th class="header" scope="col"> نوع سند </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($document->trackers as $tracker)
                                                    <tr>
                                                        <td>
                                                            <label class="">{{ $loop->iteration }}</label>
                                                        </td>
                                                        <td>
                                                            <label class=""></label>
                                                        </td>
                                                        <td>
                                                            <label  class=""></label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->in_num }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->out_num }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->in_date }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->out_date }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->request_deadline }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->remark }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->attachment_count }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->deadline->days }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->status->name }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->deadlineType->name }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->securityLevel->name }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->followupType->name }}</label>
                                                        </td>
                                                        <td>
                                                            <label  class="">{{ $tracker->docType->name }}</label>
                                                        </td>
                                                      
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- save button -->

                                    <!-- end save button -->
                                </form>
                                <!-- finish discrption -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>

        </div>
        <!-- model -->


        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        @endsection


