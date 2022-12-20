<template>
    <q-page  class="main-page">
        <section class="page-section q-pa-md" >
            <div class="container-fluid">
                <div class="row q-col-gutter-x-md">
                    <div class="col comp-grid" >
                        <div class=" text-h6 text-bold" >
                            Home
                        </div>
                        <q-separator class="q-my-sm"></q-separator>
                    </div>
                </div>
            </div>
        </section>
        <section class="page-section q-mb-md" >
            <div class="container-fluid">
                <div class="row q-col-gutter-x-md">
                    <div class="col-sm-6 comp-grid" >
                        <q-card  :flat="isSubPage" class=" nice-shadow-6">
                            <div class="q-pa-md">
                                <div class="text-weight-bold text-h5">Data Peminta Pengajuan Voucher</div>
                                <div class="text-caption"></div>
                                <q-separator class="q-my-md"></q-separator>
                                <div class="row q-col-gutter-sm">
                                    <div class="col">
                                        <api-data-source   api-path="components_data/barchart_datapemintapengajuanvoucher"  v-slot="req">
                                            <div style="position:relative;text-align:center">
                                                <q-inner-loading :showing="req.loading">
                                                    <q-spinner-pie color="accent" size="5em" />
                                                </q-inner-loading>
                                                <vue-chart :chart-data="req.response" chart-type="bar" ></vue-chart>
                                            </div>
                                        </api-data-source>
                                    </div>
                                </div>
                            </div>
                        </q-card>
                    </div>
                    <div class="col-sm-6 comp-grid" >
                        <q-card  :flat="isSubPage" class=" nice-shadow-6">
                            <div class="q-pa-md">
                                <div class="text-weight-bold text-h5">Data Voucher Pengisian BBM</div>
                                <div class="text-caption"></div>
                                <q-separator class="q-my-md"></q-separator>
                                <div class="row q-col-gutter-sm">
                                    <div class="col">
                                        <api-data-source   api-path="components_data/barchart_datavoucherpengisianbbm"  v-slot="req">
                                            <div style="position:relative;text-align:center">
                                                <q-inner-loading :showing="req.loading">
                                                    <q-spinner-pie color="accent" size="5em" />
                                                </q-inner-loading>
                                                <vue-chart :chart-data="req.response" chart-type="bar" ></vue-chart>
                                            </div>
                                        </api-data-source>
                                    </div>
                                </div>
                            </div>
                        </q-card>
                    </div>
                </div>
            </div>
        </section>
        <section class="page-section q-mb-md" >
            <div class="container-fluid">
                <div class="row q-col-gutter-x-md">
                    <div class="col-sm-6 comp-grid" >
                        <q-card  :flat="isSubPage" class=" nice-shadow-6">
                            <div class="q-pa-md">
                                <div class="text-weight-bold text-h5">Data Pengajuan Voucher</div>
                                <div class="text-caption"></div>
                                <q-separator class="q-my-md"></q-separator>
                                <div class="row q-col-gutter-sm">
                                    <div class="col">
                                        <api-data-source   api-path="components_data/barchart_datapengajuanvoucher"  v-slot="req">
                                            <div style="position:relative;text-align:center">
                                                <q-inner-loading :showing="req.loading">
                                                    <q-spinner-pie color="accent" size="5em" />
                                                </q-inner-loading>
                                                <vue-chart :chart-data="req.response" chart-type="bar" ></vue-chart>
                                            </div>
                                        </api-data-source>
                                    </div>
                                </div>
                            </div>
                        </q-card>
                    </div>
                    <div class="col-sm-6 comp-grid" >
                        <q-card  :flat="isSubPage" class=" nice-shadow-6">
                            <div class="q-pa-md">
                                <div class="text-weight-bold text-h5">Data Jumlah Liter Per Kilometer</div>
                                <div class="text-caption"></div>
                                <q-separator class="q-my-md"></q-separator>
                                <div class="row q-col-gutter-sm">
                                    <div class="col">
                                        <api-data-source   api-path="components_data/barchart_datajumlahliterperkilometer"  v-slot="req">
                                            <div style="position:relative;text-align:center">
                                                <q-inner-loading :showing="req.loading">
                                                    <q-spinner-pie color="accent" size="5em" />
                                                </q-inner-loading>
                                                <vue-chart :chart-data="req.response" chart-type="bar" ></vue-chart>
                                            </div>
                                        </api-data-source>
                                    </div>
                                </div>
                            </div>
                        </q-card>
                    </div>
                </div>
            </div>
        </section>
        <section class="page-section q-mb-md" >
            <div class="container-fluid">
                <div class="row q-col-gutter-x-md">
                    <div class="col-sm-12 comp-grid" >
                        <q-card  :flat="isSubPage" class=" nice-shadow-6">
                            <div class="q-pa-md">
                                <div class="text-weight-bold text-h5">Data Total Pengisian BBM</div>
                                <div class="text-caption"></div>
                                <q-separator class="q-my-md"></q-separator>
                                <div class="row q-col-gutter-sm">
                                    <div class="col">
                                        <api-data-source   api-path="components_data/barchart_datatotalpengisianbbm"  v-slot="req">
                                            <div style="position:relative;text-align:center">
                                                <q-inner-loading :showing="req.loading">
                                                    <q-spinner-pie color="accent" size="5em" />
                                                </q-inner-loading>
                                                <vue-chart :chart-data="req.response" chart-type="bar" ></vue-chart>
                                            </div>
                                        </api-data-source>
                                    </div>
                                </div>
                            </div>
                        </q-card>
                    </div>
                </div>
            </div>
        </section>
    </q-page>
</template>
<script setup>
	import {  computed, ref } from 'vue';
	import { useApp } from 'src/composables/app.js';
	import VueChart from 'src/components/VueCharts.vue'
	const props = defineProps({
		pageName: {
			type: String,
			default: 'home',
		},
		routeName: {
			type: String,
			default: 'home',
		},
		isSubPage: {
			type : Boolean,
			default : false,
		},
	});
	const app = useApp();
	const pageReady = ref(true);
</script>
