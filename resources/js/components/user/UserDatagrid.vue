<template>
    <Layout style="width:100%;height:auto;">
        <LayoutPanel region="west" title="West" :collapsible="true" :collapsed="true" :expander="true" style="width:120px;">
            <p>West Region</p>
        </LayoutPanel>
        <LayoutPanel region="center" title="DATA USERS" style="height:100%;">
            <div class="row" style="margin:4px;">
                <div class="col-lg-3">
                    <Panel :bodyStyle="{padding:'5px'}" :border="false">
                        <ButtonGroup selectionMode="single">
                            <LinkButton iconCls="icon-add" :toggle="true" @click="openAdd_dialogInParent()">Add</LinkButton>
                            <LinkButton iconCls="icon-edit" :toggle="true" @click="openEdit_dialogInParent(selection)">Edit</LinkButton>
                            <LinkButton iconCls="icon-remove" :toggle="true">Remove</LinkButton>
                            <!-- <LinkButton iconCls="icon-save" :toggle="true">Save</LinkButton> -->
                            <!-- <LinkButton iconCls="icon-cut" :disabled="true">Cut</LinkButton> -->
                        </ButtonGroup>
                    </Panel>
                </div>
                <div class="col-lg-9">
                    <Panel :bodyStyle="{padding:'5px'}" :border="false">
                        <!-- <ComboBox placeholder="- Choose selection mode -" style="width:210px"
                            v-model="selectionMode" 
                            :data="selectionOptions" 
                            :editable="false"
                            :panelStyle="{height:'auto'}"
                            @valueChange="selection=null">
                        </ComboBox> -->
                        <div style="float:right">
                            <SearchBox style="width:300px"
                                placeholder="Search Everything ..." 
                                v-model="search"
                                @search="onSearch($event)">
                                <Addon>
                                    <span v-if="search" class="textbox-icon icon-clear" title="Clear value" @click="search=null"></span>
                                </Addon>
                            </SearchBox>
                            <ButtonGroup selectionMode="single">
                                <LinkButton iconCls="icon-reload" :toggle="true">Reset</LinkButton>
                                <LinkButton iconCls="icon-filter" :toggle="true">Filter</LinkButton>
                            </ButtonGroup>
                        </div>
                    </Panel>
                </div>
            </div>
            <DataGrid style="height:250px; margin:20px; margin-top:0"
                    :pagination="true"
                    :lazy="true"
                    :data="data"
                    :total="total"
                    :loading="loading"
                    :columnResizing="true"
                    :columnMoving="true"
                    :pageNumber="pageNumber"
                    :pageSize="pageSize"
                    :pagePosition="pagePosition"
                    :selectionMode="selectionMode"
                    @selectionChange="selection=$event"
                    @pageChange="onPageChange($event)">
                <GridColumn field="f_id" title="ID" width="80" align="center"></GridColumn>
                <GridColumn field="f_fullname" title="Full Name"></GridColumn>
                <GridColumn field="f_dob" title="Dob"></GridColumn>
                <GridColumn field="f_age" title="Age" align="center"></GridColumn>
                <GridColumn field="f_address" title="Address"></GridColumn>
                <GridColumn field="f_username" title="Username"></GridColumn>
                <GridColumn field="f_password" title="Password"></GridColumn>
            </DataGrid>
            <div class="text-center mt-2">
                <p v-if="selection">You selected: {{selectionInfo}}</p>
                <p>You are searching: {{search}}</p>
            </div>
        </LayoutPanel>
    </Layout>
</template>

<script>
    export default {
        data() {
            return {
                total: 0,
                pageNumber: 1,
                pageSize: 10,
                // pageLayout: ['first','prev','next','last','info'],
                data: [],
                loading: false,
                pagePosition: "bottom",
                // selectionOptions: [
                //     { value: null, text: "None" },
                //     { value: "single", text: "Single Selection"},
                //     { value: "multiple", text: "Multiple Selection" }
                // ],
                selectionMode: 'single',
                selection: null,
                search: null,
                params: [],
            }
        },
        computed: {
            selectionInfo() {
                if (!this.selection) {
                    return null;
                }
                if (this.selectionMode == "single") {
                    return this.selection.id;
                } else if (this.selectionMode == "multiple") {
                    return this.selection.map(function(row){return row.id}).join(",");
                }
            },
            disabled() {
                return !this.enabled;
            },
        },
        mounted() {
            this.params.push({
                pageNumber: this.pageNumber,
                pageSize: this.pageSize,
                search: this.search,
            })
        },
        created() {
            this.loadPage();
        },
        methods: {
            onPageChange(event) {
                this.loadPage();
                this.data
            },
            loadPage() {
                this.loading = true;
                setTimeout(() => {
                    let result = this.getData();
                    this.total = result.total;
                    this.pageNumber = result.pageNumber;
                    this.data = result.rows;
                    this.loading = false;
                }, 1000);
            },
            onSearch(event) {
                this.params = [];
                this.search = event.value;
                this.params.push({
                    pageNumber: this.pageNumber,
                    pageSize: this.pageSize,
                    search: this.search,
                })
                this.loadPage();
            },
            getData() {
                let param = this.params;
                axios
                    .get('http://127.0.0.1:8000/api/users/'+JSON.stringify({page: param[0].pageNumber, rows: param[0].pageSize, srcvt: param[0].search}))
                    .then(response => {
                        this.total = response.data.total;
                        this.data = response.data.rows;
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
                return {
                    total: this.total,
                    pageNumber: param[0].pageNumber,
                    pageSize: param[0].pageSize,
                    rows: this.data
                };
            },
            openAdd_dialogInParent() {
                this.$root.$refs.add.openAddDialog();
            },
            openEdit_dialogInParent(selection) {
                if (selection) {
                    this.$root.$refs.edit.openEditDialog();
                } else {
                    this.$messager.alert({
                        title: "Warning",
                        icon: "warning",
                        msg: "Please, select one data before edit this !"
                    });
                }
            }
        }
    }
</script>