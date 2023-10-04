@extends('layouts.master')
@section('title')
    د خدماتو ریاست - ریاست خدمات
@endsection
@section('content')
    <!--notification js -->
    <!--wrapper-->
    <div class="wrapper" id="app" v-cloak>
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
                    <div class="breadcrumb-title ps-3">{{ __('general_words.home') }}</div>
                    <div class="pe-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">{{ __('general_words.reports') }}</li>
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
                                    <h5 class="mb-0 fc-title">{{ __('general_words.reports') }}</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-success" role="tablist">
                                    @if(hasPermission(['item_general_report']))
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" @click="accordionChange('general_report')"
                                               data-bs-toggle="tab" href="#itemGeneralReportTab" role="tab" aria-selected="true">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class="bx bx-file font-18 me-1"></i>
                                                    </div>
                                                    <div
                                                        class="tab-title"> {{__('general_words.item_general_report')}}</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                             
                                </ul>

                                <div class="tab-content py-3">
                             @if(hasPermission(['item_general_report']))
                                    <div class="tab-pane fade show active" id="itemGeneralReportTab" role="tabpanel">
                                        @include('reports.item_general_report')
                                    </div>
                                @endif   
                              
                                </div>
                            </div>
                        </div>
                        <loader :loading="loading"></loader>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->

    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
@endsection
@section('scripts')
    <script type="module">

        var vm = new Vue({
            el: '#app',
            components: {},
            data() {
                return {
                    data: [],
                    items: [],
                    categories: [],
                    item_statuses: [],
                    item_types: [],
                    directorates: [],
                    fiscal_years: this.fiscalYear(),
                    fc9Types: this.fc9Types(),
                    selected_fc9_type: null,
                    donors: [],
                    hangars: [],
                    employees: [],
                    unit_of_measures: [],
                    motameds: [],
                    specs: [],
                    serial_number: null,
                    meem7_number: null,
                    selected_spec: null,
                    fiscal_year: null,
                    tag_number: null,
                    loading: false,
                    availabilities: [
                        {value: "{{__('general_words.distributed_items')}}"},
                        {value: "{{__('general_words.available_items')}}"},
                    ],
                    report_type: null,
                    parameters: null,
                    selected_item: '',
                    selected_item_status: null,
                    selected_category: null,
                    selected_item_type: null,
                    selected_directorate: null,
                    selected_hangar: null,
                    selected_motamed: null,
                    selected_measure: null,
                    selected_employee: null,
                    selected_donor: null,
                    selected_purchase_type: null,
                    selected_availability: null,
                    selected_fiscal_year: null,
                    from_date: null,
                    company: null,
                    params: null,
                    to_date: null,
                    meem7Types: this.meem7Type(),
                    select_meem_type: null,
                }
            },
            created() {
                const types = ["items", "item_statuses", "categories", "motameds", "unit_of_measures", 'employees', "item_types", "donors", "directorates", "hangars"];
                this.getDropdownItem(types);
            },
            methods: {
                accordionChange(report_type) {
                    this.reset();
                    if (report_type === 'vehicle_expenses') {
                        const types = ['vehicle_items'];
                        this.getDropdownItem(types);
                    } else {
                        const types = ['items'];
                        this.getDropdownItem(types);
                    }
                    this.report_type = report_type;
                },
                searchData() {
                },
                getItemSpecs() {
                    this.selected_spec = null;
                    this.specs = [];
                    if (this.selected_item) {
                        axios.get('/get_item_spec' + '?item_id=' + this.selected_item.id
                        ).then((response) => {
                            this.specs = response.data;
                        })
                            .catch(function (error) {
                                loading(false);
                            });
                    }
                },
                getRecord: _.debounce(() => {
                    vm.loading = true;
                    vm.params = '&item_id=' +
                        vm.selected_item?.id + '&category_id=' + vm.selected_category?.id
                        + '&item_type_id=' + vm.selected_item_type?.id
                        + '&item_status_id=' + vm.selected_item_status?.id
                        + '&hangar_id=' + vm.selected_hangar?.id
                        + '&measure_id=' + vm.selected_measure?.id
                        + '&motamed_id=' + vm.selected_motamed?.id
                        + '&directorate_id=' + vm.selected_directorate?.id
                        + '&employee_id=' + vm.selected_employee?.id
                        + '&availability=' + vm.selected_availability?.value
                        + '&fiscal_year=' + vm.selected_fiscal_year
                        + '&from_date=' + vm.from_date
                        + '&to_date=' + vm.to_date
                        + '&report_type=' + vm.report_type
                        + '&tag_number=' + vm.tag_number
                        + '&serial_number=' + vm.serial_number
                        + '&spec_id=' + vm.selected_spec?.id
                        + '&meem7_number=' + vm.meem7_number
                        + '&purchase_type=' + vm.select_meem_type?.slug
                        + '&company=' + vm.company
                        + '&fc9_type=' + vm.selected_fc9_type?.slug
                    axios.get('/getReportData?' + vm.params)
                        .then((response) => {
                            vm.loading = false;
                            vm.data = response.data;
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }, 200),

                reset() {
                    this.data = [];
                    this.report_type = null;
                    this.parameters = null;
                    this.selected_item = null;
                    this.selected_item_status = null;
                    this.selected_category = null;
                    this.selected_item_type = null;
                    this.selected_directorate = null;
                    this.selected_hangar = null;
                    this.selected_motamed = null;
                    this.selected_measure = null;
                    this.selected_donar = null;
                    this.selected_availability = null;
                    this.selected_employee = null;
                    this.from_date = null;
                    this.serial_number = null;
                    this.tag_number = null;
                    this.to_date = null;
                    this.selected_fiscal_year = null;
                },
                exportToExcel() {
                    this.loading = true;
                    if (this.data.length < 1) {
                        showMessage('No data to download', 'warning')
                        this.loading = false;
                    } else {
                        axios({
                            method: "get",
                            url: "{{url('excel')}}?type=" + vm.report_type
                                + vm.params,
                            responseType: "blob"
                        }).then(response => {
                            this.loading = false;
                            let Fformat = ".xlsx";
                            var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                            var fileLink = document.createElement("a");
                            fileLink.href = fileURL;
                            fileLink.setAttribute("download", vm.report_type.concat(".xlsx"));
                            document.body.appendChild(fileLink);
                            fileLink.click();
                        })
                            .catch((error) => {
                                reject(error);
                                console.log(error);
                            });
                    }
                },


            }
        });

    </script>
@endsection
