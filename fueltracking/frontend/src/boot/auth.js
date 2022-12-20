
import { boot } from 'quasar/wrappers'
import { useAuth } from 'src/composables/auth'

export default boot(({ app, store, router }) => {
	const auth = useAuth(store);

	app.config.globalProperties.$auth = auth;
	
	
	router.beforeEach((to, from, next) => {
		const user = store.state.auth.user;
		let path = to.path;
	
		let authRequired = auth.pageRequiredAuth(path);
		if (authRequired) {
			if(!user){
				return next({ path: '/',  query: { nexturl: to.fullPath } });
			}
			//authorize user
			if (!auth.canView(path)) {
				return next({path: "/error/forbidden"});
			}
		}

		if(user && to.name == "index"){
			//already logged in, show home when try to access index page
			return next({ path: "/home"});
		}

		//navigate to redirect url if available
		if(to.name == "home" && to.query.nexturl){
			return next({ path: to.query.nexturl});
		}

		next();
	});

});
