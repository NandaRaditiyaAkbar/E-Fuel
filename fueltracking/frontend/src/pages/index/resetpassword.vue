<template>
	<div class="container">
        <div class="row justify-center">
            <div class="col col-md-4">
				<q-card  flat bordered class="q-my-lg">
                    <q-card-section>
                        <div class="q-my-md">
                            <div class="text-h5 text-bold">Password Reset </div>
                        </div>
                        <q-form ref="observer" @submit.prevent="submitForm()">
							<div class="q-my-md">
								<q-input v-model="formData.password" outlined dense placeholder="New Password" type="password" :error="isFieldValid('password')" :error-message="getFieldError('password')" />
							</div>
							<div class="q-my-md">
								<q-input v-model="formData.confirm_password" outlined dense placeholder="Confirm new password" type="password" :error="isFieldValid('confirm_password')" :error-message="getFieldError('confirm_password')" />
							</div>
							<div class="col-md-3 col-sm-4">
								<q-btn    :rounded="false"  color="primary"  no-caps  unelevated   type="submit" icon-right="send" :loading="saving">
									<template v-slot:loading>
										<q-spinner-oval />
									</template>
									Change Password
								</q-btn>
							</div>
                        </q-form>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </div>
</template>
<script setup>
	import { computed, reactive, onMounted, toRefs } from 'vue';
	import {useRoute} from 'vue-router';
	import { useMeta } from 'quasar';
	import useVuelidate from '@vuelidate/core';
	import { required, sameAs, } from 'src/services/validators';
	import { useApp } from 'src/composables/app.js';
	import { useAddPage } from 'src/composables/addpage.js';
	import { $t } from 'src/services/i18n';
	const props = defineProps({
		pageName : {
			type : String,
			default : 'auth',
		},
		routeName : {
			type : String,
			default : 'resetpassword',
		},
		apiPath : {
			type : String,
			default : 'auth/resetpassword',
		},
	});
	const app = useApp();
	const route = useRoute();
	const formDefaultValues = {
		password: "",
		confirm_password: "",
		token: route.query.token,
		email: route.query.email
	}
	const formData = reactive({ ...formDefaultValues });
	function beforeSubmit(){
		return true;
	}
	// redirect to another page
	function onFormSubmited(response) {
		app.navigateTo("/index/resetpassword_completed");
	}
	//form validation rules
	const rules = computed(() => {
		return {
			password: { required },
			confirm_password: { required, sameAs: sameAs(formData.password, 'Password') }
		}
	});
	const v$ = useVuelidate(rules, formData); // form validation
	const page = useAddPage({ props, formData, v$, onFormSubmited, beforeSubmit });
	const { saving } = toRefs(page.state);
	//page methods
	const { submitForm, getFieldError, isFieldValid } = page.methods;
	useMeta(() => {
		return {
			//set browser title
			title:  "Reset Password"
		}
	});
</script>