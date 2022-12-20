<template>
    <div class="main-page">
        <template v-if="showHeader">
            <q-card  :flat="isSubPage" class="page-section q-py-sm q-px-md q-mb-md nice-shadow-6" >
                <div class="container">
                    <div class="row justify-between q-col-gutter-md">
                        <div class="col-12 col-md-auto " >
                            <div class=" text-h6 text-primary" >
                                Edit Kategori
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
                                <template v-if="pageReady">
                                    <div class="row  q-col-gutter-x-md">
                                        <div class="col">
                                            <q-card class="q-pa-md nice-shadow-6">
                                                <q-form ref="observer"  @submit.prevent="submitForm()">
                                                <!--[form-content-start]-->
                                                <div class="row q-col-gutter-x-md">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Kategori *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <q-input outlined dense  ref="ctrlkategori" v-model.trim="formData.kategori"  label="Kategori" type="text" placeholder="Enter Kategori"      
                                                                class="" :error="isFieldValid('kategori')" :error-message="getFieldError('kategori')">
                                                                </q-input>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Jenis Kendaraan *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <q-input outlined dense  ref="ctrljenis_kendaraan" v-model.trim="formData.jenis_kendaraan"  label="Jenis Kendaraan" type="text" placeholder="Enter Jenis Kendaraan"      
                                                                class="" :error="isFieldValid('jenis_kendaraan')" :error-message="getFieldError('jenis_kendaraan')">
                                                                </q-input>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Jenis Bbm *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <q-input outlined dense  ref="ctrljenis_bbm" v-model.trim="formData.jenis_bbm"  label="Jenis Bbm" type="text" placeholder="Enter Jenis Bbm"      
                                                                class="" :error="isFieldValid('jenis_bbm')" :error-message="getFieldError('jenis_bbm')">
                                                                </q-input>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                No Polisi *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <q-input outlined dense  ref="ctrlno_polisi" v-model.trim="formData.no_polisi"  label="No Polisi" type="text" placeholder="Enter No Polisi"      
                                                                class="" :error="isFieldValid('no_polisi')" :error-message="getFieldError('no_polisi')">
                                                                </q-input>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--[form-content-end]-->
                                                <div v-if="showSubmitButton" class="text-center q-my-md">
                                                    <q-btn    :rounded="false"  color="primary"  no-caps  unelevated   type="submit" icon-right="send" :loading="saving">
                                                        {{ submitButtonLabel }}
                                                        <template v-slot:loading>
                                                            <q-spinner-oval />
                                                        </template>
                                                    </q-btn>
                                                </div>
                                                </q-form>
                                                <slot :submit="submitForm" :saving="saving"></slot>
                                            </q-card>
                                        </div>
                                    </div>
                                </template>
                                <template v-if="loading">
                                    <div class="q-pa-sm text-center">
                                        <q-spinner :size="40" color="accent" indeterminate></q-spinner>
                                    </div>
                                </template>
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
	import { useEditPage } from 'src/composables/editpage.js';
	const props = defineProps({
		id: [String, Number],
		pageName: {
			type: String,
			default: 'kategori',
		},
		routeName: {
			type: String,
			default: 'kategoriedit',
		},
		pagePath: {
			type : String,
			default : 'kategori/edit',
		},
		apiPath: {
			type: String,
			default: 'kategori/edit',
		},
		submitButtonLabel: {
			type: String,
			default: "Update",
		},
		msgAfterUpdate: {
			type: String,
			default: "Record updated successfully",
		},
		formValidationError: {
			type: String,
			default: "Form is invalid",
		},
		formValidationMsg: {
			type: String,
			default: "Please complete the form",
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
	});
	const app = useApp();
	const formDefaultValues = Object.assign({
		kategori: "", 
		jenis_kendaraan: "", 
		jenis_bbm: "", 
		no_polisi: "", 
	}, props.pageData);
	const formData = reactive({ ...formDefaultValues });
	function onFormSubmited(response) {
		app.flashMsg(props.msgAfterUpdate);
		if(props.redirect) app.navigateTo(`/kategori`);
	}
	const rules = computed(() => {
		return {
			kategori: { required },
			jenis_kendaraan: { required },
			jenis_bbm: { required },
			no_polisi: { required }
		}
	});
	const v$ = useVuelidate(rules, formData); //form validation
	const page = useEditPage(props, formData, v$, onFormSubmited);
	//page state
	const {
		submitted, // form api submitted state - Boolean
		saving, // form api submiting state - Boolean
		loading, // form data loading state - Boolean
		pageReady, // if api data loaded successfully
	} = toRefs(page.state);
	//page computed propties
	const {
		apiUrl, // page current api path
		currentRecord, // current page record  - Object
	} = page.computedProps;
	//page methods
	const { 
		submitForm, // submit form data to api
		isFieldValid, // check if field is validated - args(fieldname)
		getFieldError, //  get validation error message - args(fieldname)
		 // map api datasource  to Select options label-value
	} = page.methods;
	useMeta(() => {
		return {
			//set browser title
			title: "Edit Kategori"
		}
	});
</script>
<style scoped>
</style>
