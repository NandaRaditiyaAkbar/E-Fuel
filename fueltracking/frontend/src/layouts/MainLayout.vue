<template>
    <q-layout view="hHh LpR lfr">
        <template v-if="$auth.isLoggedIn">
            <!-- App header -->
            <q-header elevated >
                <q-toolbar class="  glossy">
                    <q-btn flat @click="toggleLeftDrawer" round dense icon="menu"></q-btn>
                    <!-- App logo and name -->
                    <q-btn no-caps flat stretch to="/home" class="q-mr-lg">
                        <q-avatar size="36">
                            <img src="images/logo.png" alt="logo" class="my-5" />
                        </q-avatar>
                        <q-toolbar-title>{{ $appName }}</q-toolbar-title>
                    </q-btn>
                    <q-separator inset dark vertical></q-separator>
                    <!-- Top menu left -->
                    <template v-for="(menu, index) in navbarTopLeftItems">
                        <q-btn no-caps :icon="menu.icon" stretch flat :label="menu.label" :to="menu.path" v-if="!menu.submenu.length" :key="`topleftmenubtn-${index}`"></q-btn>
                        <q-btn-dropdown  no-caps :icon="menu.icon" stretch flat :label="menu.label" v-else  :key="`topleftmenudrop-${index}`" >
                            <q-list dense>
                                <q-item v-for="(submenu, subindex) in menu.submenu" :key="`topleftsubmenu-${subindex}`" clickable v-ripple :to="submenu.path">
                                    <q-item-section avatar v-if="submenu.icon">
                                        <q-avatar :icon="submenu.icon"></q-avatar>
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label>{{ submenu.label }}</q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-btn-dropdown>
                    </template>
                    <q-space></q-space>
                    <!-- Top menu right -->
                    <template v-for="(menu, index) in navbarTopRightItems">
                        <q-btn  no-caps :icon="menu.icon" stretch flat :label="menu.label" :to="menu.path" v-if="!menu.submenu.length" :key="`toprightmenu-${index}`"></q-btn>
                        <q-btn-dropdown no-caps :icon="menu.icon" stretch flat :label="menu.label" v-else  :key="`toprightmenudrop-${index}`" >
                            <q-list dense>
                                <q-item v-for="(submenu, subindex) in menu.submenu" :key="`toprightsubmenu-${subindex}`" clickable v-ripple :to="submenu.path">
                                    <q-item-section avatar v-if="submenu.icon">
                                        <q-avatar :icon="submenu.icon"></q-avatar>
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label>{{ submenu.label }}</q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-btn-dropdown>
                    </template>
                    <q-btn-dropdown no-caps stretch unelevated icon="account_circle">
                        <q-list dense style="min-width:200px">
                            <q-item  clickable v-ripple to="/account">
                                <q-item-section avatar>
                                    <q-avatar icon="account_box"></q-avatar>
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>My Account</q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item  clickable v-ripple @click="startLogout()">
                                <q-item-section avatar>
                                    <q-avatar icon="exit_to_app"></q-avatar>
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>Logout</q-item-label>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-btn-dropdown>
                </q-toolbar>
            </q-header>
            <!-- App left drawer -->
            <q-drawer v-model="leftDrawer" show-if-above  :width="250" :breakpoint="500" bordered  elevated :mini="leftDrawerMini">
                <q-scroll-area class="fit   ">
                    <div class="text-center bg-primary q-pt-md">
                        <q-icon size="50px" color="white" name="account_box"></q-icon>
                        <div v-show="!leftDrawerMini" class="text-bold text-center text-capitalize q-pa-sm">
                            <span class="text-white">Hi {{ $auth.userName }}</span> 
                            <div v-if="$auth.userRole"><q-chip class="text-capitalize" dense>{{ $auth.userRole }}</q-chip></div>
                        </div>
                        <q-menu auto-close touch-position>
                            <q-list dense style="min-width:100px">
                                <q-item  clickable v-ripple to="/account">
                                    <q-item-section avatar>
                                        <q-avatar icon="account_box"></q-avatar>
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label>My Account</q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item  clickable v-ripple @click="startLogout()">
                                    <q-item-section avatar>
                                        <q-avatar icon="exit_to_app"></q-avatar>
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label>Logout</q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-menu>
                    </div>
                    <q-separator></q-separator>
                    <q-list >
                        <template v-for="(menu, index) in navbarSideLeftItems">
                            <q-item clickable q-ripple :to="menu.path" v-if="!menu.submenu.length" :key="`sideleftmenu-${index}`">
                                <q-item-section avatar v-if="menu.icon">
                                    <q-icon :color="menu.iconcolor || 'primary'" :name="menu.icon"></q-icon>
                                    <q-tooltip v-if="leftDrawerMini" transition-show="scale" transition-hide="scale" content-class="bg-accent" anchor="center right" self="center left" :offset="[10, 10]">
                                    {{ menu.label }}
                                    </q-tooltip>
                                </q-item-section>
                                <q-item-section>
                                    {{ menu.label }}
                                </q-item-section>
                            </q-item>
                            <q-expansion-item  expand-separator :content-inset-level="0.5" group="leftmenu" v-else :key="`sideleftmenudrop-${index}`">
                                <template v-slot:header>
                                    <q-item-section avatar v-if="menu.icon">
                                        <q-icon :color="menu.iconcolor || 'primary'" :name="menu.icon"></q-icon>
                                        <q-tooltip v-if="leftDrawerMini" transition-show="scale" transition-hide="scale" content-class="bg-accent" anchor="center right" self="center left" :offset="[10, 10]">
                                        {{ menu.label }}
                                        </q-tooltip>
                                    </q-item-section>
                                    <q-item-section>
                                        {{ menu.label }}
                                    </q-item-section>
                                </template>
                                <q-list dense>  
                                    <q-item :to="submenu.path" clickable q-ripple v-for="(submenu, subindex) in menu.submenu" :key="`sideleftsubmenubtn-${subindex}`">
                                        <q-item-section avatar v-if="submenu.icon">
                                            <q-icon :color="submenu.iconcolor || 'primary'" :name="submenu.icon"></q-icon>
                                        </q-item-section>
                                        <q-item-section>
                                            {{ submenu.label }}
                                        </q-item-section>
                                    </q-item>
                                </q-list>
                            </q-expansion-item>
                        </template>
                    </q-list>
                </q-scroll-area>
            </q-drawer>
        </template>
        <template v-else>
            <q-header elevated >
                <q-toolbar class="  glossy">
                    <q-btn no-caps flat stretch to="/home">
                        <q-avatar size="36">
                            <img src="images/logo.png" alt="logo" class="my-5" />
                        </q-avatar>
                        <q-toolbar-title>{{ $appName }}</q-toolbar-title>
                    </q-btn>
                </q-toolbar>
            </q-header>
        </template>
        <!-- App right drawer -->
        <q-drawer :no-swipe-open="!drawerComponentFile" side="right" v-model="showRightDrawer" :width="rightDrawer.width" :breakpoint="500" overlay  elevated>
            <component v-if="showRightDrawer" is-sub-page :is="drawerComponentFile" :api-path="rightDrawer.pageUrl" :page-data="rightDrawer.pageData" />
            <q-btn style="position:absolute;top:2px;right:2px" unelevated dense round color="grey-1" text-color="grey" icon="close" @click="showRightDrawer = false"></q-btn>
        </q-drawer>
        <!-- App layout container -->
        <q-page-container> 
            <router-view />
        </q-page-container>
        <!-- Page display dialog -->
        <q-dialog
            :seamless="pageDialog.seamless"
            :maximized="pageDialog.maximized"
            :persistent="pageDialog.persistent"
            :position="pageDialog.position"
            v-model="showPageDialog"
            >
            <q-card :style="{ width: pageDialog.width, maxWidth: pageDialog.maxWidth }">
                <component
                v-if="pageDialog.showDialog"
                is-sub-page
                :is="dialogComponentFile"
                :api-path="pageDialog.pageUrl"
                :page-data="pageDialog.pageData"
                />
                <q-btn style="position: absolute; top: 10px; right: 10px" v-if="pageDialog.closeBtn" icon="close" color="grey" flat round dense v-close-popup />
                </q-card>
            </q-dialog>
            <!-- image preview dialog-->
            <q-dialog v-model="showImageDialog">
                <q-carousel
                transition-prev="scale"
                transition-next="scale"
                swipeable
                animated
                control-type="unelevated"
                control-color="primary"
                v-model="imageDialog.currentSlide"
                :navigation="false"
                :arrows="imageDialog.images.length > 1"
                infinite
                :padding="false"
                height="auto"
                class="bg-dark rounded-borders"
                >
                <q-carousel-slide
                class="no-padding"
                v-for="(img, index) in imageDialog.images"
                :key="index"
                :name="index"
                >
                <img style="max-width: 100%; max-height: 100%" :src="img" />
                </q-carousel-slide>
                </q-carousel>
            </q-dialog>
            <!-- request error dialog -->
            <q-dialog v-model="errorDialog" position="top">
                <q-card style="min-width: 300px; max-width: 95vw">
                    <q-card-section class="row items-center align-start">
                        <q-avatar
                            text-color="negative"
                            size="40px"
                            font-size="36px"
                            icon="error"
                        ></q-avatar>
                        <div class="q-ml-sm">
                            <div class="text-weight-bold text-negative">Unable to complete request.</div>
                            <q-separator class="q-my-sm" />
                            <div class="text-capitalize" v-for="(msg, index) in pageErrors" :key="index">
                                {{ msg }}
                            </div>
                        </div>
                        <q-space />
                        <q-btn icon="close" flat round dense v-close-popup />
                        </q-card-section>
                    </q-card>
                </q-dialog>
            </q-layout>
