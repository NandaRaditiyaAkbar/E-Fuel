<template>
    <div class="main-page">
        <template v-if="showHeader">
            <q-card  :flat="isSubPage" class="page-section q-py-sm q-px-md q-mb-md nice-shadow-6" >
                <div class="container">
                    <div class="row justify-between q-col-gutter-md">
                        <div class="col-12 col-md-auto " >
                            <div class=" text-h6 text-primary" >
                                Add New Track
                            </div>
                        </div>
                    </div>
                </div>
            </q-card>
        </template>
        <section class="page-section " >
            <div class="container">
                <div class="row q-col-gutter-x-md">
                    <div class="col-md-9 col-12 comp-grid" >
                        <div class="">
                            <div >
                                <q-form ref="observer" @submit.prevent="submitForm()">
                                <q-card class="q-pa-md nice-shadow-6">
                                    <div class="row q-col-gutter-x-md">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Foto Dashboard *
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <div class="q-mb-sm">
                                                        <q-uploader-input :max-files="1" :max-file-size="3" accept=".jpg,.png,.gif,.jpeg" :multiple="false" delete-icon="clear" style="width:100%" label="Choose files or drop files here" upload-path="fileuploader/upload/foto_dashboard" v-model="formData.foto_dashboard"></q-uploader-input>
                                                        <!-- <small class="q-pa-sm text-negative"></small> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Tanggal 
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  ref="ctrltanggal" v-model.trim="formData.tanggal"  label="Tanggal" type="text" placeholder="Enter Tanggal"      
                                                    class="" :error="isFieldValid('tanggal')" :error-message="getFieldError('tanggal')">
                                                    </q-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Status *
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  ref="ctrlstatus" v-model.trim="formData.status"  label="Status" type="text" placeholder="Enter Status"      
                                                    class="" :error="isFieldValid('status')" :error-message="getFieldError('status')">
                                                    </q-input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="showSubmitButton" class="text-center q-my-md">
                                        <q-btn type="submit"    :rounded="false"  color="primary"  no-caps  unelevated    icon-right="send" :loading="saving">
                                            {{ submitButtonLabel }}
                                            <template v-slot:loading>
                                                <q-spinner-oval />
                                            </template>
                                        </q-btn>
                                    </div>
                                </q-card>
                                </q-form>
                                <slot :submit="submitForm" :saving="saving"></slot>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script setup>
	import {  computed, ref, reactive, toRefs } from 'vue';
	import useVuelidate from '@vuelidate/core';
	import { required, } from 'src/services/validators';
	import { useMeta } from 'quasar';
	import { useApp } from 'src/composables/app.js';
	import { useAddPage } from 'src/composables/addpage.js';
	const props = defineProps({
		pageName : {
			type : String,
			default : 'track',
		},
		routeName : {
			type : String,
			default : 'trackadd',
		},
		apiPath : {
			type : String,
			default : 'track/add',
		},
		submitButtonLabel: {
			type: String,
			default: "Submit",
		},
		formValidationError: {
			type: String,
			default: "Form is invalid",
		},
		formValidationMsg: {
			type: String,
			default: "Please complete the form",
		},
		msgAfterSave: {
			type: String,
			default: "Record added successfully",
		},
		showHeader: {
			type: Boolean,
			default: true,
		},
		showSubmitButton: {
			type: Boolean,
			default: true,
		},
		redirect: {
			type : Boolean,
			default : true,
		},
		isSubPage: {
			type : Boolean,
			default : false,
		},
		pageData: { // use to set formData default values from another page
			type: Object,
			default: () => {} 
		},
	});
	const app = useApp();// application state and methods
	const formDefaultValues = {
		foto_dashboard: "", 
		tanggal: "NULL", 
		status: "", 
	};
	const formData = reactive({ ...formDefaultValues });
	//form validation rules
	const rules = computed(() => {
		return {
			foto_dashboard: { required },
			tanggal: {  },
			status: { required }
		}
	});
	const v$ = useVuelidate(rules, formData); // form validation
	// page form hook
	const page = useAddPage({ props, formData, v$, beforeSubmit, afterSubmit });
	// perform custom validation before submit form
	// set custom form fields
	// return false if validation fails
	function beforeSubmit(){
		return true;
	}
	// after form submited to api
	// reset form data.
	// redirect to another page
	function afterSubmit(response) {
		app.flashMsg(props.msgAfterSave);
		page.setFormDefaultValues(); //reset form data
		if(props.redirect) app.navigateTo(`/track`);
	}
	//page state
	const {
		submitted, // form submitted state - Boolean
		saving, // form api submiting state - Boolean
		pageReady, // api data loaded successfully
	} = toRefs(page.state);
	//page methods
	const {
		submitForm, //submit form data to api
		isFieldValid, // check if field is validated - args(fieldname)
		getFieldError, //  get validation error message - args(fieldname)
		 // map api datasource  to Select options label-value
	} = page.methods;
	useMeta(() => {
		return {
			//set browser title
			title: "Add New Track"
		}
	});
	// expose page object for other components access
	defineExpose({
		page
	});
</script>
<style scoped>
</style>
