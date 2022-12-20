
import { store } from 'quasar/wrappers'
import { createStore } from 'vuex';
import { app } from "./app.js"
import { auth } from "./auth.js"
import { kategori } from "./kategori.js"
import { pengajuan } from "./pengajuan.js"
import { roles } from "./roles.js"
import { tb_bahanbakar } from "./tb_bahanbakar.js"
import { track } from "./track.js"
import { users } from "./users.js"
import { voucher } from "./voucher.js"
/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default store(function (/* { ssrContext } */) {
  const Store = createStore({
    modules: {
      app,
      auth,
		kategori,
		pengajuan,
		roles,
		tb_bahanbakar,
		track,
		users,
		voucher
    },
    // enable strict mode (adds overhead!)
    // for dev mode and --debug builds only
   // strict: process.env.DEBUGGING
  })
  return Store
})