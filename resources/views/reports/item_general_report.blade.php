    <div class="p-4">
        <div class="card-title d-flex justify-content-between">
            <div class="d-flex align-items-center mb-0">
                <i class="fadeIn animated bx bx-menu"></i>
                <h5 class="mb-0">{{__('general_words.item_general_report')}}</h5>
            </div>
        </div>
            <!-- col-md-7 end -->
                <div class="fc9-form row">
                    <div class="col-md-4">
                        <div class="row mb-3">
                            <div class="form-floating">
                                <label for="inputEnterRFPNumber" class="label">{{ __('general_words.item') }}:</label>
                                <v-select :options="items" @search="itemSearch"
                                label="name"  v-model="selected_item"
                                placeholder="@lang('general_words.item')"></v-select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mb-3">
                            <div class="form-floating">
                                <label class="label">{{ __('general_words.item_status') }}: </label>
                                <v-select :options="item_statuses"
                                label="name"  v-model="selected_item_status"
                                placeholder="{{ __('general_words.item_status') }}"></v-select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mb-3">
                            <div class="form-floating">
                                <label class="label">{{ __('general_words.motamed') }}: </label>
                                <v-select :options="motameds"
                                label="name"  v-model="selected_motamed"
                                placeholder="{{ __('general_words.motamed') }}"></v-select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mb-3">
                            <div class="form-floating">
                                <label class="label">{{ __('general_words.item_type') }}: </label>
                                <v-select :options="item_types"
                                label="name"  v-model="selected_item_type"
                                placeholder="{{ __('general_words.item_type') }}"></v-select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mb-3">
                            <div class="form-floating">
                            <label class="label">{{ __('general_words.category') }}: </label>
                            <v-select :options="categories"
                            label="name"  v-model="selected_category"
                            placeholder="{{ __('general_words.category') }}"></v-select>
                        </div>
                    </div>
                    <!-- col-md-4 end -->

                    <!-- col-md-4 end -->
                    <div class="d-flex justify-content-center">
                        <btn :label="'@lang('general_words.search')'" :icon="'fadeIn animated bx bx-search'" @click="getRecord"></btn>
                        <btn :label="'@lang('general_words.download')'" :icon="'fadeIn animated bx bx-download'" @click="exportToExcel"></btn>
                    </div>
                </div>
            <!-- Details -->
            <div class="" style="background: #fff;">
                <hr>
                <div class="item-list">
                    <div class="table-responsive">
                        <table class="table mb-0 borderbtm">
                            <thead class="table-light">
                            <tr>
                                <th>{{__('general_words.name')}}</th>
                                <th>{{__('general_words.unit_of_measure')}}</th>
                                <!-- TODO if required we should add item_spec -->
                                <!-- <th>{{__('general_words.description')}}</th> -->
                                <th>{{__('general_words.item_type')}}</th>
                                <th>{{__('general_words.item_status')}}</th>
                                <th>{{__('general_words.category')}}</th>
                                <th>{{__('general_words.total')}}</th>
                                <th>{{__('general_words.total_distributed')}}</th>
                                <th>{{__('general_words.total_available')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in data">
                                <td>
                                    <label>@{{ item.name }}</label>
                                </td>
                                <td>
                                    <label>@{{ item.measure }}</label>
                                </td>
                                <!-- <td>
                                    <label>@{{ item.description }}</label>
                                </td> -->
                                <td>
                                    <label>@{{ item.type }}</label>
                                </td>
                                <td>
                                    <label>@{{ item.status }}</label>
                                </td>
                                <td>
                                    <label>@{{ item.category }}</label>
                                </td>

                                <td>
                                    <label>@{{ item?Number(item.distributed)+Number(item.available):0 }}</label>
                                </td>
                                <td>
                                    <label>@{{ item.distributed?item.distributed:0 }}</label>
                                </td>
                                <td>
                                    <label>@{{ item.available?item.available:0 }}</label>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of reports -->
