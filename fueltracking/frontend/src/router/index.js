
import { route } from 'quasar/wrappers'
import { createRouter, createMemoryHistory, createWebHistory, createWebHashHistory } from 'vue-router'

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Router instance.
 */

let routes = [{
	name: 'main',
	path: '/',
	component: () => import('layouts/MainLayout.vue'),
	children: [
		//Dashboard routes


//kategori routes
		{ path: '/kategori', name: 'kategorilist', component: () => import('pages/kategori/list.vue'), props: true },
		{ path: '/kategori/index/:fieldName?/:fieldValue?', component: () => import('pages/kategori/list.vue'), props: true },
		{ path: '/kategori/view/:id', name: 'kategoriview', component: () => import('pages/kategori/view.vue'), props: true },
		{ path: '/kategori/add', name: 'kategoriadd', component: () => import('pages/kategori/add.vue'), props: true },
		{ path: '/kategori/edit/:id', name: 'kategoriedit', component: () => import('pages/kategori/edit.vue'), props: true },

//model_has_permissions routes

//model_has_roles routes
		{ path: '/model_has_roles', name: 'model_has_roleslist', component: () => import('pages/model_has_roles/list.vue'), props: true },
		{ path: '/model_has_roles/index/:fieldName?/:fieldValue?', component: () => import('pages/model_has_roles/list.vue'), props: true },
		{ path: '/model_has_roles/view/:id', name: 'model_has_rolesview', component: () => import('pages/model_has_roles/view.vue'), props: true },
		{ path: '/model_has_roles/add', name: 'model_has_rolesadd', component: () => import('pages/model_has_roles/add.vue'), props: true },
		{ path: '/model_has_roles/edit/:id', name: 'model_has_rolesedit', component: () => import('pages/model_has_roles/edit.vue'), props: true },

//pengajuan routes
		{ path: '/pengajuan', name: 'pengajuanlist', component: () => import('pages/pengajuan/list.vue'), props: true },
		{ path: '/pengajuan/index/:fieldName?/:fieldValue?', component: () => import('pages/pengajuan/list.vue'), props: true },
		{ path: '/pengajuan/view/:id', name: 'pengajuanview', component: () => import('pages/pengajuan/view.vue'), props: true },
		{ path: '/pengajuan/add', name: 'pengajuanadd', component: () => import('pages/pengajuan/add.vue'), props: true },
		{ path: '/pengajuan/edit/:id', name: 'pengajuanedit', component: () => import('pages/pengajuan/edit.vue'), props: true },

//permissions routes

//role_has_permissions routes

//roles routes
		{ path: '/roles', name: 'roleslist', component: () => import('pages/roles/list.vue'), props: true },
		{ path: '/roles/index/:fieldName?/:fieldValue?', component: () => import('pages/roles/list.vue'), props: true },
		{ path: '/roles/view/:id', name: 'rolesview', component: () => import('pages/roles/view.vue'), props: true },
		{ path: '/roles/add', name: 'rolesadd', component: () => import('pages/roles/add.vue'), props: true },
		{ path: '/roles/edit/:id', name: 'rolesedit', component: () => import('pages/roles/edit.vue'), props: true },

//tb_bahanbakar routes
		{ path: '/tb_bahanbakar', name: 'tb_bahanbakarlist', component: () => import('pages/tb_bahanbakar/list.vue'), props: true },
		{ path: '/tb_bahanbakar/index/:fieldName?/:fieldValue?', component: () => import('pages/tb_bahanbakar/list.vue'), props: true },
		{ path: '/tb_bahanbakar/view/:id', name: 'tb_bahanbakarview', component: () => import('pages/tb_bahanbakar/view.vue'), props: true },
		{ path: '/tb_bahanbakar/add', name: 'tb_bahanbakaradd', component: () => import('pages/tb_bahanbakar/add.vue'), props: true },
		{ path: '/tb_bahanbakar/edit/:id', name: 'tb_bahanbakaredit', component: () => import('pages/tb_bahanbakar/edit.vue'), props: true },

//track routes
		{ path: '/track', name: 'tracklist', component: () => import('pages/track/list.vue'), props: true },
		{ path: '/track/index/:fieldName?/:fieldValue?', component: () => import('pages/track/list.vue'), props: true },
		{ path: '/track/view/:id', name: 'trackview', component: () => import('pages/track/view.vue'), props: true },
		{ path: '/track/edit/:id', name: 'trackedit', component: () => import('pages/track/edit.vue'), props: true },

//users routes
		{ path: '/users', name: 'userslist', component: () => import('pages/users/list.vue'), props: true },
		{ path: '/users/index/:fieldName?/:fieldValue?', component: () => import('pages/users/list.vue'), props: true },
		{ path: '/users/view/:id', name: 'usersview', component: () => import('pages/users/view.vue'), props: true },
		{ path: '/account/edit', name: 'usersaccountedit', component: () => import('pages/account/accountedit.vue'), props: true },
		{ path: '/account', name: 'usersaccountview', component: () => import('pages/account/accountview.vue'), props: true },
		{ path: '/users/add', name: 'usersadd', component: () => import('pages/users/add.vue'), props: true },
		{ path: '/users/edit/:id', name: 'usersedit', component: () => import('pages/users/edit.vue'), props: true },

//voucher routes
		{ path: '/voucher', name: 'voucherlist', component: () => import('pages/voucher/list.vue'), props: true },
		{ path: '/voucher/index/:fieldName?/:fieldValue?', component: () => import('pages/voucher/list.vue'), props: true },
		{ path: '/voucher/view/:id', name: 'voucherview', component: () => import('pages/voucher/view.vue'), props: true },
		{ path: '/voucher/add', name: 'voucheradd', component: () => import('pages/voucher/add.vue'), props: true },
		{ path: '/voucher/edit/:id', name: 'voucheredit', component: () => import('pages/voucher/edit.vue'), props: true },

		
		
//Password reset routes
		{ path: '/index/forgotpassword', name: 'forgotpassword', component: () => import('pages/index/forgotpassword.vue') },
		{ path: '/index/resetpassword', name: 'resetpassword', component: () => import('pages/index/resetpassword.vue') },
		{ path: '/index/resetpassword_completed', name: 'resetpassword_completed', component: () => import('pages/index/resetpassword_completed.vue') },
		
		

//Error pages
		{ path:  '/error/forbidden', name: 'forbidden',  component: () => import('pages/errors/forbidden.vue') },
		{ path: '/error/notfound',  name: 'notfound', component: () => import('pages/errors/pagenotfound.vue') }
	],
	
	},
	{ path: '/:catchAll(.*)*', component: () => import('pages/errors/pagenotfound.vue') }
];

export default route(async function ({ store }) {
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : (process.env.VUE_ROUTER_MODE === 'history' ? createWebHistory : createWebHashHistory)
	
	let mainRoute = routes.find(x => x.name = "main");
	
	let loginToken = store.getters["auth/getLoginToken"];
	if(loginToken){
		try{
			await store.dispatch('auth/getUserData'); //get current user data from api on page load
		}
		catch(e){
			store.dispatch('auth/logout'); //token might have expired
			console.error(e);
		}
	}

	const user = store.state.auth.user;
	if(user){
		const homeRoute = {path: '/', alias: '/home', name: 'home', component: () => import('pages/home/home.vue') }
		mainRoute.children.push(homeRoute);
	}
	else{
		const indexRoute = { path: '/',  alias: '/home', name: 'index', component: () => import('pages/index/index.vue') }
		mainRoute.children.push(indexRoute);
	}


	const Router = createRouter({
    scrollBehavior: () => ({ left: 0, top: 0 }),
    routes,
    // Leave this as is and make changes in quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    // quasar.conf.js -> build -> publicPath
    history: createHistory(process.env.VUE_ROUTER_BASE)
  })
  return Router
})




