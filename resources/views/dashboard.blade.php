@extends('layouts.master')
@section('title')
    د خدماتو ریاست - ریاست خدمات
@endsection
@section('content')
    <!--wrapper-->
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content" id="app1" v-cloak>
            <div class="row row-cols-1 row-cols-md-3 row-cols-xl-6 box-font-size cnt-center">
              
              
{{--               
                @if(hasPermission(['oil_fc9_dashboard_widget']))

                    <div class="col col-p">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-right">
                                    <div class="widgets-icons rounded-circle mx-auto bg-light mb-3"><i
                                            class="fadeIn animated bx bx-file"></i>
                                    </div>
                                    <h4 class="my-1 text-center">{{ __('sejel.oil_fc9') }}</h4>
                                    <p class="mb-0 text-secondary pt-2 d-flex justify-content-between dash-col">{{__('general_words.total_count')}}
                                        <span class="badge bg-primary bgprimary" st34Myle="">3</span>
                                    </p>
                                    <p class="mb-0 text-secondary pb-1 d-flex justify-content-between dash-col">{{__('general_words.approved')}}
                                        <span class="badge bg-success bgsuccess"
                                              style="">
                                       2
                                    </span>
                                    </p>
                                    <p class="mb-0 text-secondary pt-1 d-flex justify-content-between dash-col">{{__('general_words.rejected')}}
                                        <span class="badge bg-danger bgdanger"
                                              st34Myle="">
                                            1
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif --}}
            </div>
            <!--end row-->
            <div class="row">
                <!-- <h6 class="mb-0 text-uppercase">{{ __('general_words.progress_summary') }}</h6>
                <hr> -->
                <div class="col-12 col-lg-8 col-p">
                    <!-- end col-md-12 -->
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="p-2">
                                    {{-- <h6 class="mb-0">{{ __('general_words.distributed_consuming_items_in_fiscal_year') }}</h6> --}}
                                </div>
                                <hr>
                                <div>
                                    <canvas id="chart1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-p">
                    <div class="card radius-10">
                        <div class="card-body" style="padding: 13px;">
                            <div class="d-flex align-items-center">
                                <div class="p-2">
                                    {{-- <h6 class="mb-2">{{__('general_words.last_10_distributed_items')}}</h6> --}}
                                </div>
                                <hr>
                            </div>
                            <form class="d-flex">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="search_item_name"
                                             disabled placeholder="">
                                    {{-- <input type="text" class="form-control" v-model="search_item_name"
                                           @input="itemsSearch"  disabled placeholder=""> --}}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2" style="margin-top:-25px">
                                <div class="table-responsive table-style">
                                    {{-- <p v-show="!items || no_data">{{ __('general_words.this_item_does_not_exist') }}</p> --}}
                                    <table class="table align-middle mb-0" >
                                        <thead class="table-light font-th">
                                        {{-- <tr>
                                            <th>{{__('general_words.number')}}</th>
                                            <th>{{__('general_words.item_name')}} </th>
                                            <th>{{__('general_words.distributed_date')}}</th>
                                            <th>{{__('general_words.distributed_quantity')}}</th>
                                        </tr> --}}
                                        </thead>
                                        <tbody>
{{-- 
                                        <tr v-for="(item, index) in items">
                                            <td>@{{ index + 1 }}</td>
                                            <td><span class=" badge bg-light rounded-pill text-dark text-wrap">@{{item.item_name }}</span>
                                            </td>
                                            <td><span class="badge bg-light rounded-pill text-dark text-wrap">@{{item.fc5_date }}</span>
                                            </td>
                                            <td><span class="badge bg-light rounded-pill text-dark text-wrap">@{{item.distributed_quantity }} @{{item.measure }}</span>
                                            </td>
                                        </tr> --}}

                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-2">
                                <h6 class="mb-0">{{ __('general_words.vehicle_expenses') }}</h6>
                            </div>
                            <hr>
                            <div>
                                <canvas id="chart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--end row-->

            <!-- Table Start -->

        </div>
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
@endsection

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('scripts')
    <script type="text/javascript">
        let vm = new Vue({
            el: '#app1',
            components: {
            },
            data() {
               

            },
            mounted() {
               
            },
            methods: {
            
            }
        });
    </script>
@endsection
