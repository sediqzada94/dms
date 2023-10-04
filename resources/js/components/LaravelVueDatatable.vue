<template>
            <!--begin datatable  -->
            <div class="row pb-1 mt-5 ">
                <div class="col-md-4 mb-3">
                        <div class="form-floating" v-if="!totalRecord">
                            <label for="show" class="label">{{search}} &nbsp</label>
                            <input v-model="filter" @input="getData"  type="text" class="form-control"
                            :placeholder=searchPlaceholderText aria-controls="datatable">
                        </div>

                <!--     <div class="form-group" v-if="totalRecord">
                       <label for="show">show &nbsp</label>
                        <button type="button" @click="deleteSelectedRecord()" class="btn btn-danger  btn-sm waves-effect waves-light">Delete {{totalRecord}} record <i style="color: white" class="mdi mdi-delete"></i> </button>
                    </div> -->

                </div>
                <div class="col-md-4 form-inline mb-3">
                    <div class="form-floating">
                    <label for="show" class="label">{{perPageText}} &nbsp</label>
                        <select name="datatable_length" aria-controls="datatable"
                                class="form-control form-control-sm" id="show" v-model="userDataPerPage"
                                @change="perPageChange()" style="">
                            <option v-for="item in appPerPage" :key="item" :value="item"> {{item}}</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive table-style">
                    <table id="tech-companies-1" class="table align-middle mb-0">
                    <slot name="thead">
                        <thead class="table-light">
                        <tr>
                            <th  v-if="multipleSelect && multipleSelect==true">
                                <div class="form-check">
                                <input type="checkbox" class="form-check-input"  @click="toggleSelectAll" value="true" v-model="selectAll" id="selectall">
                                <label for="selectall" class="">Select All
                                </label>
                                </div>
<!--                                <button class="btn btn-danger" >Delete Selected</button>-->
                            </th>
                            <th v-for="(col,index) in columns" :key="index"
                                @click="sort(index)"
                                :style="{cursor:(col.sort===true)?'pointer':'','white-space':(col.sort===true)?'nowrap':'wrap'}">
                                <template v-if="col.sort===true">
                                    <i class="bx bx-chevron-down"
                                       :style="{color:(getColumnSortClass(index).direction==='asc' && activeSortColumn===col.name)?'#DC4322':'#c2c2a3'}"
                                       style="margin-right:-1.5px;margin-left:-1.5px;"></i>
                                    <i class=" bx bx-chevron-up"
                                       :style="{color:(getColumnSortClass(index).direction==='desc' && activeSortColumn===col.name)?'#DC4322':'#c2c2a3'}"
                                       style="margin-right:-1.5px;margin-left:-1.5px;"></i>
                                </template>

                                {{col.label}}
                            </th>
                        </tr>
                        </thead>
                        <template v-if="data.total !=undefined">
                            <template id="no_record_found_text" v-if="data.total<1">
                                <tbody>
                                <tr>
                                    <td :colspan="columns.length">
                                        {{noRecordFoundText}}
                                    </td>
                                </tr>
                                </tbody>
                            </template>
                        </template>
                    </slot>
                    <slot name="tbody">
                        <tbody>
                        <tr>
                            <td>asdf</td>
                        </tr>
                        </tbody>
                    </slot>
                </table>
                </div>

                <!--end  datatable  -->
                <div class="col-md-12">
                    <div class="col-md-8">
                        <table style="border-spacing: 10px;border-collapse: separate;">
                            <tr>
                                <td>
                                    <renderless-laravel-vue-pagination :data="data" :limit="limit"
                                        :show-disabled="showDisabled" :size="size"
                                        :align="align"
                                        v-on:pagination-change-page="onPaginationChangePage">
                                        <ul class="pagination" :class="{
                                    'pagination-sm': size == 'small',
                                    'pagination-lg': size == 'large',
                                    'justify-content-center': align == 'center',
                                    'justify-content-end': align == 'right'
                                }" v-if="computed.total > computed.perPage"
                                            slot-scope="{ data, limit, showDisabled, size, align, computed, prevButtonEvents, nextButtonEvents, pageButtonEvents }">

                                            <li class="page-item pagination-prev-nav"
                                                :class="{'disabled': !computed.prevPageUrl}"
                                                v-if="computed.prevPageUrl || showDisabled">
                                                <a class="page-link" href="#" aria-label="Previous"
                                                   :tabindex="!computed.prevPageUrl && -1" v-on="prevButtonEvents">
                                                    <slot name="prev-nav">
                                                        <span aria-hidden="true">&laquo;</span>
                                                        <span class="sr-only">{{previous}} &nbsp</span>
                                                    </slot>
                                                </a>
                                            </li>

                                            <li class="page-item pagination-page-nav"
                                                v-for="(page, key) in computed.pageRange" :key="key"
                                                :class="{ 'active': page == computed.currentPage }">
                                                <a class="page-link" href="#" v-on="pageButtonEvents(page)">
                                                    {{ page }}
                                                    <span class="sr-only"
                                                          v-if="page == computed.currentPage">({{current}} &nbsp)</span>
                                                </a>
                                            </li>

                                            <li class="page-item pagination-next-nav"
                                                :class="{'disabled': !computed.nextPageUrl}"
                                                v-if="computed.nextPageUrl || showDisabled">
                                                <a class="page-link" href="#" aria-label="Next"
                                                   :tabindex="!computed.nextPageUrl && -1" v-on="nextButtonEvents">
                                                    <slot name="next-nav">
                                                        <span aria-hidden="true">&raquo;</span>
                                                        <span class="sr-only">{{next}} &nbsp</span>
                                                    </slot>
                                                </a>
                                            </li>

                                        </ul>
                                    </renderless-laravel-vue-pagination>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--                <div class="col-md-4" id="pagination_count_element" style="margin-top:8px;">-->
                    <!--                        <div>-->
                    <!--                            <span id="pagination_showing_text">{{showingText}}</span>-->
                    <!--                            {{(data.from)?data.from:0}}-->
                    <!--                            <span id="pagination_to_text">{{toText}}</span>-->
                    <!--                            {{(data.to)?data.to:0}}-->
                    <!--                            <span id="pagination_from_text">{{fromText}}</span>-->
                    <!--                            {{data.total}}-->
                    <!--                            <span id="pagination_record_text">{{recordText}}</span>-->
                    <!--                        </div>-->
                    <!--                </div>-->
                </div>
                </div>
