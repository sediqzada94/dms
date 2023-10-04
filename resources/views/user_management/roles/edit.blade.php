@extends('layouts.master')
@section('title')
    د خدماتو ریاست - ریاست خدمات
@endsection
@section('content')
    <!--wrapper-->
    <div class="wrapper">
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
                                <li class="breadcrumb-item active"
                                    aria-current="page">{{ __('general_words.role_list') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end breadcrumb-->
                <div class="row" id="app" v-cloak>
                    <div class="col-xl-12 mx-auto">
                        <div class="card border-top border-0">
                            <div class="card-title d-flex justify-content-between">
                                <div class="d-flex align-items-center mb-0">
                                    <i class="fadeIn animated bx bx-menu"></i>
                                    <h5 class="mb-0 fc-title">{{ __('general_words.create') }} {{ __('permission.permission') }}  </h5>
                                    <br>
                                </div>
                                <div class="col-1 hover-text mt-1 ms-3">
                                    <a href="{{url('role')}}" class="btn btn-outline-light">
                                        <i class="fadeIn animated bx bx-left-arrow-alt me-1"
                                        ></i>
                                        <span id="top" class="tooltip-text">Back</span></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- col-md-7 end -->

                                <!-- finish discrption -->
                                <form action="{{route('role.update',$role->id)}}" @submit="handleSubmit($event)"
                                        method="post" id="roleForm" class="p-4 card-role">
                                    @csrf
                                    @method('patch')

                                    <div class="fc9-form row">
                                        <!-- col-md-6 end -->
                                        <!-- <div class="row">
                                            <div class="col-xl-6 mb-3">
                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control"
                                                            data-vv-as="{{ __('general_words.name') }}"
                                                            value="{{$role->name}}"
                                                            placeholder="{{ __('general_words.name') }}">
                                                    <span class="help-block rq-hint"></span>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-xl-4 mb-3">
                                                <div class="form-group">
                                                    <input type="text" name="name_en" class="form-control" value="{{$role->name_en}}"
                                                            placeholder="{{ __('general_words.name_in_en') }}">
                                                    <span class="help-block rq-hint"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 mb-3">
                                                <div class="form-group">
                                                    <input type="text" name="name_prs" class="form-control"  value="{{$role->name_prs}}"
                                                            placeholder="{{ __('general_words.name_in_prs') }}">
                                                    <span class="help-block rq-hint"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 mb-3">
                                                <div class="form-group">
                                                    <input type="text" name="name_ps" class="form-control"  value="{{$role->name_ps}}"
                                                            placeholder="{{ __('general_words.name_in_ps') }}">
                                                    <span class="help-block rq-hint"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <input type="hidden" name="permission_id" id="permission_id">
                                            <div class="col-md-3" v-for="(item,g_index) of permission_group">
                                                <div class="card bg-white shadow-5 p-3">
                                                    <h5 class="card-header bg-transparent border-bottom mt-0">
                                                        <input type="checkbox"
                                                                class="form-check-input"
                                                                @click="checkPoint(item.permission_group_id,0,'parent')"
                                                                id="item.permission_group_name"
                                                                :checked="item.checked">
                                                        @{{item.permission_group_name}}</h5>
                                                    <div class="card-body">
                                                        <span v-for="permessions of item.permissions">
                                                            <!-- <h4 class="card-title font-size-16 mt-0">Special title treatment</h4> -->
                                                            <p class="card-text">
                                                            <input type="checkbox"
                                                                    class="form-check-input"
                                                                    @click="checkPoint(item.permission_group_id,permessions.permission_id,'child')"
                                                                    id="jack" value="permessions.permission_name"
                                                                    :checked="permessions.checked">
                                                            @{{permessions.permission_name}}</p>
                                                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- save button -->
                                    <div class="col mb-5 d-flex justify-content-end hover-text">
                                        <button type="button" @click="handleSubmit($event)"
                                                class="btn btn-outline-success position-relative px-5 detail-btn">
                                            <span class="tooltip-text"
                                                    id="top">{{ __('general_words.save')}}</span> {{ __('general_words.save')}}
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- Detail Start -->

                        <!-- finish discrption -->
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <!-- model start -->


    <!-- model End -->
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->

@endsection
@section('scripts')
    <script>
        var permission_group = {!! $permission_data !!};

        var vm = new Vue({
            el: '#app',
            data: {
                permission_group: permission_group,
                permission: [],
                selected_permission: [],
                select_all: false,
            },
            mounted: function () {

                this.checkIfAllSelected();
            },
            methods: {
                //handle check and uncheck or permission
                checkPoint(p_g_id, p_id, type) {

                    if (type == 'all') {
                        this.select_all = !this.select_all;
                        if (this.select_all == true) {

                            for (var i = 0; i < this.permission_group.length; i++) {
                                for (var m = 0; m < this.permission_group[i].permissions.length; m++) {

                                    this.permission_group[i].permissions[m].checked = true;
                                }
                                this.permission_group[i].checked = true;

                            }
                        } else {
                            for (var i = 0; i < this.permission_group.length; i++) {
                                for (var m = 0; m < this.permission_group[i].permissions.length; m++) {

                                    this.permission_group[i].permissions[m].checked = false;
                                }
                                this.permission_group[i].checked = false;

                            }
                        }
                    }
                    //begin parent
                    if (type == 'parent') {
                        for (var i = 0; i < this.permission_group.length; i++) {
                            if (this.permission_group[i].permission_group_id == p_g_id) {
                                this.permission_group[i].checked = !this.permission_group[i].checked;
                                var flag = this.permission_group[i].checked;
                                for (var m = 0; m < this.permission_group[i].permissions.length; m++) {

                                    this.permission_group[i].permissions[m].checked = flag;
                                }
                            }
                        }
                    }

                    // end parent


                    //begin child

                    if (type == 'child') {
                        for (var i = 0; i < this.permission_group.length; i++) {

                            let flag_temp = false;
                            for (var m = 0; m < this.permission_group[i].permissions.length; m++) {
                                if (p_id == this.permission_group[i].permissions[m].permission_id) {
                                    var temp = !this.permission_group[i].permissions[m].checked;
                                    this.permission_group[i].permissions[m].checked = temp;
                                }

                                if (this.permission_group[i].permissions[m].checked == false) {
                                    flag_temp = true;
                                    this.permission_group[i].checked = false;
                                }


                            }

                            if (flag_temp == false) {
                                // this.permission_group[i].checked = true;
                            }

                        }
                    }
                    // end child


                    let check_all_check = false;
                    for (var i = 0; i < this.permission_group.length; i++) {
                        for (var m = 0; m < this.permission_group[i].permissions.length; m++) {

                            if (this.permission_group[i].permissions[m].checked == false) {
                                check_all_check = true;
                            }
                        }

                    }

                    if (check_all_check == true) {
                        // not check all
                        this.select_all = false;
                    } else {
                        this.select_all = true;
                    }
                },

                checkIfAllSelected() {
                    let check_all_check = false;
                    for (var i = 0; i < this.permission_group.length; i++) {
                        for (var m = 0; m < this.permission_group[i].permissions.length; m++) {

                            if (this.permission_group[i].permissions[m].checked == false) {
                                check_all_check = true;
                            }
                        }

                    }

                    if (check_all_check == true) {
                        // not check all
                        this.select_all = false;
                    } else {
                        this.select_all = true;
                    }
                },


                /**
                 * handleSubmit
                 */
                handleSubmit(e, type = 'save') {
                    let selected_p = [];
                    for (var i = 0; i < this.permission_group.length; i++) {
                        for (var m = 0; m < this.permission_group[i].permissions.length; m++) {
                            if (this.permission_group[i].permissions[m].checked) {
                                selected_p.push(this.permission_group[i].permissions[m].permission_id);
                            }
                        }
                    }
                    document.getElementById('permission_id').value = selected_p;
                    let url = (e.target.form == undefined) ? e.target.action : e.target.form.action;
                    let data = (e.target.form == undefined) ? $(e.target).serialize() : $(e.target.form).serialize();

                    axios.post(url, data)
                        .then(function (response) {
                            if (response.data.status == 200) {
                                showMessage(response.data.message, 'success');
                                window.location.href = "{{route('role.index')}}";
                            } else {
                                showMessage(response.data.message, 'warning');
                            }

                        })
                        .catch(function (error) {

                        })
                },
                /**
                 * this is used to set default value
                 */
                defaultValue(e) {
                    $(e.target.form).trigger('reset');
                },

            }
        });

    </script>
@endsection
