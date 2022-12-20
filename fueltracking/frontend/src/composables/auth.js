
import { utils } from 'src/utils';
import {useStore} from 'vuex';
const publicPages = ['/', '/index', '/error']; //public pages which do not need authentation
const excludedRoutes = []; //public pages which do not need authentation
const roleAbilities = {
  "super admin": [],
  "fdo": [],
  "drivers": [],
  "finance": [],
  "admin spbu": []
};

export function useAuth(bootStore) {
	let store = null;

	if (bootStore) store = bootStore;
	else store = useStore();

	const user = store.state.auth.user;
	const userRole = store.getters["auth/getUserRole"];

	let isLoggedIn = false;
	let userName = null;
	let userEmail = null;
	let userId = null;
	let userPhoto = null;
	let userPhone = null;

	if(user){
		isLoggedIn = true;
		userName = user.name;
		userId = user.id;
		userEmail = user.email;
		
		userPhone = user.telephone;
	}
	const pageRequiredAuth = function(path){
		let pagePath = utils.getPagePath(path);
		let routePath = utils.getRoutePath(path);
		let authRequired = true;
		if(publicPages.includes(pagePath) || excludedRoutes.includes(routePath)){
			authRequired = false;
		}
		return authRequired
	}

	function saveLoginData(loginData, rememberUser) {
		const payload =  { loginData, rememberUser };
		store.dispatch('auth/saveLoginData', payload);
	}
	
	function logout() {
		store.dispatch('auth/logout');
	}
	
	const canView = function(path){
		let routePath = utils.getRoutePath(path);
		const userPages = store.state.auth.userPages;
		return userPages.includes(routePath) || excludedRoutes.includes(routePath);
	}

	const canManage = function(page, userRecId){
		if(userRole){
			let userRoleAbilities = roleAbilities[userRole.toLowerCase()] || [];
			if (userRoleAbilities.includes(page)){
				return true;
			}
		}
		return userRecId === userId;
	}

	const isOwner = function(userRecId){
		if(user){
			return userRecId == userId;
		}
		return false;
	}

	
	const isSuperAdmin = userRole.toLowerCase() === 'super admin';

	const isFdo = userRole.toLowerCase() === 'fdo';

	const isDrivers = userRole.toLowerCase() === 'drivers';

	const isFinance = userRole.toLowerCase() === 'finance';

	const isAdminSpbu = userRole.toLowerCase() === 'admin spbu';


	return {
		isLoggedIn,
		user,
		userName,
		userId,
		userEmail,
		userPhone,
		userPhoto,
		userRole,
		canView,
		canManage,
		isOwner,
		pageRequiredAuth,
		logout,
		saveLoginData,
		isSuperAdmin, isFdo, isDrivers, isFinance, isAdminSpbu
	}
}
