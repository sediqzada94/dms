<div class="col">
    <!-- Modal -->
    <div class="modal fade" id="tracker-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-0 fc-title"><i class="fadeIn animated bx bx-menu"></i> ردیاب سند </h5>
                    <button type="button" @click="resetForm" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <div class="modal-body row p-5">
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="validationDefault04"
                            class="label"> ارسال کننده </label>
                            <v-select :options="employees" @search="employeeSearch" label="name" v-model="selected_sender_employee" placeholder="@lang('general_words.employee')"></v-select>
                            <span style="color:red"> @{{ this.trackerFormErrors?.sender_id?.[0] }} </span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="validationDefault04"
                            class="label"> دریافت کننده </label>
                            <v-select :options="employees"  label="name" v-model="selected_receiver_employee" placeholder="@lang('general_words.employee')"></v-select>
                            <span style="color:red"> @{{ this.trackerFormErrors?.receiver_id?.[0] }} </span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="in_num"
                            class="label"> نمبر وارده </label>
                            <div class="input-group" >
                            <input type="text"
                             v-model="trackerForm.in_num"
                             style="width: 100%" id="in_num" class="form-control input-fld">
                            <span style="color:red;"> @{{ this.trackerFormErrors?.in_num?.[0] }} </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="out_num"
                            class="label"> نمبر صادره </label>
                            <div class="input-group">
                            <input type="text" v-model="trackerForm.out_num"
                            style="width: 100%" id="out_num" class="form-control input-fld">
                            <span style="color:red"> @{{ this.trackerFormErrors?.out_num?.[0] }} </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">                                     
                        <div class="mb-3 form-floating">
                            <label for="in_date"
                                class="label"> تاریخ وارده
                                :*</label>
                                <div>
                                    <mof-date-picker ref="date" :disabled="false" v-model="trackerForm.in_date"/>
                                </div>
                                <span style="color:red;"> @{{ this.trackerFormErrors?.in_date?.[0] }} </span>
                        </div>
                    </div>
                    <div class="col-md-4">                                     
                        <div class="mb-3 form-floating">
                            <label for="out_date"
                                class="label"> تاریخ صادره
                                :*</label>
                                <div>
                                <mof-date-picker ref="date" :disabled="false" v-model="trackerForm.out_date"/>
                                </div>
                            <span style="color:red"> @{{ this.trackerFormErrors?.out_date?.[0] }} </span>
                        </div>
                    </div>


                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="request_deadline"
                            class="label"> مهلت درخواست </label>
                            <div class="input-group">
                            <input type="number" min="1" v-model="trackerForm.request_deadline"
                            style="width: 100%" id="request_deadline" class="form-control input-fld">
                             <span style="color:red"> @{{ this.trackerFormErrors?.request_deadline?.[0] }} </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="attachment_count"
                            class="label"> تعداد ضمایم </label>
                            <div class="input-group">
                            <input type="number" min="1" v-model="trackerForm.attachment_count"
                            style="width: 100%"    id="attachment_count" class="form-control input-fld">
                                    <span style="color:red"> @{{ this.trackerFormErrors?.attachment_count?.[0] }} </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="document-type"
                            class="label"> نوع سند </label>
                            <v-select :options="document_types"  label="name" v-model="selected_doc_type" placeholder="نوع سند"></v-select>
                            <span style="color:red"> @{{ this.trackerFormErrors?.doc_type_id?.[0] }} </span>
                        </div>
                    </div>


                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="deadline"
                            class="label"> مهلت </label>
                            <v-select :options="deadlines"  label="days" v-model="selected_deadline" placeholder="مهلت"></v-select>
                            <span style="color:red"> @{{ this.trackerFormErrors?.deadline_id?.[0] }} </span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="status"
                            class="label"> حالت </label>
                            <v-select :options="statuses"  label="name" v-model="selected_status" placeholder="حالت"></v-select>
                            <span style="color:red"> @{{ this.trackerFormErrors?.status_id?.[0] }} </span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="deadline_type"
                            class="label"> نوع مهلت </label>
                            <v-select :options="deadline_types"  label="name" v-model="selected_deadline_type" placeholder="نوع مهلت"></v-select>
                            <span style="color:red"> @{{ this.trackerFormErrors?.deadline_type_id?.[0] }} </span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="security_level"
                            class="label"> سطح امنیتی </label>
                            <v-select :options="security_levels"  label="name" v-model="selected_security_level" placeholder="سطح امنیتی"></v-select>
                            <span style="color:red"> @{{ this.trackerFormErrors?.security_level_id?.[0] }} </span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label for="followup_type"
                            class="label"> نوع تعقیب </label>
                            <v-select :options="followup_types"  label="name" v-model="selected_followup_type" placeholder="سطح امنیتی"></v-select>
                            <span style="color:red"> @{{ this.trackerFormErrors?.followup_type_id?.[0] }} </span>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="floating-title">
                            <label class="label-txt">{{__('general_words.remark')}}</label>
                            <textarea class="form-control" v-model="trackerForm.remark"
                            rows="2" cols="1"></textarea>

                            <span style="color:red"> @{{ this.trackerFormErrors?.remark?.[0] }} </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close px-4"
                        data-bs-dismiss="modal" @click="resetForm">{{ __('general_words.close') }}
                        <i class="lni lni-close"></i>
                    </button>
                    <btn v-if="!isEdit" :label="'@lang('general_words.save')'" @click="saveTracker"
                    :icon="'fadeIn animated bx bx-save'"  :disable="false" :loading="save_item_loader"></btn>

                    <btn v-show="isEdit" :label="'@lang('general_words.update')'" @click="updateItems"
                    :icon="'fadeIn animated bx bx-save'"  :disable="false" :loading="save_item_loader"></btn>
                </div>
            </div>
        </div>
    </div>
</div>


