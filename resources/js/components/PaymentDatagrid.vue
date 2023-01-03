<template>
    <Layout style="width:100%;height:auto;">
        <LayoutPanel region="west" title="West" :collapsible="true" :collapsed="true" :expander="true" style="width:120px;">
            <p>West Region</p>
        </LayoutPanel>
        <LayoutPanel region="center" title="Center" style="height:100%;">
            <div class="row" style="margin:5px;">
                <div class="col-lg-3">
                    <Panel :bodyStyle="{padding:'5px'}" :border="false">
                        <SplitButton text="Actions" :plain="true" iconCls="icon-folsy" :disabled="disabled">
                            <Menu>
                                <MenuItem text="Undo" iconCls="icon-undo"></MenuItem>
                                <MenuItem text="Redo" iconCls="icon-redo"></MenuItem>
                                <MenuSep></MenuSep>
                                <MenuItem text="Cut"></MenuItem>
                                <MenuItem text="Copy"></MenuItem>
                                <MenuItem text="Paste"></MenuItem>
                                <MenuSep></MenuSep>
                                <MenuItem text="Toolbar">
                                    <SubMenu>
                                        <MenuItem text="Address"></MenuItem>
                                        <MenuItem text="Link"></MenuItem>
                                        <MenuItem text="Navigation Toolbar"></MenuItem>
                                        <MenuItem text="Bookmark Toolbar"></MenuItem>
                                        <MenuSep></MenuSep>
                                        <MenuItem text="New Toolbar..."></MenuItem>
                                    </SubMenu>
                                </MenuItem>
                                <MenuItem text="Delete" iconCls="icon-remove"></MenuItem>
                                <MenuItem text="Select All"></MenuItem>
                            </Menu>
                        </SplitButton>
                        <SwitchButton v-model="enabled" onText="Enabled" offText="Disabled" style="width:100px;margin-left:15px"></SwitchButton>
                    </Panel>
                </div>
                <div class="col-lg-9">
                    <Panel :bodyStyle="{padding:'5px'}" :border="false">
                        <ComboBox placeholder="- Choose selection mode -" style="width:210px"
                            v-model="selectionMode" 
                            :data="selectionOptions" 
                            :editable="false"
                            :panelStyle="{height:'auto'}"
                            @valueChange="selection=null">
                        </ComboBox>
                        <div style="float:right">
                            <SearchBox style="width:300px"
                                placeholder="Search Everything ..." 
                                v-model="search"
                                @search="onSearch($event)">
                                <Addon>
                                    <span v-if="search" class="textbox-icon icon-clear" title="Clear value" @click="search=null"></span>
                                </Addon>
                            </SearchBox>
                        </div>
                    </Panel>
                </div>
            </div>
            <DataGrid style="height:250px"
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
                <GridColumn field="id" title="ID" width="80" align="center"></GridColumn>
                <GridColumn field="FC_BRANCH" title="FC BRANCH"></GridColumn>
                <GridColumn field="created_at" title="CREATED AT"></GridColumn>
                <GridColumn field="update_at" title="UPDATE AT"></GridColumn>
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
                pageSize: 20,
                // pageLayout: ['first','prev','next','last','info'],
                data: [],
                loading: false,
                pagePosition: "bottom",
                selectionOptions: [
                    { value: null, text: "None" },
                    { value: "single", text: "Single Selection" },
                    { value: "multiple", text: "Multiple Selection" }
                ],
                selectionMode: null,
                selection: null,
                enabled: true,
                search: null,
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
            }
        },
        created() {
            this.loadPage(this.pageNumber, this.pageSize);
        },
        methods: {
            onPageChange(event) {
                this.loadPage(event.pageNumber, event.pageSize);
                this.data
            },
            loadPage(pageNumber, pageSize) {
                this.loading = true;
                setTimeout(() => {
                    let result = this.getData(pageNumber, pageSize);
                    this.total = result.total;
                    this.pageNumber = result.pageNumber;
                    this.data = result.rows;
                    this.loading = false;
                }, 1000);
            },
            getData(pageNumber, pageSize) {
                axios
                    .get('http://127.0.0.1:8000/api/payments')
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
                    pageNumber: pageNumber,
                    pageSize: pageSize,
                    rows: this.data
                };
            }
        }
    }
</script>