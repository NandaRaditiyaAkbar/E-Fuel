<template>
    <q-page class="main-page">
        <section class="page-section q-mb-md" >
            <div class="container-fluid">
                <div class="row justify-center q-col-gutter-md">
                    <div class="col-12 col-sm-6 col-md-3 comp-grid" >
                        <q-card  :flat="isSubPage" class="text-center text-white bg-blue-1 q-mt-lg q-pa-md nice-shadow-6">
                            <div>
                                <div class="text-h5 text-bold text-primary q-pb-md">Fuel Tracking</div>
                                <q-avatar><q-img src="images/logo.png" /></q-avatar>
                            </div>
                        </q-card>
                        <q-card  :flat="isSubPage" class="nice-shadow-6">
                            <div >
                                <q-card-section class="q-px-lg">
                                    <q-form ref="observer" @submit.prevent="startLogin()">
                                    <q-input class="q-mb-md" label="Username Or Email" outlined dense placeholder="Username Or Email" v-model.trim="formData.username"  required="required" type="text" >
                                    <template v-slot:prepend>
                                        <q-icon name="account_circle"></q-icon>
                                    </template>
                                    </q-input>
                                    <q-input label="Password"  class="q-mb-md" outlined dense placeholder="Password" required="required" v-model="formData.password" type="password">
                                    <template v-slot:prepend>
                                        <q-icon name="lock"></q-icon>
                                    </template>
                                    </q-input>
                                    <div class="row q-mb-md">
                                        <div class="col-6">
                                            <q-checkbox v-model="rememberUser"> Remember Me</q-checkbox>
                                        </div>
                                        <div class="col-6">
                                            <q-btn to="/index/forgotpassword" class="text-danger" flat no-caps color="negative"> Reset Password?</q-btn>
                                        </div>
                                    </div>
                                    <transition appear enter-active-class="animated bounceIn" leave-active-class="animated fadeOut">
                                        <q-banner dense  inline-actions rounded  class="bg-red-2 q-my-md" v-if="loginErrorMsg">
                                            <template v-slot:avatar>
                                                <q-icon color="red" name="error"></q-icon>
                                            </template>
                                            {{ loginErrorMsg }}
                                            <template v-slot:action>
                                                <q-btn @click="loginErrorMsg = null" dense flat icon="close" />
                                                </template>
                                            </q-banner>
                                        </transition>
                                        <div class="text-center">
                                            <q-btn unelevated :loading="loading" color="primary" no-caps icon="lock_open" class="full-width"  type="submit"> 
                                                Login 
                                            </q-btn>
                                        </div>
                                        </q-form>
                                    </q-card-section>
                                </div>
                            </q-card>
                        </div>
                    </div>
                </div>
            </section>
        </q-page>
</template>
<script setup>
	import {  computed, ref, reactive } from 'vue';
	import { useApp } from "src/composables/app";
	import { useStore } from 'vuex'
	import { useRoute, useRouter } from 'vue-router';
	const props = defineProps({
		pageName: {
			type: String,
			default: 'index',
		},
		routeName: {
			type: String,
			default: 'index',
		},
		isSubPage: {
			type : Boolean,
			default : false,
		},
	});
	const route = useRoute();
	const router = useRouter();
	const store = useStore();
	const app = useApp();
	const formData = reactive({
		username: '',
		password:'',
	});
	const pageReady = ref(true);
	const loading = ref(false);
	const loginErrorMsg = ref('');
	const rememberUser = ref(false);
	async function startLogin (){
		try{
			loading.value = true;
			loginErrorMsg.value = '';
			let url = "/auth/login";
			let payload = {
				formData,
				rememberUser:rememberUser.value,
				url
			};
			const loginData= await store.dispatch('auth/login', payload);
			loading.value = false;
			if (loginData.token) {
				let nextUrl = route.query.nexturl || '/home'
				router.go(nextUrl);
			}
			else{
				router.push(loginData.nextpage);
			}
		}
		catch(error){
			loading.value = false;
			loginErrorMsg.value = error.request?.response || "Unable to establish connection...";
		}
	}
</script>
