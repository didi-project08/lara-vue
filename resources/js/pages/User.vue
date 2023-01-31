<template>
    <main>
        <div class="py-5 container">
            <div class="row text-center py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                  <h1 class="fw-light">User Page</h1>
                  <p class="lead text-muted">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h3>User List</h3>
                    <user-datagrid-component></user-datagrid-component>
                </div>
            </div>
        </div>
        <Dialog ref="add"
            :title="'Add Dialog'"
            :dialogStyle="{width:'500px',height:'500px'}"
            :modal="true"
            :draggable="true"
            :resizable="true">
            <addview-user-component></addview-user-component>
            <div slot="footer">
                <ButtonGroup style="width:100%;height:50px">
                    <LinkButton class="f-full" :plain="true" iconCls="icon-back" btnCls="mybtn" @click="closeAddDialog()"><b>Cancel</b></LinkButton>
                    <LinkButton class="f-full" :plain="true" iconCls="icon-save" btnCls="mybtn"><b>Save</b></LinkButton>
                </ButtonGroup>
            </div>
        </Dialog>
        <Dialog ref="edit" 
            :title="'Edit Dialog'"
            :dialogStyle="{width:'500px',height:'500px'}"
            :modal="true"
            :draggable="true"
            :resizable="true">
            <editview-user-component></editview-user-component>
            <div slot="footer">
                <ButtonGroup style="width:100%;height:50px">
                    <LinkButton class="f-full" :plain="true" iconCls="icon-back" btnCls="mybtn" @click="closeEditDialog()"><b>Cancel</b></LinkButton>
                    <LinkButton class="f-full" :plain="true" iconCls="icon-save" btnCls="mybtn"><b>Update</b></LinkButton>
                </ButtonGroup>
            </div>
        </Dialog>
    </main>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        mounted() {
            this.$refs.add.close();
            this.$refs.edit.close();
        },
        created() {
            this.$root.$refs.add = this;
            this.$root.$refs.edit = this;
        },
        methods: {
            openAddDialog() {
                this.$refs.add.center();
                this.$refs.add.open();
            },
            openEditDialog() {
                this.$refs.edit.center();
                this.$refs.edit.open();
            },
            closeAddDialog() {
                this.$refs.add.close();
            },
            closeEditDialog() {
                this.$refs.edit.close();
            },
        }
    }
</script>