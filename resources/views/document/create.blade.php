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
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
                    <div class="breadcrumb-title ps-3">{{__('general_words.home')}}</div>
                    <div class="pe-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="/dashboard"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">ثبت سند</li>
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
                                    <h5 class="mb-0 fc-title"> ثبت سند  </h5><br>
                                </div>
                                <div class="ms-4">
                                    <btn btn_class="btn btn" :icon="'fadeIn animated bx bx-left-arrow-alt me-1'"
                                    href="/"></btn>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- finish discrption -->
                                <form class="needs-validation p-4">
                                    <div class="fc9-form row">
                                       
                                        <div class="col-md-4">
                                            <div class="row mb-3 select2-sm">
                                                <div class="form-floating">
                                                    <label for="inputChoosePassword2"
                                                    class="label">عنوان
                                                    :*</label>
                                                    <input :disabled="disable" type="text" v-model="form.title" 
                                                            id="title" class="form-control">
                                                  <span style="color:red"> @{{ this.docFormErrors?.title?.[0] }} </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row mb-3 select2-sm">
                                                <div class="form-floating">
                                                    <label for="inputChoosePassword2"
                                                    class="label"> ملاحظه
                                                    :*</label>
                                                    <input :disabled="disable" type="text" v-model="form.remark" 
                                                            id="remark" class="form-control">
                                                    <span style="color:red"> @{{ this.docFormErrors?.remark?.[0] }} </span>
                                                </div>
                                            </div>
                                        </div>
                                        

                                    </div>
                                    <!-- save button -->
                                    <div class="col mb-5 d-flex justify-content-end">
                                        <btn :label="'@lang('general_words.save')'" @click="saveForm"
                                             :icon="'fadeIn animated bx bx-save'"  :disable="disable" :loading="loading"></btn>

                                        <div v-show="disable">
                                            <btn :label="'@lang('general_words.complete')'" :btn_class="'btn btn-outline-light'"
                                                 href="dasf/"
                                                 :icon="'fadeIn animated bx bx-message-square-check me-1'"></btn>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- Detail Start -->
                       
