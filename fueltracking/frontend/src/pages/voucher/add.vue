<template>
    <div class="main-page">
        <template v-if="showHeader">
            <q-card  :flat="isSubPage" class="page-section q-py-sm q-px-md q-mb-md nice-shadow-6" >
                <div class="container">
                    <div class="row justify-between q-col-gutter-md">
                        <div class="col-12 col-md-auto " >
                            <div class=" text-h6 text-primary" >
                                Add New Voucher
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
                                                    Tanggal *
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  v-model="formData.tanggal" label="Tanggal"    :error="isFieldValid('tanggal')" :error-message="getFieldError('tanggal')" >
                                                    <template v-slot:append>
                                                        <q-icon name="date_range" class="cursor-pointer">
                                                        <q-popup-proxy ref="ctrltanggal" transition-show="scale" transition-hide="scale">
                                                        <q-date   mask="MMM DD YYYY" v-model="formData.tanggal" @input="$refs.ctrltanggal.hide()" />
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
                                                    Nama Peminta 
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-select     outlined dense  ref="ctrlnama_peminta" emit-value map-options  v-model="formData.nama_peminta" :options="app.menus.nama_pemintaItems" label="Nama Peminta"  :error="isFieldValid('nama_peminta')" :error-message="getFieldError('nama_peminta')"   >
                                                    </q-select> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Jenis Kendaraan 
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  ref="ctrljenis_kendaraan" v-model.trim="formData.jenis_kendaraan"  label="Jenis Kendaraan" type="text" placeholder="Enter Jenis Kendaraan"   list="jenis_kendaraan_list"    
                                                    class="" :error="isFieldValid('jenis_kendaraan')" :error-message="getFieldError('jenis_kendaraan')">
                                                    </q-input>
                                                    <api-data-source   api-path="components_data/jenis_kendaraan_option_list"  v-slot="req">
                                                        <datalist id="jenis_kendaraan_list">
                                                        <option v-for="(menu, index) in req.response" :key="index" :value="menu.value">{{ menu.label }}</option>
                                                        </datalist>
                                                    </api-data-source>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Jenis Bbm 
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  ref="ctrljenis_bbm" v-model.trim="formData.jenis_bbm"  label="Jenis Bbm" type="text" placeholder="Enter Jenis Bbm"   list="jenis_bbm_list"    :click="setLiter(formData.jenis_bbm)"
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
                                                    Jumlah Liter 
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  ref="ctrljumlah_liter" v-model.trim="formData.jumlah_liter"  label="Jumlah Liter" type="number" placeholder="Enter Jumlah Liter"   step="any" :change="total(formData.jumlah_liter)"    
                                                    class="" :error="isFieldValid('jumlah_liter')" :error-message="getFieldError('jumlah_liter')">
                                                    </q-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Jumlah Harga 
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense prefix=""  ref="ctrljumlah_harga" v-model.trim="formData.jumlah_harga"  label="Jumlah Harga" type="text" placeholder="Enter Jumlah Harga"      
                                                    class="" :error="isFieldValid('jumlah_harga')" :error-message="getFieldError('jumlah_harga')">
                                                    </q-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Total 
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  ref="ctrltotal" v-model.trim="formData.total"  label="Total" type="text" placeholder="Enter Total"  
                                                    class="" :error="isFieldValid('total')" :error-message="getFieldError('total')"
                                                    >
                                                    </q-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Km Dashboard *
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  ref="ctrlkm_dashboard" v-model.trim="formData.km_dashboard"  label="Km Dashboard" type="text" placeholder="Enter Km Dashboard"   list="km_dashboard_list"    
                                                    class="" :error="isFieldValid('km_dashboard')" :error-message="getFieldError('km_dashboard')">
                                                    </q-input>
                                                    <datalist id="km_dashboard_list">
                                                    <option v-for="(menu, index) in app.menus.no_voucherItems" :key="index" :value="menu.value">{{ menu.label }}</option>
                                                    </datalist>
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
                                                        <q-uploader-input :max-files="1" :max-file-size="3" accept=".jpg,.png,.gif,.jpeg" :multiple="false" delete-icon="clear" style="width:100%" label="Masukkan foto dashboard mobil anda disini!!!" upload-path="fileuploader/upload/foto_dashboard" v-model="formData.foto_dashboard"></q-uploader-input>
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
                                                        <q-uploader-input :max-files="1" :max-file-size="3" accept=".jpg,.png,.gif,.jpeg" :multiple="false" delete-icon="clear" style="width:100%" label="Masukkan bukti pengajuan anda disini!!!" upload-path="fileuploader/upload/bukti_pengajuan" v-model="formData.bukti_pengajuan"></q-uploader-input>
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
                                                        <q-uploader-input :max-files="1" :max-file-size="3" accept=".jpg,.png,.gif,.jpeg" :multiple="false" delete-icon="clear" style="width:100%" label="Masukkan foto struk pembayaran disini!!!" upload-path="fileuploader/upload/foto_struk" v-model="formData.foto_struk"></q-uploader-input>
                                                        <!-- <small class="q-pa-sm text-negative"></small> -->
                                                    </div>
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
    import { required, numeric, } from 'src/services/validators';
    import { useMeta } from 'quasar';
    import { useApp } from 'src/composables/app.js';
    import { useAuth } from 'src/composables/auth';
    import { useAddPage } from 'src/composables/addpage.js';
    //[--PAGE-IMPORT-STATEMENT--]
    const props = defineProps({
        pageName : {
            type : String,
            default : 'voucher',
        },
        routeName : {
            type : String,
            default : 'voucheradd',
        },
        apiPath : {
            type : String,
            default : 'voucher/add',
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
    const app   = useApp();// application state and methods
    const auth  = useAuth();
    const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    const d     = new Date();
    const formDefaultValues = {
        tanggal: (d.getDate()+"-"+month[d.getMonth()]+"-"+d.getFullYear()),
        nama_peminta: auth.userName, 
        jenis_kendaraan: "", 
        jenis_bbm: "", 
        jumlah_liter: "",
        jumlah_harga: "", 
        total: "",
        km_dashboard: "", 
        foto_dashboard: "", 
        foto_struk: "", 
    };
    const formData = reactive({ ...formDefaultValues });
    //form validation rules
    const rules = computed(() => {
        return {
            tanggal: {  },
            nama_peminta: {  },
            jenis_kendaraan: {  },
            jenis_bbm: {  },
            jumlah_liter: { numeric },
            jumlah_harga: {  },
            total: {  },
            km_dashboard: { required },
            foto_dashboard: { required },
            foto_struk: { required }
        }
    });
    const v$ = useVuelidate(rules, formData); // form validation
    // page form hook
    const page = useAddPage({ props, formData, v$, beforeSubmit, afterSubmit });
    // perform custom validation before submit form
    // set custom form fields
    // return false if validation fails
    function beforeSubmit(){
        console.log(formData);
        return true;
    }
    // after form submited to api
    // reset form data.
    // redirect to another page
    function afterSubmit(response) {
        app.flashMsg(props.msgAfterSave);
        page.setFormDefaultValues(); //reset form data
        if(props.redirect) app.navigateTo(`/voucher`);
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
            title: "Add New Voucher"
        }
    });
    // expose page object for other components access
    defineExpose({
        page
    });
    function setLiter(data){
        if(formData.jenis_bbm=="Pertamax"){
        formData.jumlah_harga = "13900";
        }else if(formData.jenis_bbm=="Pertalite"){
        formData.jumlah_harga = "10000";
        }else if(formData.jenis_bbm=="Solar"){
        formData.jumlah_harga = "6800";
        }else if(formData.jenis_bbm=="Pertamax Turbo"){
        formData.jumlah_harga = "14300";
        }else if(formData.jenis_bbm=="Pertamina Dex"){
        formData.jumlah_harga = "18550";
        }else if(formData.jenis_bbm=="Dexlite"){
        formData.jumlah_harga = "18000";
        } 
    }
    function total(liter){
        var totalharga = liter * formData.jumlah_harga;
        formData.total = totalharga;
    }
</script>
<style scoped>
</style>
<style scoped>

</style>