</template>
<script setup>

	import { defineAsyncComponent, computed } from "vue";
	import { useQuasar } from 'quasar'
	import { useApp } from 'src/composables/app';
	import { useAuth } from 'src/composables/auth';
	import { useStore } from 'vuex';
	import { ApiService } from 'src/services/api';

	const $q = useQuasar();
	const app = useApp();
	const auth = useAuth();
	const store = useStore();
	const leftDrawer = computed ({
		get: function () {
			return store.state.app.leftDrawer;
		},
		set: function (value) {
			store.commit("app/setLeftDrawer", value);
		},
	});

	const leftDrawerMini = computed ({
		get: function () {
			return store.state.app.leftDrawerMini;
		},
		set: function (value) {
			store.commit("app/setLeftDrawerMini", value);
		},
	});
	const pageDialog = computed(() =>  store.state.app.pageDialog );
	const imageDialog = computed(() =>  store.state.app.imageDialog );
	const rightDrawer = computed(() =>  store.state.app.rightDrawer );

	const showPageDialog = computed ({
		get() {
			return pageDialog.value.showDialog
		},
		set(value) {
			store.dispatch("app/closePageDialog");
		},
	});

	const showImageDialog = computed ({
		get() {
			return imageDialog.value.showDialog
		},
		set(value) {
			store.dispatch("app/closeImageDialog");
		},
	});

	const showRightDrawer = computed ({
		get() {
			return rightDrawer.value.showDrawer;
		},
		set(value) {
			store.dispatch("app/closeRightDrawer");
		},
	});
	const pageErrors = computed ({
		get() {
			return store.state.app.pageErrors;
		},
		set(value) {
			store.commit("app/setPageErrors", value);
		},
	});

	const errorDialog = computed ({
		get() {
			return pageErrors.value.length > 0;
		},
		set(newValue) {
			pageErrors.value = [];
		}
	});

	const dialogComponentFile = computed(() => {
		const dialog = pageDialog.value;
		if(dialog.showDialog && dialog.pageComponent){
			return defineAsyncComponent(() => import(`src/pages/${dialog.pageComponent}.vue`));
		}
		return null;
	});

	const drawerComponentFile = computed(() => {
		const drawer = rightDrawer.value;
		if(drawer.showDrawer && drawer.pageComponent){
			return defineAsyncComponent(() => import(`src/pages/${drawer.pageComponent}.vue`));
		}
		return null;
	});
	function startLogout() {
		auth.logout();
		location.href = "/"; //reload page and navigate to index page
	}
	function toggleLeftDrawer() {
		if(leftDrawer.value && leftDrawerMini.value){
			leftDrawer.value = false;
		}
		else if(leftDrawer.value && !leftDrawerMini.value){
			leftDrawerMini.value = true;
		}
		else{
			leftDrawer.value = true;
			leftDrawerMini.value = false;
		}
	}
	const navbarSideLeftItems = app.menus.navbarSideLeftItems.filter((menu) => auth.canView(menu.path));
	const navbarTopLeftItems = app.menus.navbarTopLeftItems.filter((menu) => auth.canView(menu.path));
	const navbarTopRightItems = app.menus.navbarTopRightItems.filter((menu) => auth.canView(menu.path));
	// $route (to, from){
	// 	this.$store.dispatch("app/closeDialogs");
	// }
	function initAxioInterceptors(){
		// Add a request interceptor
		ApiService.axios().interceptors.request.use(
			(config) => {
				//before new request, hide previous error message
				pageErrors.value = [];
				return config;
			},
			(error) => {
			// Do something with request error
			return Promise.reject(error);
		});
	}
	initAxioInterceptors();
	leftDrawer.value = $q.platform.is.desktop;
	initAxioInterceptors();
</script>

<style></style>
<style lang="scss">
	body.body--light {
		background: #D3D3D3
	}
	.q-item.q-router-link--active, .q-item--active {
		background-color: grey-1
	}
	.q-item.q-router-link--active .q-icon, .q-item--active .q-icon {
	}

</style>
