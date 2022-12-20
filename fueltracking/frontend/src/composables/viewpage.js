
import { reactive, computed, watch } from "vue";
import { utils } from 'src/utils';
import { useApp } from 'src/composables/app';
import { useStore } from 'vuex';
import { useRoute, useRouter } from 'vue-router';
import { useQuasar } from 'quasar';

export function useViewPage(props) {
	const app = useApp();
	const $q = useQuasar();
	const route = useRoute();
	const router = useRouter();
	const store = useStore();
	const state = reactive({
		id: false,
		item: null,
		currentRecord: null,
		pageReady: false,
		loading: false,
		deleting: false,
		errorMsg: ''
	});
	const currentRecord = computed ({
		get() {
			return store.getters[`${props.pageName}/currentRecord`];
		},
		set(value) {
			store.commit(`${props.pageName}/setCurrentRecord`, value);
		}
	});

	const apiUrl = computed(() => {
		let id = props.id || "";
		if(id) id = encodeURIComponent(id);
		let path = `${props.apiPath}/${id}`;
		let query = route.query;
		let queryParams = utils.serializeQuery(query);
		if(queryParams){
			path += "?" + queryParams;
		}
		return path
	});

	 async function load(apiPath) {
		state.pageReady = false;
		state.loading = true;
		state.item = null;
		let url = apiPath ?? apiUrl.value;
		try{
			// fetch currentRecord from api and save in page store
			await store.dispatch(`${props.pageName}/fetchRecord`, url);
			const item = currentRecord.value;
			if(item){
				state.item = item;
				state.pageReady = true;
			}
		}
		catch(e){
			app.showPageRequestError(e);
		}
		finally{
			state.loading = false;
		}
	}

	function exportPage() {
		app.exportPageRecords(props.exportFormats, apiUrl.value, props.pageName);
	}

	function deleteItem (id) {
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
				let url =`${props.pageName}/delete/${id}`;
				let payload = { id, url };
				try{
					await store.dispatch(`${props.pageName}/deleteRecord`, payload);
					if(app.isDialogOpen()){
						app.closeDialogs();
					} 
					else{
						router.back();
					}
					
					app.flashMsg(props.msgAfterDelete);
				}
				catch(e){
					console.error(e);
					app.showPageRequestError(response);
				}
			}).onCancel(() => {
				// console.log('>>>> Cancel')
			}).onDismiss(() => {
				// console.log('I am triggered on both OK and Cancel')
			})
		}
	}

	function moveRecord (recid) {
		let id = encodeURIComponent(recid);
		let path = `/${props.apiPath}/${id}`;
		load(path);
	}

	function moveToNextRecord () {
		moveRecord(state.item.nextRecordId);
	}

	function moveToPreviousRecord () {
		moveRecord(state.item.previousRecordId);
	}

	watch(apiUrl, () => { load(); });

	const computedProps = {
		apiUrl,
		currentRecord,
	}

	const methods = {
		load,
		deleteItem,
		moveToNextRecord,
		moveToPreviousRecord,
		exportPage,
	}
	
	return {
		state,
		computedProps,
		methods,
	}

}