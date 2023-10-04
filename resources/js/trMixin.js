import { unset } from "lodash";

export default {
    data() {
        return {
            selected_item: null,
            check_item_loader: false,
            isEdit: false,
            disabledBtn: false,
            save_item_loader: false,
            date: null,
            directorate_id: null,
            selected_measure:null,
            unit_of_measures:[],
            table_id: null,
            file: null,
            file_name: '',
            table_name: null,
            item_statuses: [],
            selected_item_status: null,
            attachmentList: [],
            active_tab:'moblin',
            latestFlow: null,
            upload_permission: null,
            showItems:[],
            oilFc9Years: this.fiscalYear(),
            oilFc9Months: this.hijryMonths(),
            //repairing
            repairingItemList:[{
                    selected_item: null,
                    selected_item_status: null,
                    selected_measure: null,
                    quantity: 0,
                    purchase_type: null,
                    specification: null,
            }
            ],
            //  moblin
            itemList: [{
                    selected_item: null,
                    selected_measure: null,
                    measure: null,
                    measure_id: null,
                    spec: null,
                    quantity: 0,
            },

            ],
        //  moblin ,
          moblin:{
              id:null,
              sejel_id:null,
              details_id:null,
              current_kilometer:null,
              previous_kilometer:null,
              description:null,
          },
        repairing:{
            id:null,
            sejel_id:null,
            date: curDate(),
            item_details:null,
            description:null,
            },
        oilFc9Form: {
            sejel_id:null,
            fecen9_number:null,
            year:null,
            month:null,
            item_id: null,
            measure_id: null,
            selected_item: null,
            employee_id: null,
            quantity:null,
            remark:null,
        },
        //driver driver-expenditure
            driverExpenditure:{
                quantity:null,
                description:null,
                unit_measure_id:null,
                fecen5_detail_id:null,
                sejel_id:null,
            }

        }
    },
    methods: {
        //Mobline scripts
        getMoblinRecord(page = this.page) {
            this.active_tab = 'moblin';
            const types = ["unit_of_measures"];
                this.getDropdownItem(types);
            this.showLoading = true;
            this.apiData = {};
            this.url = this.moblinUrl;
            axios.get(this.url
                + '&current_page=' + page
                + '&per_page=' + this.perPage
                + '&sejel_id=' + this.sejel_id)
                .then((response) => {
                    this.showLoading = false
                    if (response.data) {
                        this.page = response.data.current_page;
                    }
                    this.items = response.data.data.items;
                    delete response.data.data.items;
                    this.apiData = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        openModal: function (modal) {
            if (modal == 'moblin') {
                $('#moblin-add-edit-modal').modal('show');
            } else if (modal == 'repairing') {
                $('#repairing-add-edit-modal').modal('show');
            }
            else if(modal =='oilFc9'){
                $('#oil-fc9-add-edit-modal').modal('show');
            }
        },
        // openAttachmentModal(form_name){
        //     $('#attachment-modal').modal('show');
        //     console.log('ssadfajdskf',this.download_permission)
        // },
        itemChanged(item){
            if(item){
                item.spec = null;
            }
        },
        onFileChange(e) {
            this.file = e.target.files[0];
        },
        upload()
        {
            this.uploadAttachments(this.table_name);
        },
        showRepairing(id) {
            $('#show-repairing-modal').modal('show');
            let url ="/repairing/show" + "/" + id
            axios.get(url).then((res) => {
                let data = res.data;
                this.repairing =data.repairing;
                this.latestFlow = this.repairing.flow;
                this.repairingItemList = JSON.parse(this.repairing.item_details)
                this.attachmentList = data.attachments;
            });

        },
        resetMoblin() {
            this.moblin.current_kilometer =null
            this.moblin.previous_kilometer =null
            this.moblin.description =null
            this.isEdit=false;
            this.itemList =[{
                    selected_item: null,
                    item_id: null,
                    selected_measure: null,
                    quantity: 0,
                    spec: null,
            }, ];
        },
        saveMoblinForm() {
            for (let i = 0; i < this.itemList.length; i++) {
                if (this.itemList[i] != null) {
                    this.itemList[i].item_id = this.itemList[i].selected_item?this.itemList[i].selected_item.id:null;
                    this.itemList[i].item_name = this.itemList[i].selected_item?this.itemList[i].selected_item.name:null;
                    this.itemList[i].measure = this.itemList[i].selected_measure?this.itemList[i].selected_measure.name:null;
                    this.itemList[i].measure_id = this.itemList[i].selected_measure?this.itemList[i].selected_measure.id:null;
                }
            }
            // this.save_item_loader = true;
            this.moblin.sejel_id = this.sejel_id;
            const formData = new FormData();
            formData.append("details", JSON.stringify(this.moblin));
            formData.append("items", JSON.stringify(this.itemList))
            axios.post('/moblin/store',formData,{}).then((res) => {
                let response = res.data;
                if (response.status == 200) {
                    this.save_item_loader = false;
                    $('#moblin-add-edit-modal').modal('hide');
                    showMessage(response.message, 'success');
                    this.getMoblinRecord();
                    this.resetMoblin();
                } else {
                    showMessage(response.message, 'warning');
                }
            });
        },
        showMoblin(id) {
            $('#show-moblin-modal').modal('show');
            let url ="/moblin/show" + "/" + id
            axios.get(url).then((res) => {
                let data = res.data;
                this.moblin =data.moblin;
                this.latestFlow = this.moblin.flow;
                this.itemList = JSON.parse(this.moblin.details)
                this.attachmentList = data.attachments;
            });
        },
        editMoblin(id){
            $('#moblin-add-edit-modal').modal('show');
            let url ="/moblin/edit" + "/" + id
            axios.get(url).then((res) => {
                let data = res.data;
                this.moblin =data;
                this.isEdit=true;
                const itemDetails = JSON.parse(data.details)
                this.itemList  = itemDetails;
                for (let i = 0; i <this.itemList.length ; i++) {
                    this.itemList[i].selected_item  = this.items.find(item => item.id === itemDetails[i].item_id);
                    this.itemList[i].selected_measure  = this.unit_of_measures.find(item => item.id === itemDetails[i].measure_id);
                    this.itemList[i].quantity       = itemDetails[i].quantity;
                    this.itemList[i].spec       = itemDetails[i].spec;
                }
            });
        },

        moblinFlow(flow,moblin_id) {
            this.updateFlows('moblin_flows', moblin_id, flow)
        },
        repairingFlow(flow,repairing_id) {
            this.updateFlows('repairing_flows', repairing_id, flow)
        },

        updateMoblinItem() {
            for (let i = 0; i < this.itemList.length; i++) {
                if (this.itemList[i] != null) {
                    this.itemList[i].item_id   = this.itemList[i].selected_item?this.itemList[i].selected_item.id:null;
                    this.itemList[i].item_name = this.itemList[i].selected_item?this.itemList[i].selected_item.name:null;
                    this.itemList[i].measure   = this.itemList[i].selected_measure?this.itemList[i].selected_measure.name:null;
                    this.itemList[i].measure_id   = this.itemList[i].selected_measure?this.itemList[i].selected_measure.id:null;
                }
            }
            // this.save_item_loader = true;
            this.moblin.sejel_id = this.sejel_id;
            this.moblin.items  = this.itemList;
            let url = "/moblin/update" + "/" + this.moblin.id
            axios.patch(url, this.moblin).then((res) => {
                let response = res.data;
                if (response.status == 200) {
                    this.save_item_loader = false;
                    $('#moblin-add-edit-modal').modal('hide');
                    showMessage(response.message, 'success');
                    this.resetMoblin();
                    this.isEdit = false;
                } else {
                    this.save_item_loader = false;
                    showMessage(response.message, 'warning');
                }
            });
        },

        deleteMoblin(id) {
            deleteItem("/moblin" + "/" + id,this.getMoblinRecord);
        },
        addRow(index) {
            this.itemList.push({
                selected_item: null,
                selected_measure: null,
                measure: null,
                measure_id: null,
                spec: null,
                quantity: 0,
            });
        },
        addRepairingRow(index) {
            this.repairingItemList.push({
                    selected_item: null,
                    selected_item_status: null,
                    selected_measure: null,
                    quantity: 0,
                    purchase_type: null,
                    specification: null,
            });
        },
        deleteItem(index,form) {
            if(form && form =='moblin'){
                if (this.itemList.length - 1 > 0) this.itemList.splice(index, 1);
            }
            else{
                if (this.repairingItemList.length - 1 > 0) this.repairingItemList.splice(index, 1);
            }
        },
        // Naim Code Start
        getRepairingRecord(page = this.page) {
            const types = ["vehicle-parts", "item_statuses"];
            this.active_tab = 'repairing';
            this.getDropdownItem(types);
            this.showLoading = true;
            this.apiData = {};
            this.url = this.repairingUrl;
                axios.get(this.url
                + '&current_page=' + page
                + '&per_page=' + this.perPage
                + '&sejel_id=' + this.sejel_id)
                .then((response) => {
                    this.showLoading = false
                    if (response.data) {
                        this.page = response.data.current_page;
                    }
                    this.apiData = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        saveRepairingForm() {
            for (let i = 0; i < this.repairingItemList.length; i++) {
                if (this.repairingItemList[i] != null) {
                    this.repairingItemList[i].item_status_id = this.repairingItemList[i].selected_item_status?this.repairingItemList[i].selected_item_status.id:null;
                    this.repairingItemList[i].item_status    = this.repairingItemList[i].selected_item_status?this.repairingItemList[i].selected_item_status.name:null;
                    this.repairingItemList[i].item_id        = this.repairingItemList[i].selected_item?this.repairingItemList[i].selected_item.item_id:null;
                    this.repairingItemList[i].item_name      = this.repairingItemList[i].selected_item?this.repairingItemList[i].selected_item.name:null;
                    this.repairingItemList[i].measure        = this.repairingItemList[i].selected_measure?this.repairingItemList[i].selected_measure.name:null;
                    this.repairingItemList[i].measure_id     = this.repairingItemList[i].selected_measure?this.repairingItemList[i].selected_measure.id:null;
                }
            }
            this.save_item_loader = true;
            this.repairing.sejel_id = this.sejel_id;
            this.repairing.item_details = this.repairingItemList;
            const formData = new FormData();
            formData.append("item_details", JSON.stringify(this.repairing));
            formData.append("items", JSON.stringify(this.repairingItemList))
            axios.post('/repairing/store',this.repairing,{}).then((res) => {
                let response = res.data;
                if (response.status == 200) {
                    this.save_item_loader = false;
                    $('#repairing-add-edit-modal').modal('hide');
                    showMessage(response.message, 'success');
                    this.getRepairingRecord();
                    this.resetRepairing();
                } else {
                    showMessage(response.message, 'warning');
                }
            });
        },
        resetRepairing() {
            // this.repairing.date =null
            this.repairing.description =null
            this.repairing.date =null
            this.repairingItemList =[{
                selected_item: null,
                selected_item_status: null,
                selected_measure: null,
                specification: null,
                purchase_type: null,
                quantity: 0
            }, ];
        },
        editRepairingForm(id){
            $('#repairing-add-edit-modal').modal('show');
            let url ="/repairing/edit" + "/" + id
            axios.get(url).then((res) => {
                let data = res.data;
                this.repairing =data;
                this.isEdit=true;
                const itemDetails = JSON.parse(data.item_details)
                this.repairingItemList  = itemDetails;
                for (let i = 0; i <this.repairingItemList.length ; i++) {
                    this.repairingItemList[i].selected_item  = this.items.find(item => item.item_id === itemDetails[i].item_id);
                    this.repairingItemList[i].selected_item_status  = this.item_statuses.find(item => item.id === itemDetails[i].item_status_id);
                    this.repairingItemList[i].selected_measure  = this.unit_of_measures.find(item => item.id === itemDetails[i].measure_id);
                    this.repairingItemList[i].quantity       = itemDetails[i].quantity;
                    if (this.repairingItemList[i].selected_item == null) {
                        let url ="/find"+'?table=' + 'items' + '&id=' + itemDetails[i].item_id;
                        axios.get(url
                        ).then((response) => {
                            this.repairingItemList[i].selected_item = response.data;
                        })
                    }
                }
            });
        },
        updateRepairingForm() {
            for (let i = 0; i < this.repairingItemList.length; i++) {
                if (this.repairingItemList[i] != null) {
                    this.repairingItemList[i].item_status_id = this.repairingItemList[i].selected_item_status?this.repairingItemList[i].selected_item_status.id:null;
                    this.repairingItemList[i].item_status    = this.repairingItemList[i].selected_item_status?this.repairingItemList[i].selected_item_status.name:null;
                    this.repairingItemList[i].item_id        = this.repairingItemList[i].selected_item?this.repairingItemList[i].selected_item.item_id:null;
                    this.repairingItemList[i].item_name      = this.repairingItemList[i].selected_item?this.repairingItemList[i].selected_item.name:null;
                    this.repairingItemList[i].measure        = this.repairingItemList[i].selected_measure?this.repairingItemList[i].selected_measure.name:null;
                    this.repairingItemList[i].measure_id     = this.repairingItemList[i].selected_measure?this.repairingItemList[i].selected_measure.id:null;
                }
            }
            // this.save_item_loader = true;
            this.repairing.sejel_id = this.sejel_id;
            this.repairing.item_details = this.repairingItemList;
            let url = "/repairing/update" + "/" + this.repairing.id
            axios.patch(url, this.repairing).then((res) => {
                let response = res.data;
                if (response.status == 200) {
                    this.save_item_loader = false;
                    $('#repairing-add-edit-modal').modal('hide');
                    showMessage(response.message, 'success');
                    this.resetRepairing();
                    this.isEdit = false;
                } else {
                    this.save_item_loader = false;
                    showMessage(response.message, 'warning');
                }
            });
        },
        deleteRepairing(id) {
            deleteItem("/repairing" + "/" + id,this.getRepairingRecord);
        },

        //    Repairing scripts
        // Oil fc9 scripts
        getOilFc9Record(page = this.page) {
            this.active_tab = 'oil_fc9';
            const types = ["oil"];
            this.getDropdownItem(types);
            // this.showLoading = true;
            this.url =this.oilFc9Url
            this.apiData = {};
            axios.get(this.url
                + '&sejel_id=' + this.sejel_id
                + '&current_page=' + page
                + '&per_page=' + this.perPage)
                .then((response) => {
                    this.showLoading = false
                    if (response.data) {
                        this.page = response.data.current_page;
                    }
                    this.apiData = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        saveOilFc9 () {
            this.save_item_loader = true;
            this.oilFc9Form.item_id = this.oilFc9Form.selected_item && this.oilFc9Form.selected_item.item_id;
            this.oilFc9Form.measure_id = this.oilFc9Form.selected_item && this.oilFc9Form.selected_item.measure_id;
            this.oilFc9Form.sejel_id = this.sejel_id;
            this.oilFc9Form.employee_id = this.driver_id;
            axios.post('/oilFc9/store', this.oilFc9Form).then((res) => {
                let response = res.data;
                if (response.status == 200) {
                    this.save_item_loader = false;
                    showMessage(response.message, 'success');
                    $('#oil-fc9-add-edit-modal').modal('hide');
                    this.getOilFc9Record();
                    this.resetOilFc9();
                } else {
                    this.save_item_loader = false;
                    showMessage(response.message, 'warning');
                }

            });
        },
        resetOilFc9 () {
            this.oilFc9Form.fecen9_number = null,
            this.oilFc9Form.sejel_id = null,
            this.oilFc9Form.year = null,
            this.oilFc9Form.month = null,
            this.oilFc9Form.item_id =  null,
            this.oilFc9Form.measure_id =  null,
            this.oilFc9Form.selected_item =  null,
            this.oilFc9Form.employee_id =  null,
            this.oilFc9Form.quantity = null,
            this.oilFc9Form.remark = null
        },
        showOilFc9 () {
            $('#show-oil-fc9-modal').modal('show');
        },
        deleteOilFc9Record(id = null) {
            deleteItem(`oilFc9/${id}`);
        },
        editOilFc9 () {
            $('#oil-fc9-add-edit-modal').modal('show');
        },
        updateOilFc9() {

        },
    //    driver expenditure codes
    // checkItemQty(e)
    // {
    //     let qty  = e.target.value;
    //     if(this.selected_spec && qty>Number(this.selected_spec.on_hand)){
    //         this.overFlowQty = true;
    //         this.item_disable  = true;
    //     }
    //     else{
    //         this.overFlowQty = false;
    //         this.item_disable  = false;
    //     }
    // },
        getDriverExpenditureRecord(page = this.page) {
            this.showLoading = true;
            this.active_tab = 'driver_expenditure';
            this.url =this.driverExpenditureUrl;
            this.apiData = {};
            axios.get(this.url
                + '&sejel_id=' + this.sejel_id
                + '&current_page=' + page
                + '&per_page=' + this.perPage)
                .then((response) => {
                    this.showLoading = false
                    if (response.data) {
                        this.page = response.data.current_page;
                    }
                    this.apiData = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        openCreateModal: function(fc5_id,consumed,distributed) {
            this.driverExpenditure.fecen5_detail_id = fc5_id;
            this.driverExpenditure.quantity = consumed;
            this.getDropdownItem(['unit_of_measures']);
            if(consumed>distributed){
                this.disabledBtn =true;
            }
            console.log('this is consumed',this.disabledBtn)

            this.selected_measure  = this.unit_of_measures.find(item => item.name === 'لیتر');
            $('#driver-expenditure').modal('show');
        },
        saveDriverExpenditure () {
            this.save_item_loader = true;
            this.driverExpenditure.sejel_id = this.sejel_id;
            this.driverExpenditure.unit_measure_id = this.selected_measure?this.selected_measure.id:null;
            axios.post('/driver_expenditure/store', this.driverExpenditure).then((res) => {
                let response = res.data;
                if (response.status == 200) {
                    this.save_item_loader = false;
                    showMessage(response.message, 'success');
                    $('#driver-expenditure').modal('hide');
                    this.getDriverExpenditureRecord();
                    this.resetDriverExpenditure();
                } else {
                    this.save_item_loader = false;
                    showMessage(response.message, 'warning');
                }

            });
        },
        resetDriverExpenditure(){
            this.driverExpenditure.quantity = 0;
            this.driverExpenditure.description = '';
        }
    }
}
