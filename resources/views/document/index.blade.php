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
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
                    <div class="breadcrumb-title ps-3">{{__('general_words.home')}}</div>
                    <div class="pe-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="/dashboard"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('fc9.fc9_list') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- End breadcrumb -->
              
                <div class="card radius-10">
                    <div class="card-title d-flex justify-content-between">
                        <div class="d-flex align-items-center mb-0">
                            <i class="fadeIn animated bx bx-menu"></i>
                            <h5 class="mb-0 fc-title">{{ __('fc9.fc9_list') }}</h5>
                        </div>
                            <div class="mt-2" v-show="!isOilFc9">
                                <btn :label="'@lang('general_words.create')'" href="{{ route('documents.create') }}"
                                :icon="'bx bx-plus align-middle'"></btn>
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
                                                        <label class="label">{{ __('general_words.number') }}</label>
                                                        <input type='text' class="form-control" v-model="fc9_number">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 select2-sm">
                                                    <div class="form-floating">
                                                        <label class="label">{{ __('fc9.request_directorate') }}</label>
                                                        <v-select :options="directorates" @search="searchDirectorate"
                                                        label="name" v-model="selected_dir"
                                                        placeholder="@lang('general_words.directorate')"></v-select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <label for="validationCustom01"
                                                        class="label">{{ __('general_words.issue_date') }}</label>
                                                        <mof-date-picker v-model="date"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex flex-row-reverse mt-4">
                                                    <btn :label="'@lang('general_words.reset')'"
                                                         :icon="'fadeIn animated bx bx-reset'"
                                                         @click="resetForm(); getRecord()"></btn>

                                                    <btn :label="'@lang('general_words.search')'"
                                                         :tooltip_text="'@lang('general_words.search')'"
                                                         :icon="'bx bx-search'" @click="getRecord()"
                                                         :loading="showLoading"></btn>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end Seaerch -->
                        <div class="justify-content-end d-flex" style="position: absolute;left: 15px;margin-top: 20px;">
                            @if(hasPermission(['fecen9_report']))
                                <btn :label="'@lang('general_words.download')'"
                                     :btn_class="'btn btn-warning px-4 detail-btn ms-1 mt-2'"
                                     :icon="'fadeIn animated bx bx-download'" @click="exportToExcel"></btn>
                            @endif
                        </div>
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
                                        <td v-for="skeleton in 4">
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
                                        <td> @{{record.title}}</td>
                                        <td> @{{record.remark}}</td>
                                        <td>
                                            <div class="p-1" role="group">
                                                <div class="d-flex justify-content-center order-actions">
                                                    <div class="hover-text">
                                                       
                                                            <show-btn :href="`{{url('documents/${record.id}')}}`"
                                                                      :tooltip_text="'@lang('general_words.view')'"/>   
                                                    </div>
                                                    <div class="hover-text">
                                                       
                                                            <edit-btn :href="`{{url('documents/${record.id}/edit')}}`"
                                                                      :tooltip_text="'@lang('general_words.edit')'"/>
                                                    </div>
                                                    
                                                        <div class="hover-text">
                                                            <delete-btn
                                                                @click="deleteRecord(record.id)"
                                                                :tooltip_text="'@lang('general_words.delete')'"/>
                                                        </div>
                                                 
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
                    url: '{{route("documents.index")}}?',
                    columns: [
                        {
                            label: "@lang('general_words.number')",
                            name: 'id',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: " عنوان ",
                            name: 'title',
                        },
                        {
                            label: " ملاحظه ",
                            name: 'remark',
                        },
                        {
                            label: " اجراات ",
                            name: 'action',
                        },
                       
                    ],
                    apiData: {},
                    appPerPage: '{!! perPage(1) !!}',
                    perPage: "{{ perPage() }}",
                    page: 1,
                    loading: null,
                    show_search: null,
                    selectedRows: [],
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
                    vm.directorate_id = vm.selected_dir ? vm.selected_dir?.id : null,
                        axios.get(vm.url
                            // + '&current_page=' + page
                            // + '&fc9_number=' + vm.fc9_number
                            // + '&directorate_id=' + vm.directorate_id
                            // + '&date=' + vm.date
                            // + '&per_page=' + vm.perPage)
                             )
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
                resetForm() {
                    this.selected_item = null;
                    this.fc9_number = null;
                    this.selected_dir = null;
                    this.directorate_id = null;
                    this.date = null;
                },
                // delete record
                deleteRecord(id = null) {
                    
                    Swal.fire({
                        title: "{{ __('general_words.are_you_sure')}}",
                        text: "{{ __('general_words.wont_be_to_revert')}}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonText: "{{ __('general_words.cancel_it')}}",
                        cancelButtonColor: '#d33',
                        confirmButtonText: "{{ __('general_words.yes_delete')}}"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`{!! url('documents/${id}') !!}`).then((response) => {
                        if(response.status === 200){
                            showMessage(response.message, 'success');
                        }
                        else{
                            showMessage(" انجام نشد ", 'success');
                        }
                    })
                        } else {
                            Swal.fire(
                                "{{ __('general_words.not_deleted')}}",
                                "{{ __('general_words.record_is_safe')}}",
                                'success'
                            )
                        }
                    })
                
                   
                },
            }
        });
    </script>
@endsection
