import Cookies from 'js-cookie';

import * as types from '../mutation-types';

import Util from '../../libs/util';

const user = {
    state: {
        access_token: null,
        access_token_type: null,
        current_user: null
    },
    actions: {
        login({commit}, userForm) {
            return new Promise(function (resolve, reject) {
                Util.ajax.post('/login', {
                    email: userForm.email,
                    password: userForm.password
                }).then(function (response) {
                    let response_data = response.data;
                    commit(types.LOGIN_SUCCESS, response_data.data);
                    resolve(response_data.data);
                }, function (error) {
                    reject(error);
                })

            })

        },
    },
    mutations: {
        [types.LOGIN_SUCCESS](state, data) {
            localStorage.refresh_token = data.token.refresh_token;
            localStorage.access_token = data.token.access_token;
            localStorage.access_token_type = data.token.token_type;
            localStorage.current_user = JSON.stringify(data.user);
        },
        logout(state, vm) {
            // 恢复默认样式
            let themeLink = document.querySelector('link[name="theme"]');
            themeLink.setAttribute('href', '');
            // 清空打开的页面等数据，但是保存主题数据
            let theme = '';
            if (localStorage.theme) {
                theme = localStorage.theme;
            }
            localStorage.clear();
            if (theme) {
                localStorage.theme = theme;
            }
        }
    }
};

export default user;
