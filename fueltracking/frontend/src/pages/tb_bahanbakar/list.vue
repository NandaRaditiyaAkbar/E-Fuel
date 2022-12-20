<template>
    <div class="main-page">
        <template v-if="showHeader">
            <q-card  :flat="isSubPage" class="page-section q-py-sm q-px-md q-mb-md nice-shadow-6" >
                <div class="container-fluid">
                    <div class="row justify-between q-col-gutter-md">
                        <div class="col-12 col-md-auto " >
                            <div class=" text-h6 text-primary" >
                                Tb Bahanbakar
                            </div>
                        </div>
                        <div class="col-md-auto col-12 " >
                            <template v-if="auth.canView('/tb_bahanbakar/add')">
                                <q-btn       :rounded="false"  size=""  color="primary" no-caps  unelevated   @click="app.openPageDialog({ page: 'tb_bahanbakar/add', url: `/tb_bahanbakar/add` , closeBtn: true  })"  class="full-width" >
                                    <q-icon name="add"></q-icon>                                
                                    Add New Tb Bahanbakar 
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
                                <template v-if="showBreadcrumbs && $route.query.tag">
                                    <q-breadcrumbs class="q-pa-md">
                                        <q-breadcrumbs-el icon="arrow_back" class="text-capitalize" :label="$route.query.tag" to="/tb_bahanbakar"></q-breadcrumbs-el>
                                        <q-breadcrumbs-el :label="$route.query.label"></q-breadcrumbs-el>
                                    </q-breadcrumbs>
                                </template>
                                <div class="relative-position">
                                    <div class="row q-col-gutter-x-md">
                                        <!-- Master Page Start -->
                                        <div class="col">
                                            <q-card class=" nice-shadow-6">
                                                <!-- page records template -->
                                                <div >
                                                    <q-table 
                                                    :flat="true"
                                                    table-header-class="text-h4 "
                                                    :bordered="false"
                                                    :columns="app.menus.Tb_BahanbakarTableHeaderItems" 
                                                    :rows="records"
                                                    binary-state-sort
                                                    separator="horizontal"
                                                    :dense="true"
                                                    v-model:selected="selectedItems"
                                                    selection="multiple"
                                                    row-key="id" 
                                                    v-model:pagination="pagination"
                                                    hide-bottom
                                                    @request="setPagination"
                                                    :loading="loading">
                                                    <!-- Start of Table Layout -->
                                                    <template v-slot:body="props">
                                                        <q-tr :class="{selected: isCurrentRecord(props.row)}" :props="props">
                                                            <q-td auto-width>
                                                                <q-checkbox dense v-model="props.selected"></q-checkbox>
                                                            </q-td>
                                                            <q-td  key="id" :props="props">
                                                                <q-btn padding="xs"   :rounded="false"  color="primary"  no-caps  unelevated   flat :to="`/tb_bahanbakar/view/${props.row.id}`">{{ props.row.id }}</q-btn>
                                                            </q-td>
                                                            <q-td  key="jenis_bbm" :props="props">
                                                                {{ props.row.jenis_bbm }}
                                                            </q-td>
                                                            <q-td  key="harga" :props="props">
                                                                {{ props.row.harga }}
                                                            </q-td>
                                                            <q-td key="btnactions" :props="props">
                                                                <div class="row q-col-gutter-xs justify-end">
                                                                    <q-btn icon="menu" padding="xs" round flat color="grey">
                                                                        <q-menu auto-close transition-show="flip-right"  transition-hide="flip-left" self="center middle" anchor="center middle">
                                                                            <q-list dense rounded nav>
                                                                                <template v-if="auth.canView('tb_bahanbakar/view')">
                                                                                    <q-item link clickable v-ripple :to="`/tb_bahanbakar/view/${props.row.id}`">
                                                                                        <q-item-section>
                                                                                            <q-icon color="primary"  size="sm" name="visibility"></q-icon>
                                                                                        </q-item-section>
                                                                                        <q-item-section>View</q-item-section>
                                                                                    </q-item>
                                                                                </template>
                                                                                <template v-if="auth.canView('tb_bahanbakar/edit')">
                                                                                    <q-item link clickable v-ripple @click="app.openPageDialog({ page:'tb_bahanbakar/edit', url: `/tb_bahanbakar/edit/${props.row.id}` , closeBtn: true })">
                                                                                        <q-item-section>
                                                                                            <q-icon color="positive"  size="sm" name="edit"></q-icon>
                                                                                        </q-item-section>
                                                                                        <q-item-section>Edit</q-item-section>
                                                                                    </q-item>
                                                                                </template>
                                                                                <template v-if="auth.canView('tb_bahanbakar/delete')">
                                                                                    <q-item link clickable v-ripple @click="deleteItem(props.row.id)">
                                                                                        <q-item-section>
                                                                                            <q-icon color="negative"  size="sm" name="clear"></q-icon>
                                                                                        </q-item-section>
                                                                                        <q-item-section>Delete</q-item-section>
                                                                                    </q-item>
                                                                                </template>
                                                                            </q-list>
                                                                        </q-menu>
                                                                    </q-btn>
                                                                </div>
                                                            </q-td>
                                                        </q-tr>
                                                    </template>
                                                    <!-- End of Table Layout-->
                                                    </q-table>
                                                    <div class="row justify-center">
                                                        <q-td></q-td>
                                                    </div>
                                                </div>
                                                <!-- page loading indicator template -->
                                                <template v-if="loading">
                                                    <q-inner-loading :showing="loading">
                                                        <q-spinner color="primary" size="30px"> 
                                                        </q-spinner>
                                                    </q-inner-loading>
                                                </template>
                                                <!-- page empty record template -->
                                                <template v-if="pageReady && !records.length">
                                                    <q-card :flat="$q.screen.gt.md">
                                                        <q-card-section>
                                                            <div class="text-grey text-h6 text-center">
                                                                No record found
                                                            </div>
                                                        </q-card-section>
                                                    </q-card>
                                                </template>
                                                <!-- page footer template-->
                                                <template v-if="showFooter">
                                                    <div class="">
                                                        <div class="q-pa-sm" v-show="pageReady">
                                                            <div class="row justify-between">
                                                                <div class="row q-col-gutter-md">
                                                                    <template v-if="auth.canView('tb_bahanbakar/delete')">
                                                                        <div>
                                                                            <q-btn round flat   no-caps  unelevated   color="negative" @click="deleteItem(selectedItems)" v-if="selectedItems.length" icon="delete_sweep" class="q-my-xs" title="Delete Selected"></q-btn>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                                <div v-if="paginate && totalRecords > 0" class="row q-col-gutter-md justify-center">
                                                                    <div class="col-auto">
                                                                        <q-chip>Records {{recordsPosition}} of {{totalRecords}}</q-chip>
                                                                    </div>
                                                                    <div v-if="totalPages > 1">
                                                                        <q-pagination  color="primary" flat glossy  input v-model="pagination.page" :direction-links="true" :boundary-links="true" :max-pages="5" :boundary-numbers="true" :max="totalPages"></q-pagination>
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                    </div>
                                                </template>
                                            </q-card>
                                        </div>
                                    </div>
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
	import {  computed, ref, reactive, toRefs, onMounted } from 'vue';
	import { useMeta } from 'quasar';
	import { useApp } from 'src/composables/app.js';
	import { useAuth } from 'src/composables/auth';
	import { useListPage } from 'src/composables/listpage.js';
	const props = defineProps({
		primaryKey : {
			type : String,
			default : 'id',
		},
		pageName : {
			type : String,
			default : 'tb_bahanbakar',
		},
		routeName : {
			type : String,
			default : 'tb_bahanbakarlist',
		},
		apiPath : {
			type : String,
			default : 'tb_bahanbakar/index',
		},
		paginate: {
			type: Boolean,
			default: true,
		},
		scrollIntoView: {
			type: Boolean,
			default: true,
		},
		isSubPage: {
			type: Boolean,
			default: false,
		},
		showHeader: {
			type: Boolean,
			default: true,
		},
		showFooter: {
			type: Boolean,
			default: true,
		},
		showBreadcrumbs: {
			type: Boolean,
			default: true,
		},
		exportButton: {
			type: Boolean,
			default: true,
		},
		importButton: {
			type: Boolean,
			default: false,
		},
		multiCheckbox: {
			type: Boolean,
			default: true,
		},
		emptyRecordMsg: {
			type: String,
			default: "No record found",
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
		page: {
			type: Number,
			default: 1,
		},
		limit: {
			type: Number,
			default: 10,
		},
		mergeRecords: {
			type: Boolean,
			default: false,
		},
		search: {
			type: String,
			default: '',
		},
		fieldName: null,
		fieldValue: null,
		sortBy: {
			type: String,
			default: '',
		},
		sortType: {
			type: String,
			default: '', //desc or asc
		},
	});
	const app = useApp();
	const auth = useAuth();
			const filters = reactive({});
	//init list page hook
	const page = useListPage(props, filters);
	//page state
	const { 
		totalRecords, // total records from api - Number
		recordCount, // current record count - Number
		loading, // Api loading state - Boolean
		selectedItems, // Data table selected items -Array
		pagination, //Pagination object - Object
		searchText, // search text - String
		pageReady, // api data loaded successfully
	} = toRefs(page.state);
	//page computed propties
	const { 
		records, // page record from store - Array
		apiUrl, // current api path - URL
		currentRecord, // master detail selected record - Object
		pageBreadCrumb, // get page navigation paths - Object
		canLoadMore, // if api has more data for loading - Boolean
		finishedLoading, // if api has finished loading - Boolean
		totalPages, // total number of pages from api - Number
		recordsPosition // current record position from api - Number
	} = page.computedProps;
	//page methods
	const {
		load, // load data from api
		reload, // reset pagination and load data
		loadNextPage, // load next page
		loadPreviousPage, // load previous page
		exportPage, // export page records - args = (exportFormats, apiUrl, pageName)
		clearSearch, // clear input search
		onSort, // reset page number before sort from api
		setPagination, // update pagination with data from api
		deleteItem, // delete item by id or selected items - args = (id) or (selectedItems)
		setCurrentRecord, // master detail set current record
		isCurrentRecord, // master detail 
		removeFilter, // remove page filter item - args = (filter.propertyname)
		getFilterLabel, // get filter item display label - args = (filter.propertyname)
		filterHasValue, //check if filter item has value - args = (filter.propertyname)
		importComplete // reload page after data import
	} = page.methods;
	const pageTitle = computed({
		get: function () {
			return "Tb Bahanbakar"
		}
	});
	useMeta(() => {
		return {
			title: pageTitle.value //set browser title
		}
	});
	onMounted(()=>{ 
		load();
	});
</script>
<style scoped>
</style>