{{--                        <loader :loading="loading"></loader>--}}
                        <div class="card border-top border-0">
                            <div class="card-title d-flex justify-content-between">
                                <div class="d-flex align-items-center mb-0">
                                    <i class="fadeIn animated bx bx-menu"></i>
                                    <h5 class="mb-0 fc-title">{{ __('fc9.fc9_detail') }}:*</h5>
                                </div>
                                <div class="blink ms-4">
                                    <i v-show="disable" class="fadeIn animated bx bx-arrow-back arrow1"></i>
                                    <btn label="اضافه نمودن ردیاب" @click="openModal"
                                    :icon="'bx bx-plus-circle align-middle'" :btn_class="'arrow btn btn-outline-success px-3 detail-btn ms-1 mb-1'"></btn>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="item-list pb-5">
                                    <div class="scrolltb">
                                        <form class="row g-3 needs-validation" action="">
                                            <table class="table mb-0 borderbtm" id="dynamicAddRemove">
                                                <thead class="table-light" style="position: sticky;top: 0"
                                                       class="thead-dark">
                                                <tr>
                    
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
                                                    <th class="header" scope="col"> {{ __('general_words.action') }} </th>

                                                
                                                </tr>
                                                </thead>
                                                <tbody id="items-table-body">
                                                <tr v-for="(item,index) in trackerData">
                                                    <td>@{{ item?.sender_name }}</td>
                                                    <td>@{{ item?.receiver_name }}</td>
                                                    <td>@{{ item?.in_num }}</td>
                                                    <td>@{{ item?.out_num }}</td>
                                                    <td>@{{ item?.in_date }}</td>
                                                    <td>@{{ item?.out_date }}</td>
                                                    <td>@{{ item?.request_deadline }}</td>
                                                    <td>@{{ item?.remark }}</td>
                                                    <td>@{{ item?.attachment_count }}</td>
                                                    <td>@{{ item?.deadline }} روز</td>
                                                    <td>@{{ item?.status_name }}</td>
                                                    <td>@{{ item?.deadline_type_name }}</td>
                                                    <td>@{{ item?.security_level_name }}</td>
                                                    <td>@{{ item?.followup_type_name }}</td>
                                                    <td>@{{ item?.doc_type_name }}</td>
                                                    <td class="">
                                                        <div class="p-1" role="group">
                                                            <div class="d-flex justify-content-center order-actions">
                                                                <div class="hover-text">
                                                                    <edit-btn @click="editRecord(item.id,index)"
                                                                              :tooltip_text="'@lang('general_words.edit')'"/>
                                                                </div>
                                                                <div class="hover-text">
                                                                    <delete-btn
                                                                        @click="deleteRecord(item.id,index)"
                                                                        :tooltip_text="'@lang('general_words.delete')'"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>

                                <!-- finish discrption -->
                                <!-- model start -->
                                @include('document.create-edit-modal')

                                <!-- model End -->
                            </div>
                        </div>
                        <!-- finish discrption -->
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
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
    <script type="module">

        var vm = new Vue({
            el: '#app',
            components: {},
            data() {
                return {
                    employees: {!! $employees !!},
                    deadlines: {!! $deadlines !!},
                    deadline_types: {!! $deadline_types !!},
                    statuses: {!! $statuses !!},
                    security_levels: {!! $security_levels !!},
                    followup_types: {!! $followup_types !!},
                    document_types: {!! $document_types !!},
                    selected_sender_employee: null,
                    selected_receiver_employee: null,
                    selected_deadline: null,
                    selected_deadline_type: null,
                    selected_status: null,
                    selected_security_level: null,
                    selected_followup_type: null, 
                    selected_doc_type: null,
                    disable: false,
                    isEdit: false,
                    loading:false,
                    form: {
                        title: null,
                        remark: null,
                    },
                    trackerData: [],
                    trackerForm: {
                        sender_id: null,
                        receiver_id: null,
                        in_num: null,
                        out_num: null,
                        in_date: null,
                        out_date: null,
                        request_deadline: null,
                        remark: null,
                        attachment_count: null,
                        deadline_id: null,
                        status_id: null,
                        deadline_type_id: null,
                        security_level_id: null,
                        followup_type_id: null,
                        doc_type_id: null,
                        document_id: null,
                    },
                    tracker_id: null,
                    docFormErrors: null,
                    trackerFormErrors: null,
                    
                }
            },
            created() {
                // this.selected_dir = this.directorates.find((e) => e.id == 1);
            },
            updated() {
               
            },
            methods: {
                // save document
                saveForm() {
                        this.loading = true;
                            axios.post("{{ route('documents.store') }}", this.form).then((res) => {
                                let response = res.data;
                                if (response.status == 200) {
                                    this.loading = false;
                                    this.docFormErrors = null;
                                    this.trackerForm.document_id = response.document_id;
                                    showMessage("saved");
                                    this.disable = true;
                                    this.addPreventNavigationEventListener();
                                }
                               
                                else {
                                    this.loading = false;
                                    showMessage('failed');
                                }
                            }).catch((error) => {
                                this.loading = false
                                // Handle error response (including validation errors)
                                if (error.response && error.response.status === 422) {
                                this.docFormErrors = error.response.data.errors;
                                } else {
                                console.error("Other Error: ", error);
                                }
                            });
       
                },

                openModal() {
                    if (this.trackerForm.document_id != null) {
                        $('#tracker-modal').modal('show');
                    } else {
                        showMessage("سند را ابتدا ایجاد کنید", 'warning');
                    }
                },
                saveTracker() {
                    // this.save_item_loader = true; 
                    this.trackerForm.sender_id =  this.selected_sender_employee?.id;
                    this.trackerForm.receiver_id = this.selected_receiver_employee?.id;
                    this.trackerForm.deadline_id = this.selected_deadline?.id;
                    this.trackerForm.deadline_type_id = this.selected_deadline_type?.id;
                    this.trackerForm.status_id = this.selected_status?.id;
                    this.trackerForm.security_level_id = this.selected_security_level?.id;
                    this.trackerForm.followup_type_id = this.selected_followup_type?.id;
                    this.trackerForm.doc_type_id = this.selected_doc_type?.id;
                    axios.post("{{ route('trackers.store') }}", this.trackerForm).then((res) => {
                        let response = res.data;
                        console.log(response)
                        if (response.status == 200) {
                            this.save_item_loader = false;
                            this.trackerFormErrors = null;
                            $('#tracker-modal').modal('hide');
                            // this.$emit('saveItems')
                            showMessage(response.message, 'success');
                            this.trackerData.push({
                                id: response.tracker.id,
                                sender_name: this.selected_sender_employee?.name,
                                receiver_name: this.selected_receiver_employee?.name,
                                in_num: this.trackerForm.in_num,
                                out_num: this.trackerForm.out_num,
                                in_date: this.trackerForm.in_date,
                                out_date: this.trackerForm.out_date,
                                request_deadline: this.trackerForm.request_deadline,
                                remark: this.trackerForm.remark,
                                attachment_count: this.trackerForm.remark,
                                deadline: this.selected_deadline?.days,
                                status_name: this.selected_status?.name,
                                deadline_type_name: this.selected_deadline_type?.name,
                                security_level_name: this.selected_security_level?.name,
                                followup_type_name: this.selected_followup_type?.name,
                                doc_type_name: this.selected_doc_type?.name,
                            
                            });
                          this.resetForm();
                        } else {
                            this.save_item_loader = false;
                            showMessage(response.message, 'warning');
                        }

                    }).catch((error) => {
                                this.loading = false
                                this.save_item_loader = false;
                                // Handle error response (including validation errors)
                                if (error.response && error.response.status === 422) {
                                this.trackerFormErrors = error.response.data.errors;
                                } else {
                                console.error("Other Error: ", error);
                                }
                            });
                },
                resetForm() {
                    this.selected_sender_employee = null;
                    this.selected_receiver_employee = null;
                    this.trackerForm.in_num = null;
                    this.trackerForm.out_num = null;
                    this.trackerForm.in_date = null;
                    this.trackerForm.out_date = null;
                    this.trackerForm.request_deadline = null;
                    this.trackerForm.attachment_count = null;
                    this.trackerForm.remark = null;
                    this.selected_deadline = null;
                    this.selected_status = null;
                    this.selected_deadline_type = null;
                    this.selected_security_level = null;
                    this.selected_followup_type = null;
                    this.selected_doc_type = null;

                },
                deleteRecord(id = null, index) {
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
                            axios.delete(`{!!url('trackers')!!}/${id}`, {}).then((res) => {
                                let response = res.data;
                                if (response.status == 200) {
                                    Swal.fire(
                                        "{{ __('general_words.record_deleted')}}",
                                        "{{ __('general_words.action_done')}}",
                                    )
                                    this.trackerData.splice(index, 1);
                                } else {
                                    showMessage(response.message, 'warning');
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

                editRecord(id = null, index) {
                    this.rowIndex = index;
                    this.isEdit = true;
                    this.tracker_id = id;
                    $('#tracker-modal').modal('show');
                    axios.get(`{!!url('trackers/')!!}/${id}/edit`).then((res) => {
                        this.selected_sender_employee = res.data.sender;
                        this.selected_receiver_employee = res.data.receiver;
                        this.trackerForm.in_num = res.data.in_num;
                        this.trackerForm.out_num = res.data.out_num;
                        this.trackerForm.in_date = res.data.in_date;
                        this.trackerForm.out_date = res.data.out_date;
                        this.trackerForm.request_deadline = res.data.request_deadline;
                        this.trackerForm.attachment_count = res.data.attachment_count;
                        this.trackerForm.remark = res.data.remark;
                        this.selected_deadline = res.data.deadline;
                        this.selected_status = res.data.status;
                        this.selected_deadline_type = res.data.deadline_type;
                        this.selected_security_level = res.data.security_level;
                        this.selected_followup_type = res.data.followup_type;
                        this.selected_doc_type = res.data.doc_type;
                    });
                },
                updateItems() {
                    this.trackerForm.sender_id =  this.selected_sender_employee?.id;
                    this.trackerForm.receiver_id = this.selected_receiver_employee?.id;
                    this.trackerForm.deadline_id = this.selected_deadline?.id;
                    this.trackerForm.deadline_type_id = this.selected_deadline_type?.id;
                    this.trackerForm.status_id = this.selected_status?.id;
                    this.trackerForm.security_level_id = this.selected_security_level?.id;
                    this.trackerForm.followup_type_id = this.selected_followup_type?.id;
                    this.trackerForm.doc_type_id = this.selected_doc_type?.id;
                    console.log("Tracker is :", this.tracker_id)
                    this.save_item_loader = true;
                    axios.put(`{!! url('trackers/') !!}/${this.tracker_id}`, this.trackerForm).then((res) => {
                        let response = res.data;
                        if (response.status == 200) {
                            this.trackerFormErrors = null;
                            $('#tracker-modal').modal('hide');
                            showMessage(response.message, 'success');
                            const td = { ...response.tracker,
                                id: response.tracker.id,
                                sender_name: response.tracker.sender.name,
                                receiver_name: response.tracker.receiver.name,
                                deadline: response.tracker.deadline.days,
                                status_name: response.tracker.status.name,
                                deadline_type_name: response.tracker.deadline_type.name,
                                security_level_name: response.tracker.security_level.name,
                                followup_type_name: response.tracker.followup_type.name,
                                doc_type_name: response.tracker.doc_type.name,
                            }
                            this.$set(this.trackerData, this.rowIndex, td)
                            this.resetForm();
                            this.save_item_loader = false;
                            this.isEdit = false;
                        } else {
                            this.save_item_loader = false;
                            showMessage(response.message, 'warning');
                        }
                    }).catch((error) => {
                                this.save_item_loader = false
                                // Handle error response (including validation errors)
                                if (error.response && error.response.status === 422) {
                                this.trackerFormErrors = error.response.data.errors;
                                } else {
                                console.error("Other Error: ", error);
                                }
                            });
                },
            }
        });

    </script>
@endsection
