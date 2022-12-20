<template>
    <div class="main-page">
        <template v-if="showHeader">
            <q-card  :flat="isSubPage" class="page-section q-py-sm q-px-md q-mb-md nice-shadow-6" >
                <div class="container">
                    <div class="row justify-between q-col-gutter-md">
                        <div class="col-12 col-md-auto " >
                            <div class=" text-h6 text-primary" >
                                Add New Users
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
                                                    Name *
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <check-duplicate error-msg="Not available" v-model="formData.name" check-path="components_data/users_name_exist/" v-slot="checker">
                                                    <q-input outlined dense  ref="ctrlname" @blur="checker.check" :loading="checker.loading" v-model.trim="formData.name"  label="Name" type="text" placeholder="Enter Name"      
                                                    class="" :error="isFieldValid('name') || checker.alreadyExist" :error-message="getFieldError('name') || checker.errorMsg">
                                                    </q-input>
                                                    </check-duplicate>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Email *
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <check-duplicate error-msg="Not available" v-model="formData.email" check-path="components_data/users_email_exist/" v-slot="checker">
                                                    <q-input outlined dense  ref="ctrlemail" @blur="checker.check" :loading="checker.loading" v-model.trim="formData.email"  label="Email" type="email" placeholder="Enter Email"      
                                                    class="" :error="isFieldValid('email') || checker.alreadyExist" :error-message="getFieldError('email') || checker.errorMsg">
                                                    </q-input>
                                                    </check-duplicate>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Password *
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  ref="ctrlpassword" v-model="formData.password"  label="Password" :type="isPwd ? 'password' : 'text'" placeholder="Enter Password"      
                                                    class="" :error="isFieldValid('password')" :error-message="getFieldError('password')">
                                                    <template v-slot:append>
                                                        <q-icon
                                                        :name="isPwd ? 'visibility_off' : 'visibility'"
                                                        class="cursor-pointer"
                                                        @click="isPwd = !isPwd"
                                                        />
                                                    </template>
                                                    </q-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Confirm Password *
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  ref="ctrlconfirmpassword" v-model="formData.confirm_password" :type="isCPwd ? 'password' : 'text'" label="Confirm Password" placeholder="Confirm Password"  :error="isFieldValid('confirm_password')" :error-message="getFieldError('confirm_password')">
                                                    <template v-slot:append>
                                                        <q-icon
                                                        :name="isCPwd ? 'visibility_off' : 'visibility'"
                                                        class="cursor-pointer"
                                                        @click="isCPwd = !isCPwd"
                                                        />
                                                    </template>
                                                    </q-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    Telephone 
                                                </div>
                                                <div class="col-sm-9 col-12">
                                                    <q-input outlined dense  ref="ctrltelephone" v-model.trim="formData.telephone"  label="Telephone" type="text" placeholder="Enter Telephone"      
                                                    class="" :error="isFieldValid('telephone')" :error-message="getFieldError('telephone')">
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
	import { required, email, sameAs, } from 'src/services/validators';
	import { useMeta } from 'quasar';
	import { useApp } from 'src/composables/app.js';
	import { useAddPage } from 'src/composables/addpage.js';
	const props = defineProps({
		pageName : {
			type : String,
			default : 'users',
		},
		routeName : {
			type : String,
			default : 'usersadd',
		},
		apiPath : {
			type : String,
			default : 'users/add',
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
		name: "NULL", 
		email: "", 
		password: "", 
		confirm_password: "", 
		telephone: "NULL", 
	};
	const formData = reactive({ ...formDefaultValues });
	//form validation rules
	const rules = computed(() => {
		return {
			name: { required },
			email: { required, email },
			password: { required },
			confirm_password: {required, sameAs: sameAs(formData.password, 'Password') },
			telephone: {  }
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
		if(props.redirect) app.navigateTo(`/users`);
	}
	//page state
	const {
		submitted, // form submitted state - Boolean
		saving, // form api submiting state - Boolean
		pageReady, // api data loaded successfully
		isPwd,
		isCPwd,
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
			title: "Add New Users"
		}
	});
	// expose page object for other components access
	defineExpose({
		page
	});
</script>
<style scoped>
</style>
