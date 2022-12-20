import { reactive, computed, onMounted, watch, watchEffect } from "vue";
import { utils } from 'src/utils';
import { useApp } from 'src/composables/app';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';
import { useQuasar } from 'quasar';

export function useListPage(props, filters) {
	const app = useApp();
	const route = useRoute();

	const store = useStore();
	const $q = useQuasar();

	const state = reactive({
		totalRecords: 0,
		recordCount: 0,
		pageReady: false,
		loading: false,
		singleSelect: false,
		selectedItems: [],
		pagination: {
			page: 1,
			rowsPerPage: props.limit,
			sortBy: '',
			rowsNumber: 0,
			descending: true,
		},
		deleting: false,
		searchText: '',
		errorMsg: ''
	});

	let records = computed({
		get() {
			return store.getters[`${props.pageName}/records`];
		},
		set(value) {
			store.commit(`${props.pageName}/setRecords`, value);
		},
	});

	let currentRecord = computed ({
		get() {
			return store.getters[`${props.pageName}/currentRecord`];
		},
		set(value) {
			store.commit(`${props.pageName}/setCurrentRecord`, value);
		}
	});

	const apiUrl = computed(() => {
		let path = props.apiPath;
		if (props.fieldName) {
			path = path + '/' + encodeURIComponent(props.fieldName) + '/' + encodeURIComponent(props.fieldValue);
		}
		if (props.sortBy) {
			state.pagination.sortBy = props.sortBy;
		}
		else if (route.query.sortby) {
			state.pagination.sortBy = route.query.sortby;
		}

		if (props.sortType) {
			state.pagination.descending = props.sortType.toLowerCase() == 'desc';
		}
		else if (route.query.sorttype) {
			state.pagination.descending = (route.query.sorttype.toLowerCase() == 'desc');
		}

		const query = {};
		query.page = state.pagination.page;
		query.limit = state.pagination.rowsPerPage;

		if(state.pagination.sortBy){
			let orderType = state.pagination.descending ? 'desc' : 'asc';
			query.orderby = state.pagination.sortBy;
			query.ordertype = orderType;
		}
		
		if (state.searchText) {
			query.search = state.searchText;
		}

		for (const [key, filter] of Object.entries(filters)) {
			if(filterHasValue(filter)){
				if(filter.valueType == 'range'){
					query[key] = { min: filter.value.min, max: filter.value.max };
				}
				else if(filter.valueType == 'range-date'){
					let fromDate = filter.value.from;
					let toDate = filter.value.to;
					query[key] = { from: fromDate, to: toDate };
				}
				else if(filter.valueType == 'multiple-date'){
					query[key] = filter.value;//.map((val) => utils.formatDate(val));
				}
				else{
					query[key] = filter.value;
				}
			}
		}
		
		const queryParams = utils.serializeQuery(query);
		if(path.includes('?')){
            return `${path}&${queryParams}`;
        }
		return `${path}?${queryParams}`;
	});

	const recordsPosition =  computed(() => {
		return Math.min(state.pagination.page * state.pagination.rowsPerPage, state.totalRecords);
	});

	const totalPages = computed (() => {
		if (state.totalRecords > state.pagination.rowsPerPage) {
			return Math.ceil(state.totalRecords / state.pagination.rowsPerPage);
		}
		return 1;
	});

	const finishedLoading = computed(() => {
		if (records.value.length > state.pagination.rowsPerPage && records.value.length >= state.totalRecords) {
			return true;
		}
		return false;
	});


	const canLoadMore = computed(() => {
		if (state.loading || finishedLoading.value) {
			return false;
		}
		return true;
	});

	const pageBreadCrumb = computed(() => {
		let items = [];
		let filterName = route.query.tag || props.fieldName;
		items.push({
			label: filterName,
			to: `/${props.pageName}`
		});

		let filterValue = route.query.label || props.fieldValue;
		items.push({
			label: filterValue,
			to: `/${props.pageName}`
		});
		return items;
	});
	function resetPagination(){
		records.value = [];
		state.recordCount = 0;
		state.pagination.page = 1;
	}
	
	
	function setPagination (pager) {
		let { page, rowsPerPage, rowsNumber, sortBy, descending } = pager.pagination
		state.pagination.sortBy = sortBy;
		state.pagination.descending = descending;
	}

	function onSort(event) {
		if(props.mergeRecords){
			resetPagination();
		}
		state.pagination.sortBy = event.sortField;
		state.pagination.descending = event.sortOrder==-1;
	}

	async function loadNextPage(index, done) {
		if (index) { //quasar infinite scroll component
			if (!canLoadMore.value) {
				done(true); //when all data has been loaded
				return;
			}
			state.pagination.page = index;
			await load();
			done();
		} else {
			// load more button manual trigger
			// watch apiUrl will trigger load function
			state.pagination.page++; 
		}
	}

	function loadPreviousPage() {
		if(state.pagination.page > 0){
			state.pagination.page--; //will trigger load function
		}
	}

	function scrollToTop(){
		// display starting from first record
		// if not infinite load,
		if(props.routeName === route.name && !props.mergeRecords){ 
			window.scrollTo({top: 0, behavior: "smooth"});
		}
	}

	async function load() {
		if (!canLoadMore.value) {
			return;
		}
		scrollToTop();
		state.pageReady = false;
		state.loading = true;
		currentRecord.value = null;
		

		const url = apiUrl.value;
		const payload = {
			url,
			merge: props.mergeRecords // for infinite load
		}
		try{
			//the store will load the page data and set current records
			const response = await store.dispatch(`${props.pageName}/fetchRecords`, payload);

			//update pagination state with new response data
			state.totalRecords = response.total_records;
			state.recordCount = response.record_count;
			state.pagination.rowsNumber = state.totalRecords;

			// when page data is loaded
			//notify other dependent components
			state.pageReady = true;
		}
		catch(err){
			app.showPageRequestError(err);
		}
		finally{
			state.loading = false;
		}
	}

	function reload() {
		state.searchText = query.search || null;
		resetPagination();
	}

	function setCurrentRecord(record) {
		state.selectedItems=[record];
		store.commit(`${props.pageName}/setCurrentRecord`, record);
	}

	function isCurrentRecord(row) {
		return row == currentRecord.value;
	}

	function importComplete(message) {
		app.flashMsg(message);
		reload();
	}

	function exportPage() {
		app.exportPageRecords(props.exportFormats, apiUrl.value, props.pageName);
	}

	async function deleteItem(id) {
		if (Array.isArray(id)) {
			id = id.map(value => value[props.primaryKey]);
		}

		if (id) {
			const title = props.titleBeforeDelete;
			const prompt = props.msgBeforeDelete;
			$q.dialog({
				title: title,
				message: prompt,
				cancel: true,
				persistent: true
			}).onOk(async () => {
				let url =`${props.pageName}/delete/${id.toString()}`;
				let payload = { id, url };
				try{
					await store.dispatch(`${props.pageName}/deleteRecord`, payload);
					app.flashMsg(props.msgAfterDelete);
				}
				catch(e){
					app.showPageRequestError(e);
				}
			}).onCancel(() => {
				// console.log('>>>> Cancel')
			}).onDismiss(() => {
				// console.log('I am triggered on both OK and Cancel')
			})
		}






	}

	function removeFilter(filter, selectedVal){
		let valueType = filter.valueType;
		if(valueType=='single'){
			filter.value = null;
		}
		else if(valueType == 'range'){
			filter.value = { min:0, max:0 };
		}
		else if(valueType == 'range-date'){
			filter.value = {from: null, to: null};
		}
		else if(valueType == 'multiple' || valueType == 'multiple-date'){
			let idx = filter.value.indexOf(selectedVal);
			filter.value.splice(idx, 1);
		}
	}


	function filterHasValue(filter){
		if(filter.valueType == 'range'){
			if(filter.value.max){
				return true;
			}
			return false;
		}
		else if(filter.valueType == 'range-date'){
			if(filter.value.to){
				return true;
			}
			return false;
		}
		else if(Array.isArray(filter.value)){
			return filter.value.length>0;
		}
		else if(filter.value){
			return true;
		}
		return false;
	}

	function getFilterLabel(filter, selectedVal){
		if(filter.valueType == 'range' && filter.value.max){
			let min = filter.value.min;
			let max = filter.value.max;
			return `${min} - ${max}`;
		}
		else if(filter.valueType == 'range-date'){
			if(filter.value.to){
				let minDate = utils.humanDate(filter.value.from);
				let maxDate = utils.humanDate(filter.value.to);
				return `${minDate} - ${maxDate}`;
			}
			return null;
		}
		else if(filter.valueType == 'multiple-date'){
			let val = selectedVal || filter.value;
			return utils.humanDate(val);
		}
		else if(filter.valueType == 'single-date'){
			return utils.humanDate(filter.value);
		}
		else if(filter.options.length){
			let val = selectedVal || filter.value;
			let selectedFilter = filter.options.find(obj => obj.value == val);
			if(selectedFilter){
				return selectedFilter.label;
			}
		}
		else if(selectedVal){
			return selectedVal.toString();
		}
		return filter.value.toString();
	}


	
	function clearSearch() {
		state.searchText = '';
		route.query.search = '';
	}

	onMounted(()=>{ 
		if(route.query.search){
			state.searchText = route.query.search;
		}
	});

	watchEffect(() => {
		if ((props.fieldName && props.fieldValue) || state.searchText) {
			resetPagination();
		}
	});

	watch(apiUrl, () => load());

	const computedProps = {
		records,
		apiUrl,
		currentRecord,
		pageBreadCrumb,
		canLoadMore,
		finishedLoading,
		totalPages,
		recordsPosition
	}

	const methods = {
		load,
		reload,
		loadNextPage,
		loadPreviousPage,
		exportPage,
		clearSearch,
		onSort,
		setPagination,
		resetPagination,
		deleteItem,
		setCurrentRecord,
		isCurrentRecord,
		removeFilter,
		getFilterLabel,
		filterHasValue,
		importComplete
	}
	
	return {
		state,
		computedProps,
		methods,
	}

}