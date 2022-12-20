
	
<template>
	<div class="container">
		<div class="row justify-center">
			<div class="col-md-7 col-12">
				<div class="text-h6 text-bold q-my-md">Change Password</div>
				<q-form ref="observer" @submit.prevent="submitForm()">
					<q-input  outlined dense  label="Current Password" placeholder="Current Password" v-model="formData.oldpassword"  type="password" :error="isFieldValid('oldpassword')" :error-message="getFieldError('oldpassword')" />
					
					<q-input  outlined dense  label="New Password" placeholder="New Password" v-model="formData.newpassword" type="password" :error="isFieldValid('newpassword')" :error-message="getFieldError('newpassword')" />
					
					<q-input outlined dense  label="Confirm new password" placeholder="Confirm new password" v-model="formData.confirmpassword" type="password"  :error="isFieldValid('confirmpassword')" :error-message="getFieldError('confirmpassword')"/>
					
					<div class="q-mt-md text-center">
						<q-btn unelevated type="submit" icon="send" color="primary" large :loading="saving">
							 Change Password

							 <template v-slot:loading>
								<q-spinner-oval />
							</template>
						</q-btn>
					</div>
				</q-form>
			</div>
		</div>
	</div>
</template>
<script setup>
	import {  computed, reactive, ref, toRefs } from 'vue';
	import useVuelidate from '@vuelidate/core';
	import { required, sameAs } from '@vuelidate/validators';
	import { useApp } from 'src/composables/app';
	import { useAddPage } from 'src/composables/addpage.js';
	const props = defineProps({
		pageName : {
			type : String,
			default : 'users',
		},
		apiPath: {
			type: String,
			default: 'account/changepassword'
		},
	});

	const app = useApp();
	
	const formData = reactive({
		oldpassword: '', 
		newpassword: '', 
		confirmpassword: '', 
	});

	function onFormSubmited(response) {
		app.flashMsg("Password change completed");
		Object.assign(formData, { oldpassword: "", newpassword: "", confirmpassword: "" }); //reset form data

	}
	
	const rules = computed(() => {
		return {
			oldpassword: { required },
			newpassword: { required },
			confirmpassword: { required,  sameAs: sameAs(formData.newpassword) }
		}
	});

	const v$ = useVuelidate(rules, formData); // form validation
	const page = useAddPage({ props, formData, v$, onFormSubmited });

	const {
		submitForm, //submit form data to api
		isFieldValid, // check if field is validated - args(fieldname)
		getFieldError, //  get validation error message - args(fieldname)
	} = page.methods;

	//page state
	const {
		submitted, // form submitted state - Boolean
		saving, // form api submiting state - Boolean
	} = toRefs(page.state);

	

</script>
