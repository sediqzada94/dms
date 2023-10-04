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
                                <li class="breadcrumb-item active" aria-current="page">{{ __('permission.user_list') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card radius-10">
                    <div class="card-title d-flex justify-content-between">
                        <div class="d-flex align-items-center mb-0">
                            <i class="fadeIn animated bx bx-menu"></i>
                            <h6 class="mb-0 fc-title">{{ __('permission.user_list') }}</h6>
                        </div>
                        <div class="ms-3 mt-1">
                            @if(hasPermission(['user_create']))
                            <a href="{{ route('user.create') }}"
                                class="btn btn-outline-success position-relative px-4 detail-btn"> <i
                                    class="bx bx-plus-circle align-middle"></i> {{ __('general_words.create') }}
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body card-body1 p-4">
                        <!-- Search -->
                        <div class="accordion accordion1" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne">
                                        <i class="bx bx-search"></i> {{ __('general_words.search') }}
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                     data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <div class="p-4">
                                            <form class="row g-3 needs-validation" novalidate="">
                                                <div class="col-md-4 select2-sm">
                                                    <div class="form-floating">
                                                        <label class="label">{{ __('general_words.name') }}</label>
                                                        <input type='text' class="form-control" v-model="name">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <label for="validationCustom01"
                                                        class="label">{{ __('general_words.email') }}</label>
                                                        <input type="text" class="form-control"
                                                        value="" v-model="email">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 select2-sm">
                                                    <div class="form-floating">
                                                        <label
                                                        class="label">{{ __('fc9.request_directorate') }}</label>
                                                        <v-select :options="directorates" @search="searchDirectorate"
                                                        label="name" v-model="selected_dir"
                                                        placeholder="@lang('general_words.directorate')"></v-select>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex flex-row-reverse">
                                                    <button
                                                        class="btn btn-outline-success position-relative px-5 detail-btn"
                                                        type="button" @click="getRecord"><i
                                                            class="bx bx-search"></i>{{ __('general_words.search') }}
                                                    </button>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end Seaerch -->
                        <div class="spinner-border text-info" v-show="loading" style="z-index:999999999; position: absolute; left: 50%;
                                    top: 35%; width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden"> @include('general_files.loading')</span>
                        </div>
                        <div class=" ">
                            <datatable ref="child" :per-page="{{perPage()}}"
                                       :no-record-found-text="'@lang('general_words.no_record_found')'"
                                       :search="'@lang('general_words.search')'"
                                       :current="'@lang('general_words.current')'"
                                       :next="'@lang('general_words.next')'"
                                       :previous="'@lang('general_words.previous')'"
                                       :per-page-text="'@lang('general_words.per_page_record')'"
                                       :app-per-page="{!! perPage(1) !!}"
                                       :columns="columns" :data="apiData" @pagination-change-page="getRecord"
                                       :limit="1" :filterRecord="getRecord"
                                       @delete-method-action="deleteRecord">
                                <template slot="tbody">
                                    <tbody v-show="!apiData.data || showLoading">
                                    <tr v-for="skeleton in 4">
                                        <td v-for="skeleton in 5">
                                            <skeleton-loader-vue
                                                type="rect"
                                                :height="34"
                                                :width="150"
                                                :radius="8"
                                                class="m-2"
                                                animation="fade"
                                            />
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody v-show="apiData.data && !showLoading">
                                    <tr v-for="(record,index) in apiData.data" :key="record.id">
                                        <td> @{{index + 1}}</td>
                                        <td> @{{record.name}}</td>
                                        <td> @{{record.status}}</td>
                                        <td> @{{record.email}}</td>
                                        <td>
                                            <div class="p-1" role="group">
                                                <div class="d-flex justify-content-center order-actions">
                                                    @if(hasPermission(['user_view']))
                                                        <a :href="`{{url('user')}}/${record.id}`" class="btn-show ms-1"><i
                                                                class="fadeIn animated bx bx-show"></i></a>
                                                    @endif
                                                    @if(hasPermission(['user_edit']))
                                                        <a :href="`{{url('user/edit')}}/${record.id}`"
                                                           class="ms-1 btn-edit"><i
                                                                class="fadeIn animated bx bx-edit"></i></a>
                                                    @endif
                                                    @if(hasPermission(['user_delete']))
                                                        <a @click="deactivateRecord(record.id)" class="ms-1 btn-delete"><i
                                                                class="fadeIn animated bx bx-trash-alt"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    </tbody>

                                </template>
                            </datatable>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

    <script>
        let vm = new Vue({
            el: '#app',
            components: {
                'skeleton-loader-vue': window.VueSkeletonLoader,
            },
            data() {
                return {
                    loading: false,
                    showLoading: false,
                    url: '{{route("user.index")}}?',
                    columns: [
                        {
                            label: "@lang('general_words.number')",
                            name: 'id',
                            sort: false,
                        },
                        {
                            label: "@lang('general_words.name')",
                            name: 'name',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('general_words.status')",
                            name: 'status',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('general_words.email')",
                            name: 'email',
                            sort: true,
                        },

                        {
                            label: "@lang('general_words.action')",
                            name: 'action',
                            sort: false
                        }
                    ],
                    apiData: {},
                    appPerPage: '{!!perPage(1) !!}',
                    perPage: "{{perPage()}}",
                    directorates: {!! $directorates !!},
                    page: 1,
                    selected_dir: null,
                    name: null,
                    email: null,
                    directorate_id: null,
                    date: null,
                }

            },
            mounted() {
                this.getRecord();
            },
            methods: {
                /**
                 * get record from api
                 */

                getRecord: _.debounce((page = vm.page) => {
                    vm.showLoading = true;
                    vm.directorate_id = vm.selected_dir ? vm.selected_dir.id : null,
                        axios.get(vm.url
                            + '&current_page=' + page
                            + '&name=' + vm.name
                            + '&directorate_id=' + vm.directorate_id
                            + '&email=' + vm.email
                            + '&per_page=' + vm.perPage)
                            .then((response) => {
                                vm.showLoading = false;
                                if (response.data) {
                                    vm.page = response.data.current_page;
                                }
                                vm.apiData = response.data;
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                }, 200),

                // delete record
                deactivateRecord(id = null) {
                    deleteItem(`user/${id}`);
                    function deleteItem(url,callbackFunction) {
                        Swal.fire({
                            title: "{{ __('general_words.are_you_sure')}}",
                            text: "{{ __('general_words.wont_be_to_revert')}}",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonText: "{{ __('general_words.cancel_it')}}",
                            cancelButtonColor: '#d33',
                            confirmButtonText: "{{ __('general_words.yes_deactivate')}}"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios.post(`user/deactivate/${id}`, {}).then((response) => {
                                    let res = response.data;
                                    if (res.status == 200) {
                                        if(callbackFunction){
                                            callbackFunction();
                                        }else{
                                            vm.getRecord();
                                        }
                                        showMessage(res.message, 'success')
                                    } else {
                                        showMessage(res.message, 'warning')
                                    }
                                })
                            } else {
                                Swal.fire(
                                    "{{ __('general_words.not_deactivated')}}",
                                    "{{ __('general_words.record_is_safe')}}",
                                    'success'
                                )
                            }
                        })
                    }
                },
            }
        });
    </script>
@endsection
