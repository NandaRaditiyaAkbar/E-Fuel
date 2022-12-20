<template>
    <div class="main-page">
        <template v-if="showHeader">
            <q-card  :flat="isSubPage" class="page-section q-py-sm q-px-md q-mb-md nice-shadow-6" >
                <div class="container">
                    <div class="row justify-between q-col-gutter-md">
                        <div class="col-12 col-md-auto " >
                            <div class=" text-h6 text-primary" >
                                Edit Voucher
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
                                                                Tanggal *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <q-input outlined dense  v-model="formData.tanggal" label="Tanggal"    :error="isFieldValid('tanggal')" :error-message="getFieldError('tanggal')">
                                                                <template v-slot:append>
                                                                    <q-icon name="date_range" class="cursor-pointer">
                                                                    <q-popup-proxy ref="ctrltanggal" transition-show="scale" transition-hide="scale">
                                                                    <q-date   mask="YYYY-MM-DD" v-model="formData.tanggal" @input="$refs.ctrltanggal.hide()" />
                                                                    </q-popup-proxy>
                                                                    </q-icon>
                                                                </template>
                                                                </q-input>      
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Nama Peminta *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <q-input outlined dense  ref="ctrlnama_peminta" v-model.trim="formData.nama_peminta"  label="Nama Peminta" type="text" placeholder="Enter Nama Peminta"      
                                                                class="" :error="isFieldValid('nama_peminta')" :error-message="getFieldError('nama_peminta')">
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
                                                                <api-data-source @loaded="response => mapOptionField(response, 'jenis_kendaraan')"  api-path="components_data/jenis_kendaraan_option_list"  v-slot="req">
                                                                    <q-select   :loading="req.loading"  outlined dense  ref="ctrljenis_kendaraan" emit-value map-options  v-model="formData.jenis_kendaraan" :options="req.response" label="Jenis Kendaraan"  :error="isFieldValid('jenis_kendaraan')" :error-message="getFieldError('jenis_kendaraan')">
                                                                    </q-select> 
                                                                </api-data-source>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Km Dashboard *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <q-input outlined dense  ref="ctrlkm_dashboard" v-model.trim="formData.km_dashboard"  label="Km Dashboard" type="text" placeholder="Enter Km Dashboard"      
                                                                class="" :error="isFieldValid('km_dashboard')" :error-message="getFieldError('km_dashboard')">
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
                                                                <q-input outlined dense  ref="ctrljenis_bbm" v-model.trim="formData.jenis_bbm"  label="Jenis Bbm" type="text" placeholder="Enter Jenis Bbm"   list="jenis_bbm_list"    
                                                                class="" :error="isFieldValid('jenis_bbm')" :error-message="getFieldError('jenis_bbm')">
                                                                </q-input>
                                                                <api-data-source   api-path="components_data/jenis_bbm_option_list"  v-slot="req">
                                                                    <datalist id="jenis_bbm_list">
                                                                    <option v-for="(menu, index) in req.response" :key="index" :value="menu.value">{{ menu.label }}</option>
                                                                    </datalist>
                                                                </api-data-source>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Jumlah Liter *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <q-input outlined dense  ref="ctrljumlah_liter" v-model.trim="formData.jumlah_liter"  label="Jumlah Liter" type="text" placeholder="Enter Jumlah Liter"      
                                                                class="" :error="isFieldValid('jumlah_liter')" :error-message="getFieldError('jumlah_liter')">
                                                                </q-input>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Jumlah Harga *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <q-input outlined dense  ref="ctrljumlah_harga" v-model.trim="formData.jumlah_harga"  label="Jumlah Harga" type="text" placeholder="Enter Jumlah Harga"      
                                                                class="" :error="isFieldValid('jumlah_harga')" :error-message="getFieldError('jumlah_harga')">
                                                                </q-input>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Total *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <q-input outlined dense  ref="ctrltotal" v-model.trim="formData.total"  label="Total" type="number" placeholder="Enter Total"   step="any"    
                                                                class="" :error="isFieldValid('total')" :error-message="getFieldError('total')">
                                                                </q-input>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Foto Dashboard *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <div class="q-mb-sm">
                                                                    <q-uploader-input show-uploaded-files :max-files="1" :max-file-size="3" accept=".jpg,.png,.gif,.jpeg" :multiple="false" delete-icon="clear" style="width:100%" label="Choose files or drop files here" upload-path="fileuploader/upload/foto_dashboard" v-model="formData.foto_dashboard"  ></q-uploader-input>
                                                                    <!-- <small class="q-pa-sm text-negative"></small> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Foto Struk *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <div class="q-mb-sm">
                                                                    <q-uploader-input show-uploaded-files :max-files="1" :max-file-size="3" accept=".jpg,.png,.gif,.jpeg" :multiple="false" delete-icon="clear" style="width:100%" label="Choose files or drop files here" upload-path="fileuploader/upload/foto_struk" v-model="formData.foto_struk"  ></q-uploader-input>
                                                                    <!-- <small class="q-pa-sm text-negative"></small> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-12">
                                                                Bukti Pengajuan *
                                                            </div>
                                                            <div class="col-sm-9 col-12">
                                                                <div class="q-mb-sm">
                                                                    <q-uploader-input show-uploaded-files :max-files="1" :max-file-size="3" accept=".jpg,.png,.gif,.jpeg" :multiple="false" delete-icon="clear" style="width:100%" label="Choose files or drop files here" upload-path="fileuploader/upload/bukti_pengajuan" v-model="formData.bukti_pengajuan"  ></q-uploader-input>
                                                                    <!-- <small class="q-pa-sm text-negative"></small> -->
                                                                </div>
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
	import { required, numeric, } from 'src/services/validators';
	import { useMeta } from 'quasar';
	import { useApp } from 'src/composables/app.js';
	import { useEditPage } from 'src/composables/editpage.js';
	const props = defineProps({
		id: [String, Number],
		pageName: {
			type: String,
			default: 'voucher',
		},
		routeName: {
			type: String,
			default: 'voucheredit',
		},
		pagePath: {
			type : String,
			default : 'voucher/edit',
		},
		apiPath: {
			type: String,
			default: 'voucher/edit',
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
		tanggal: "", 
		nama_peminta: "", 
		jenis_kendaraan: "", 
		km_dashboard: "", 
		jenis_bbm: "", 
		jumlah_liter: "", 
		jumlah_harga: "", 
		total: "", 
		foto_dashboard: "", 
		foto_struk: "", 
		bukti_pengajuan: "", 
	}, props.pageData);
	const formData = reactive({ ...formDefaultValues });
	function onFormSubmited(response) {
		app.flashMsg(props.msgAfterUpdate);
		if(props.redirect) app.navigateTo(`/voucher`);
	}
	const rules = computed(() => {
		return {
			tanggal: { required },
			nama_peminta: { required },
			jenis_kendaraan: { required },
			km_dashboard: { required },
			jenis_bbm: { required },
			jumlah_liter: { required },
			jumlah_harga: { required },
			total: { required, numeric },
			foto_dashboard: { required },
			foto_struk: { required },
			bukti_pengajuan: { required }
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
		mapOptionField, // map api datasource  to Select options label-value
	} = page.methods;
	useMeta(() => {
		return {
			//set browser title
			title: "Edit Voucher"
		}
	});
</script>
<style scoped>
</style>
