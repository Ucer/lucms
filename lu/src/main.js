// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import iView from 'iview'
import i18n from '@/locale'
import config from '@/config'
import importDirective from '@/directive'
import 'iview/dist/styles/iview.css'
import './index.less'
import '@/assets/icons/iconfont.css'
import Highlight from '@/libs/highlight.js'

import apiRequest from './libs/api.request'
import appUrl from '../config/url'
import Cookies from 'js-cookie'
import {TOKEN_KEY} from '@/libs/util'

window.access_token = Cookies.get(TOKEN_KEY)

window.uploadUrl = {
  uploadAvatar: appUrl + 'api/upload/avatar',
  uploadAdvertisement: appUrl + 'api/upload/advertisement',
  uploadWang: appUrl + 'api/upload/wang',
  uploadTmp: appUrl + 'api/upload/tmp',
  uploadNewVersion: appUrl + 'api/upload/new_version',
  importExcelAdvertisementPosition: appUrl + 'api/excels/import/advertisement_positions'
}
window.exportExcelUrl = {
  exportAdvertisementPosition: appUrl + 'api/excels/export/advertisement_positions'
}

Vue.use(iView, {
  i18n: (key, value) => i18n.t(key, value)
})

Vue.use(Highlight)
Vue.config.productionTip = false
/* @description 全局注册应用配置 */
Vue.prototype.$config = config
/* 注册指令 */
importDirective(Vue)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  i18n,
  store,
  render: h => h(App)
})