</template>

<script>

    import RenderlessLaravelVuePagination from '../pagination/RenderlessLaravelVuePagination.vue';

    export default {
        props: {
            noRecordFoundText: {
                type: String,
                default: '',
            },
            search: {
               type: String,
               default: '',
            },
            searchPlaceholderText: {
               type: String,
               default: '',
            },
            current: {
                type: String,
                default: 'current',
            },
            next: {
                type: String,
                default: 'next',
            },
            previous: {
                type: String,
                default: 'previous',
            },
            perPageText: {
                type: String,
                default: 'Item per page',
            },
            showingText: {
                type: String,
                default: '',
            },
            fromText: {
                type: String,
                default: 'From',
            },
            toText: {
                type: String,
                default: 'To',
            },
            recordText: {
                type: String,
                default: 'Record',
            },
            perPage: {
                type: Number,
                default: 1
            },
            appPerPage: {
                type: Array,
                default: () => [5, 10, 20, 50, 100, 500]
            },
            columns: {
                type: Array,
                default: () => []
            },
            data: {
                type: Object,
                default: () => {
                }
            },
            limit: {
                type: Number,
                default: 0
            },
            showDisabled: {
                type: Boolean,
                default: false
            },
            size: {
                type: String,
                default: 'default',
                validator: value => {
                    return ['small', 'default', 'large'].indexOf(value) !== -1;
                }
            },
            align: {
                type: String,
                default: 'left',
                validator: value => {
                    return ['left', 'center', 'right'].indexOf(value) !== -1;
                }
            },
            multipleSelect: {
                type: Boolean,
                default: false
            },
            selectedRows: {
                type: Array,
                default: () => []
            },


        },
        data() {
            return {
                filter: '',
                activeSortColumn: '',
                activeSortDirection: '',
                // dataPerPage: 10,
                userDataPerPage: 10,
                current_page: 1,
                selectAll:false,
            }
        },
        computed: {

            totalRecord() {
                let total=0;
                if(this.selectedRows)
                {
                   total=this.selectedRows.length;
                }
                if(total==0)
                {
                    this.selectAll=false;
                }
                return total;

            },
            dataPerPage(){
                return this.userDataPerPage
            }
        },
        mounted() {
            this.userDataPerPage = this.perPage;
            for (var i = 0; i < this.columns.length; i++) {
                if (this.columns[i].sort === true && this.columns[i].activeSort != undefined) {
                    if (this.columns[i].activeSort === true) {
                        this.activeSortColumn = this.columns[i].name;
                        this.activeSortDirection = this.columns[i].order_direction;
                        break;
                    }
                }

            }
            this.setUrl();

        },

        methods: {
            //
            deleteSelectedRecord()
            {
                this.selectAll=!this.selectAll;
                this.$emit('delete-method-action',null);

                // this.$parent.deleteMethodName(3434);
            },
            toggleSelectAll(event) {
                this.selectAll=!this.selectAll;
                this.$parent.selectedRows//


                if(this.selectAll)
                {
                    if(this.data && this.data.data)
                    {
                        for (let i = 0; i <this.data.data.length ; i++)
                        {
                            this.$parent.selectedRows.push(this.data.data[i].id)
                        }

                    }

                }
                else
                {
                    this.$parent.selectedRows=[];
                }


            },
            getData() {
                this.setUrl();
            },
            perPageChange() {
                this.setUrl();
            },
            onPaginationChangePage(page) {
                this.current_page = page;
                this.$emit('pagination-change-page', page);
            },
            onSortChange(page) {
                this.$emit('sort-change', page, activeSortDirection);
            },
            //return colum sort direction default is ascending
            getColumnSortClass(index) {
                let dir = '';
                if (this.columns[index] != undefined) {

                    if (this.columns[index].sort != undefined && this.columns[index].sort === true) {
                        dir = 'asc';
                        if (this.columns[index].order_direction != undefined) {
                            dir = this.columns[index].order_direction.toLowerCase();

                        }

                        if (this.columns[index].name === this.activeSortColumn) {
                            if (dir === 'desc') {

                            } else if (dir === 'asc') {

                            } else {

                            }
                        }
                    }
                }
                return {direction: dir};
            },
            // sort columns
            sort(index, reload = true) {
                let color = '#7a7a52';
                let dir = '';
                if (this.columns[index] != undefined && this.columns[index].sort === true) {

                    color = '#99c2ff';
                    if (this.columns[index].name === this.activeSortColumn) {
                        dir = this.activeSortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.activeSortColumn = this.columns[index].name;
                        dir = 'asc';
                        if (this.columns[index].order_direction != undefined) {
                            dir = this.columns[index].order_direction.toLowerCase();
                        }
                    }
                    this.activeSortDirection = dir;
                    this.columns[index].order_direction = dir;

                    if (reload === true) {
                        this.setUrl();
                    }
                } else {
                    this.activeSortColumn = '';
                    this.activeSortDirection = '';
                }

                return {color: color, direction: dir};

            },

            setUrl(sendRequest = true) {
                let url = this.$parent.url;
                this.$parent.perPage = this.userDataPerPage;
                if (this.activeSortColumn != '' && this.activeSortColumn != undefined &&
                    this.activeSortDirection != undefined && this.activeSortDirection != '') {
                    if (url.search('&order_direction') === -1) {

                        let tempUrl = this.$parent.url + 'order_by=' + this.activeSortColumn + '&order_direction=' + this.activeSortDirection;

                        if (this.dataPerPage > 0) {
                            tempUrl = this.$parent.url + 'order_by=' + this.activeSortColumn + '&per_page=' + this.dataPerPage + '&order_direction=' + this.activeSortDirection;
                            ;

                        }
                        tempUrl = tempUrl + "&search_keyword=" + this.filter;
                        this.$parent.url = tempUrl;
                    } else {
                        let order_direction = '&order_direction';
                        let toLenght = url.search('&order_direction');
                        let newUrlPortion = url.slice(0, Number(toLenght) + Number(order_direction.length));
                        let sortCheck = url.slice(Number(newUrlPortion.length) + 1);
                        let temp = url.slice(0, url.search('order_by'));
                        let newUrl = 'order_by=' + this.activeSortColumn + '&order_direction=' + this.activeSortDirection;
                        if (this.dataPerPage > 0) {
                            newUrl = 'order_by=' + this.activeSortColumn + '&per_page=' + this.dataPerPage + '&order_direction=' + this.activeSortDirection;
                        }
                        newUrl = newUrl + "&search_keyword=" + this.filter;
                        this.$parent.url = temp + newUrl;
                    }
                }
                if (sendRequest) {
                    this.$emit('pagination-change-page', this.page);
                }
            }
        },

        components: {
            RenderlessLaravelVuePagination
        }
    }
</script>
<style>
  .form-floating>.form-control::placeholder {
	color: #000!important
}
</style>


