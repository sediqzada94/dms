/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
// window.Vue=Vue;
import Vue from 'vue/dist/vue.esm.js';
import VueSkeletonLoader from 'skeleton-loader-vue';
import VueDatetimeJs from 'vue-datetime-js';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import swal from 'sweetalert2';
import vSelect from 'vue-select';
import moment from 'moment';
import Multiselect from 'vue-multiselect'

// register globally
Vue.component('multiselect', Multiselect)
// Vue.component('vue-multiselect', window.VueMultiselect.default)

export default {
  // OR register locally
  components: { Multiselect },
  data () {
    return {
      value: null,
      options: ['list', 'of', 'options']
    }
  }
}
import trMixin from './trMixin.js'

// import Vue from 'vue'
window.Vue = Vue;

// Register the component globally
Vue.component('vue-skeleton-loader', VueSkeletonLoader);


Vue.component('pagination', require('laravel-vue-pagination'));
window.VueSkeletonLoader = VueSkeletonLoader;

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.start();


window.Swal = swal;

Vue.component('v-select', vSelect);


Vue.component('datatable', require('./components/LaravelVueDatatable.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);
Vue.component('btn', require('./components/Button.vue').default);
Vue.component('action-btn', require('./components/ActionBtn.vue').default);
Vue.component('edit-btn', require('./components/EditBtn.vue').default);
Vue.component('show-btn', require('./components/ShowBtn.vue').default);
Vue.component('delete-btn', require('./components/DeleteBtn.vue').default);
Vue.component('history-btn', require('./components/HistoryBtn.vue').default);
Vue.component('date-picker', VueDatetimeJs);

moment.updateLocale('ar-sa', {
    postformat: function (string) {
        return string
            .replace(/\d/g, function (match) {
                return match;
            })
            .replace(/,/g, '،')
    }
})
const dateType = localStorage.getItem('defaultDateType');
Vue.use(VueDatetimeJs, {
    name: 'mof-date-picker',
    props: {
        color: '#428bff',
        locale: dateType === 'hijri' ? 'ar-sa' : dateType === 'gregorian' ? 'en' : 'fa',
        calendar: dateType ? dateType : 'jalali',
        wrapperSubmit: true
    }
});

Vue.mixin(trMixin)


Vue.mixin({
    data() {
        return {
            flowData: null,
            subFormSubmitted: false,
        }
    },
    computed: {},
    mounted() {
        // this function is created globally and called here, so this function do enter shortcuts for every input, select,and textarea
        this.shortCut();
        //This code globally work for every input, when ths user focus on an input then the input is focused
        const inputs = document.getElementsByTagName('input')
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('focus', function() {
                this.select()
            })
        }
    },
    methods: {
        //search Items from create and edit modal

//    ToDo, type should also pass to the functions so we need only to call a search function
        itemSearch(search, loading) {
            axios.get('/search'
                + '?keyword=' + search + '&type=' + 'item'
            )
                .then((response) => {
                    this.items = response.data;
                    loading(false);
                })
                .catch(function (error) {
                    loading(false);
                });
        },

        focusToNextInput(nextInput) {
            this.$refs[nextInput].$el.focus()
            if (nextInput == 'directorate') {
                this.$nextTick(() => {
                    this.$refs.directorate.$el.querySelector('input').focus();
                });
            }
        },

        //search vendor in create m7
        searchVendor(search, loading) {
            axios.get('/search'
                + '?keyword=' + search + '&type=' + 'vendor'
            )
                .then((response) => {
                    this.vendors = response.data;
                    loading(false);
                })
                .catch(function (error) {
                    loading(false);
                });
        },
        //search employees from create and edit modal
        employeeSearch(search, loading) {
            axios.get('/search'
                + '?keyword=' + search + '&type=' + 'employee'
            )
                .then((response) => {
                    this.employees = response.data;
                    loading(false);
                })
                .catch(function (error) {
                    loading(false);
                });
        },
        // naim code start

        //search Directorate in create fc9
        searchDirectorate(search, loading) {
            axios.get('/search'
                + '?keyword=' + search + '&type=' + 'directorate'
            )
                .then((response) => {
                    this.directorates = response.data;
                    loading(false);
                })
                .catch(function (error) {
                    loading(false);
                });
        },
        // This function upload files and attachments
        uploadAttachments(table_name) {
            const formData = new FormData();
            formData.append("attachment", this.file);
            if (this.file) {
                this.loading = true;
                axios.post('/upload' + '?table_id=' + this.table_id + '&table_name=' + table_name + '&file_name=' + this.file_name, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                    .then((res) => {
                        let response = res.data;
                        if (response.status == 200) {
                            this.loading = false;
                            this.file_name = '';
                            this.attachmentList.push(response.lastFile)
                            showMessage(res.data.message, 'success');
                        } else {
                            showMessage(res.data.message, 'warning');
                        }
                    });
            }
        },
        //Update or inset follow(this function update all tables follow)
        updateFlows(table, table_id, flow) {
            confirmFlow(table, table_id, flow).then(data => {
                this.latestFlow = data;
            })
        },
        fiscalYear() {
            let years = [];
            for (let x = 1403; x >= 1397; x--) {
                years.push(x);
            }
            return (years);
        },

        fc5Types() {
            return [{name: 'ترانسپورت', slug: 'transport'}, {name: 'عمومی', slug: 'general'}];
        },

        fc9Types() {
            return [{name: 'عراده', slug: 'vehicle'},
                    {name: 'ترمیم', slug: 'repairing'},
                    {name: 'تیل', slug: 'oil'},
                    {name: 'موبلاین', slug: 'moblin'}];
        },

        hijryMonths() {
            return ['حمل', 'ثور', 'جوزا', 'سرطان', 'اسد', 'سنبله', 'میزان', 'عقرب', 'قوس', 'جدی', 'دلو'];
        },

        filterEmployeeByDirectorate(dir_id) {
            this.employess = [];
            this.selected_employee = null
            axios.get('/getEmployeesByDir'
                + '?dir_id=' + dir_id
            )
                .then((response) => {
                    this.employees = response.data;
                })
                .catch(function (error) {
                });
        },

        meem7Type() {
            return [{name: 'م 2', slug: 'meem2'},
                {name: 'م 3', slug: 'meem3'},
                {name: 'قرارداد', slug: 'contract'},
                {name: 'تمویل شده', slug: 'donations'},
                {name: 'کمکی', slug: 'supported'},
                {name: 'ضبطی', slug: 'detected'},
                {name: 'صکوک', slug: 'sukuk'}];
        },
        gender(){
            return[
                {name:'مرد',slug:'M'},
                {name:'زن',slug:'F'}
               
            ]
        },

        async getDropdownItem(types) {
            return new Promise((resovle, reject) => {
                axios.get('/getData' + '?type=' + types).then(res => {
                    resovle(res.data);
                    if (types.includes('items') || types.includes('vehicle-parts')
                        || types.includes('vehicle_items') || types.includes('oil')) {
                        this.items = res.data.items;
                    }
                    if (types.includes('categories')) {
                        this.categories = res.data.categories;
                    }
                    if (types.includes('item_statuses')) {
                        this.item_statuses = res.data.item_statuses;
                    }
                    if (types.includes('item_types')) {
                        this.item_types = res.data.item_types;
                    }
                    if (types.includes('directorates')) {
                        this.directorates = res.data.directorates;
                    }
                    if (types.includes('donors')) {
                        this.donors = res.data.donors;
                    }
                    if (types.includes('hangars')) {
                        this.hangars = res.data.hangars;
                    }
                    if (types.includes('unit_of_measures')) {
                        this.unit_of_measures = res.data.unit_of_measures;
                    }
                    if (types.includes('employees')) {
                        this.employees = res.data.employees;
                    }
                    if (types.includes('motameds')) {
                        this.motameds = res.data.motameds;
                    }
                    if (types.includes('fecen8')) {
                        this.fecen8s = res.data.fecen8s;
                    }
                })
            })

        },
        hasFlowPermission: async function (table, id) {
            let response = await axios.get('/checkFlowPermission' + '?table=' + table + '&id=' + id)
            this.flowData = response.data;

            return response;
        },

        formatNumber(number) {
            if (number != null) {
                return new Intl.NumberFormat().format(Number(parseFloat(number).toFixed(2)))
            } else {
                return 0
            }
        },
        preventNavigation(event) {
            if (!this.subFormSubmitted) {
                const message = 'Are you sure?';
                event.preventDefault();
                event.returnValue = message;
                return message;
            }
        },
        handleSubFormSubmit() {
            this.subFormSubmitted = true
        },
        addPreventNavigationEventListener() {
            window.addEventListener('beforeunload', this.preventNavigation)
        },

        sejelItem() {
            let items = [
                {name_prs: 'سلندر بلاک', name_ps: '', name_en: 'Cylinder block', slug: 'cylinder_block',},
                {name_prs: 'سلندر هید', name_ps: '', name_en: 'Cylinder head', slug: 'cylinder_head',},
                {name_prs: 'گیر بکس', name_ps: '', name_en: 'Gearbox', slug: 'gearbox',},
                {name_prs: 'فرم', name_ps: '', name_en: 'Frame', slug: 'frame',},
                {name_prs: 'بطری', name_ps: '', name_en: 'Battery', slug: 'battery',},
                {name_prs: 'کاربتر-دیزل پمپ', name_ps: '', name_en: 'Carburetor diesel pump', slug: 'carburetor_diesel_pump',},
                {name_prs: 'داینمو', name_ps: '', name_en: 'Dynamo', slug: 'dynamo',},
                {name_prs: 'د 5 لکو', name_ps: '', name_en: 'da5 lak', slug: 'da_5_lak',},
                {name_prs: 'کتاوت', name_ps: '', name_en: 'Katawat', slug: 'katawat',},
                {name_prs: 'کوایل', name_ps: '', name_en: 'Coil', slug: 'coil',},
                {name_prs: 'چراغ کلان پیش روی', name_ps: '', name_en: 'Front big light', slug: 'front_bing_light',},
                {name_prs: 'چراغ کلان دیم', name_ps: '', name_en: 'Front light dim', slug: 'front_big_dim_light',},
                {name_prs: 'کعب تانکی', name_ps: '', name_en: 'Kab tanki', slug: 'kab_tanki',},
                {name_prs: 'شیشه کلان پیش روی', name_ps: '', name_en: 'windshield', slug: 'windshield',},
                {name_prs: 'شیشه کلان عقبی', name_ps: '', name_en: 'Rear window', slug: 'rear_window',},
                {name_prs: 'شیشه بغل', name_ps: '', name_en: 'Side window', slug: 'side_window',},
                {name_prs: 'لیلتر', name_ps: '', name_en: 'Liliter', slug: 'lileter',},
                {name_prs: 'بادی ترپال', name_ps: '', name_en: 'body_tarpal', slug: 'body_tarpal',},
                {name_prs: 'سلف', name_ps: '', name_en: 'self', slug: 'self',},
                {name_prs: 'سیت پیشروی', name_ps: '', name_en: 'Front set', slug: 'front_set',},
                {name_prs: 'سیت عقب', name_ps: '', name_en: 'Back set', slug: 'back_set',},
                {name_prs: 'جمپین', name_ps: '', name_en: 'jumping', slug: 'jumping',},
                {name_prs: 'رادیو کست', name_ps: '', name_en: 'Radio keset', slug: 'radio_keset',},
                {name_prs: 'کلید دروازه', name_ps: '', name_en: 'Key door', slug: 'key_door',},
                {name_prs: 'کلید سویچ', name_ps: '', name_en: 'key_switch', slug: 'key_switch',},
                {name_prs: 'کلید تانکی', name_ps: '', name_en: 'Tank switch', slug: 'tank_switch',},
                {name_prs: 'سگرت لایتر', name_ps: '', name_en: 'Litter cigarette ', slug: 'litter_cigarette',},
                {name_prs: 'بخاری', name_ps: '', name_en: 'Stove', slug: 'stove',},
                {name_prs: 'نمبر کیلومتر', name_ps: '', name_en: 'kilometer number', slug: 'kilometer_number',},
                {name_prs: 'برف پاک', name_ps: '', name_en: 'Windshield wiper', slug: 'windshield_wiper',},
                {name_prs: 'ساعت', name_ps: '', name_en: 'watch', slug: 'watch',},
                {name_prs: 'کلچ', name_ps: '', name_en: 'Kalach', slug: 'kalach',},
                {name_prs: 'برک', name_ps: '', name_en: 'Brake', slug: 'brake',},
                {name_prs: 'امپیر برق', name_ps: '', name_en: 'Electricity ampere', slug: 'electricity_ampere',},
                {name_prs: 'پطرول-دیزل', name_ps: '', name_en: 'Petrol diesel', slug: 'petrol_diesel',},
                {name_prs: 'مبلائیل', name_ps: '', name_en: 'Moblile', slug: 'moblile',},
                {name_prs: 'پیپهای پطرول-دیزل', name_ps: '', name_en: 'Petrol diesel pipe', slug: 'petrol_diesel_pipe',},
                {name_prs: 'وایکم', name_ps: '', name_en: 'Vicom', slug: 'vicom',},
                {name_prs: 'تانکی تیل', name_ps: '', name_en: 'Oil tanki', slug: 'oil_tanki',},
                {name_prs: 'بانت', name_ps: '', name_en: 'Bent', slug: 'bent',},
                {name_prs: 'هند برک', name_ps: '', name_en: 'Hand brake', slug: 'hand_brake',},
                {name_prs: 'سرکلوشن', name_ps: '', name_en: 'Sarkloshan', slug: 'sarkloshan',},
                {name_prs: 'پکه', name_ps: '', name_en: 'Fun', slug: 'fun',},
                {name_prs: 'فین بولت', name_ps: '', name_en: 'Fenbolt', slug: 'fenbolt',},
                {name_prs: 'فرند اکسل', name_ps: '', name_en: 'Friend axle', slug: 'friend_axle',},
                {name_prs: 'سپندلس', name_ps: '', name_en: 'Spindles', slug: 'spindles',},
                {name_prs: 'پکه خورد', name_ps: '', name_en: 'Small fun', slug: 'small_fun',},
                {name_prs: 'آءینه عقب نما', name_ps: '', name_en: 'Rear-view mirror', slug: 'Rear_view_mirror',},
                {name_prs: 'پای پاک', name_ps: '', name_en: 'Shoe cleaner', slug: 'shoe_cleaner',},
                {name_prs: 'جک معه دسته', name_ps: '', name_en: 'Jak maa dasta', slug: 'jak_maa_dasta',},
                {name_prs: 'اندل پایه یک عدد', name_ps: '', name_en: 'Andle paya yak', slug: 'andle_paya_yak',},
                {name_prs: 'پوش های سیت جدید 3', name_ps: '', name_en: 'New set posh', slug: 'new_set_posh',},
                {name_prs: 'مخابره مترولا 1 پایه نصب', name_ps: '',name_en: 'Motorola transmission', slug: 'motorola_transmission',},
                {name_prs: 'جواز سیر', name_ps: '', name_en: 'Jawaz sair', slug: 'jawaz_sair',},
                {name_prs: 'تایرها به شمول اشتپنی', name_ps: '', name_en: 'tiers', slug: 'tiers',},
                {name_prs: 'خاک سلنسر', name_ps: 'سلنسر خاور', name_en: 'salansar', slug: 'salansar',},
                {name_prs: 'متن اولی پرینت فورم سجل', name_ps: 'متن اولی پرینت فورم سجل', name_en: 'First text for sejel print', slug: 'sejel_print_text_1',},
                {name_prs: 'متن دوم پرینت فورم سجل', name_ps: 'متن دوم پرینت فورم سجل', name_en: 'Second text for sejel print', slug: 'sejel_print_text_2',},
            ];
            return items;
        },
        shortCut() {
            const inputs = document.querySelectorAll('input, select,textarea')
            inputs.forEach((input, index) => {
                input.addEventListener('keyup', e => {
                    if (e.keyCode === 13) { // enter key
                        if (index + 1 < inputs.length) {
                            inputs[index + 1].focus()
                        }
                    } else if (e.keyCode === 27) { // escape key
                        if (index - 1 >= 0) {
                            inputs[index - 1].focus()
                        }
                    }
                })
            })
        },
        getItemSpecs(item_id) {
            axios.get('/get_item_spec' + '?item_id=' + item_id).then(res => {
                this.specs = res.data;
            })
        },
        searchSpec() {

        },


}
})

