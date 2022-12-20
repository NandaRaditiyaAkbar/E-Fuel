<template>
    <div class="main-page">
        <template v-if="showHeader">
            <q-card  :flat="isSubPage" class="page-section q-py-sm q-px-md q-mb-md nice-shadow-6" >
                <div class="container-fluid">
                    <div class="row justify-between q-col-gutter-md">
                        <div class="col-12 col-md-auto " >
                            <div class=" text-h6 text-primary" >
                                Model Has Roles
                            </div>
                        </div>
                        <div class="col-md-auto col-12 " >
                            <template v-if="auth.canView('/model_has_roles/add')">
                                <q-btn       :rounded="false"  size=""  color="primary" no-caps  unelevated   @click="app.openPageDialog({ page: 'model_has_roles/add', url: `/model_has_roles/add` , closeBtn: true  })"  class="full-width" >
                                    <q-icon name="add"></q-icon>                                
                                    Add New Model Has Roles 
                                </q-btn>
                            </template>
                        </div>
                        <div class="col-md-auto col-12 " >
                            <q-input debounce="1000" outlined dense  placeholder="Search" v-model="searchText" >
                            <template v-slot:append>
                                <q-icon name="search"></q-icon>
                            </template>
                            </q-input>
                        </div>
                    </div>
                </div>
            </q-card>
        </template>
        <section class="page-section " >
            <div class="container-fluid">
                <div class="row q-col-gutter-x-md">
                    <div class="col comp-grid" >
                        <div>
                            <q-chip v-if="searchText" icon="search" removable @remove="clearSearch()">
                            Search: <strong class="q-ml-sm"> {{ searchText }} </strong>
                            </q-chip>
                        </div>
                        <div class="">
                            <div >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script setup>
</script>
<style scoped>
</style>
