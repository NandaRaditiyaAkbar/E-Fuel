<template>
    <div class="main-page">
        <template v-if="showHeader">
            <q-card  :flat="isSubPage" class="page-section q-py-sm q-px-md q-mb-md nice-shadow-6" >
                <div class="container">
                    <div class="row justify-between q-col-gutter-md">
                        <div class="col-12 col-md-auto " >
                            <div class=" text-h6 text-primary" >
                                Voucher Details
                            </div>
                        </div>
                    </div>
                </div>
            </q-card>
        </template>
        <section class="page-section " >
            <div class="container">
                <div class="row q-col-gutter-x-md">
                    <div class="col comp-grid" >
                        <div class="">
                            <div >
                                <div class="relative-position" style="min-height:100px">
                                    <template v-if="pageReady">
                                        <div class="row q-col-gutter-x-md">
                                            <div class="col">
                                                <q-card class=" nice-shadow-6">
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Tanggal </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>{{$utils.humanDate( item.tanggal )}}</q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Nama Peminta </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>{{ item.nama_peminta }}</q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Jenis Kendaraan </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>{{ item.jenis_kendaraan }}</q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Jenis Bbm </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>{{ item.jenis_bbm }}</q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Jumlah Liter </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>{{ item.jumlah_liter }}</q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Jumlah Harga </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>{{ item.jumlah_harga }}</q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Total </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>{{ item.total }}</q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Km Dashboard </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>{{ item.km_dashboard }}</q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Foto Dashboard </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>
                                                                <image-viewer image-size="large" image-preview-size="" :src="item.foto_dashboard" width="200px" height="200px" :num-display="1">
                                                                </image-viewer>
                                                            </q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Foto Struk </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>
                                                                <image-viewer image-size="large" image-preview-size="" :src="item.foto_struk" width="200px" height="200px" :num-display="1">
                                                                </image-viewer>
                                                            </q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-item>
                                                        <q-item-section class="col-auto col-md-3">
                                                            <q-item-label class="text-bold">Bukti Pengajuan </q-item-label>
                                                        </q-item-section>
                                                        <q-item-section>
                                                            <q-item-label caption>
                                                                <image-viewer image-size="large" image-preview-size="" :src="item.bukti_pengajuan" width="200px" height="200px" :num-display="1">
                                                                </image-viewer>
                                                            </q-item-label>
                                                        </q-item-section>
                                                    </q-item>
                                                    <q-separator></q-separator>
                                                    <q-card-actions class="row q-col-gutter-xs justify-btween">
                                                        <div>
                                                            <q-btn v-if="exportButton"    :rounded="false"  no-caps  unelevated   color="accent" class="q-my-xs" @click="exportPage()" label=""  title="Export" icon="print">
                                                            </q-btn>
                                                        </div>
                                                        <q-btn icon="menu" padding="xs" round flat color="grey">
                                                            <q-menu auto-close transition-show="flip-right"  transition-hide="flip-left" self="center middle" anchor="center middle">
                                                                <q-list dense rounded nav>
                                                                    <template v-if="auth.canView('voucher/edit')">
                                                                        <q-item link clickable v-ripple @click="app.openPageDialog({ page:'voucher/edit', url: `/voucher/edit/${item.id}` , closeBtn: true })">
                                                                            <q-item-section>
                                                                                <q-icon color="positive"  size="sm" name="edit"></q-icon>
                                                                            </q-item-section>
                                                                            <q-item-section>Edit</q-item-section>
                                                                        </q-item>
                                                                    </template>
                                                                    <template v-if="auth.canView('voucher/delete')">
                                                                        <q-item link clickable v-ripple @click="deleteItem(item.id)">
                                                                            <q-item-section>
                                                                                <q-icon color="negative"  size="sm" name="clear"></q-icon>
                                                                            </q-item-section>
                                                                            <q-item-section>Delete</q-item-section>
                                                                        </q-item>
                                                                    </template>
                                                                </q-list>
                                                            </q-menu>
                                                        </q-btn>
                                                    </q-card-actions>
                                                </q-card>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-if="loading">
                                        <div class="q-pa-sm text-center">
                                            <q-inner-loading :showing="loading">
                                                <q-spinner :size="40" color="primary" indeterminate></q-spinner>
                                            </q-inner-loading>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script setup>
	import {  computed, ref, toRefs, onMounted } from 'vue';
	import { useMeta } from 'quasar';
	import { useApp } from 'src/composables/app.js';
	import { useAuth } from 'src/composables/auth';
	import { utils } from 'src/utils';
	import { useViewPage } from 'src/composables/viewpage.js';
	const props = defineProps({
		id: [String, Number],
		primaryKey: {
			type: String,
			default: 'id',
		},
		pageName: {
			type: String,
			default: 'voucher',
		},
		routeName: {
			type: String,
			default: 'voucherview',
		},
		apiPath: {
			type: String,
			default: 'voucher/view',
		},
		editButton: {
			type: Boolean,
			default: true,
		},
		deleteButton: {
			type: Boolean,
			default: true,
		},
		exportButton: {
			type: Boolean,
			default: true,
		},
		scrollIntoView: {
			type: Boolean,
			default: true,
		},
		isSubPage: {
			type : Boolean,
			default : false,
		},
		titleBeforeDelete: {
			type: String,
			default: "Delete record",
		},
		msgBeforeDelete: {
			type: String,
			default: "Are you sure you want to delete this record?",
		},
		msgAfterDelete: {
			type: String,
			default: "Record deleted successfully",
		},
		showHeader: {
			type: Boolean,
			default: true,
		},
		showFooter: {
			type: Boolean,
			default: true,
		},
			exportFormats: {
				type: Array,
				default: function () { return ['pdf'] },
			},
	}
	);
	const app = useApp(props);
	const auth = useAuth();
	const page = useViewPage(props); // page hook
	//page state
	const { 
		item, // current record from store - Object
		loading, // api loading state
		pageReady, // if api data loaded successfully
	} = toRefs(page.state);
	//page computed propties
	const { 
		apiUrl, // page current api path
		currentRecord, // current page record  - Object
	} = page.computedProps;
	useMeta(() => {
		return {
			//set browser title
			title: "Voucher Details"
		}
	});
	//page methods
	const 
	{ 
		load, // load data from api
		deleteItem, // deleted current record
		exportPage, // export page records - args = (exportFormats, apiUrl, pageName)
		moveToNextRecord, // load next record from api
		moveToPreviousRecord // load previous record from api
	} = page.methods;
	onMounted(()=>{ 
		load();
	});
</script>
<style scoped>
</style>
