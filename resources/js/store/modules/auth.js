import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  user: null,
  users: [],
  token: Cookies.get('token'),
  user_permissions: [],
  user_roles: [],
}

// getters
export const getters = {
  user: state => state.user,
  users: state => state.users,
  token: state => state.token,
  check: state => state.user !== null,
  user_permissions: state => state.user_permissions,
  user_roles: state => state.user_roles, 
}

// mutations
export const mutations = {
  [types.SAVE_TOKEN](state, { token, remember }) {
    state.token = token
    Cookies.set('token', token, { expires: remember ? 365 : null })

  },

  [types.FETCH_USER_SUCCESS](state, { user }) {
    state.user = user
  },

  [types.FETCH_USER_FAILURE](state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.LOGOUT](state) {
    state.user = null
    state.token = null 
    Cookies.remove('token')
  },

  [types.UPDATE_USER](state, { user }) {
    state.user = user
  },
  ['success_user_permissions'](state, { permissions }) {
    state.user_permissions = permissions
  },
  ['success_user_roles'](state, { roles }) {
    state.user_roles = roles
  },
  ['success_get_users'](state, users) {
    state.users = users
  }
}

// actions
export const actions = {
  saveToken({ commit, dispatch }, payload) { 
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser({ commit }) {
    try {
      await axios.get('/api/user').then(result=>{ 
        if(result.data){ 
           commit(types.FETCH_USER_SUCCESS, { user: result.data }) 
        }else{
          this.$store.dispatch('auth/logout')
        }
      })
     
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  updateUser({ commit }, payload) {
    commit(types.UPDATE_USER, payload)
  },

  async logout({ commit }) {
    try {
      // this.$auth.logout()
      await axios.post('/api/logout') 
    } catch (e) { }

    commit(types.LOGOUT)
  },

  async fetchOauthUrl(ctx, { provider }) {
    const { data } = await axios.post(`/api/oauth/${provider}`)

    return data.url
  },

  async fetchUserPermissions({ commit }) {
    try {
      const { data } = await axios.get('/api/user-permissions')
      // APP.USER_PERMISSIONS = data
      commit('success_user_permissions', { permissions: data })
    } catch (e) {
      // commit(types.FETCH_USER_FAILURE)
    }
  },

  async fetchUserRoles({ commit }) {
    try {
      const { data } = await axios.get('/api/user-roles')
      // APP.USER_ROLES = data
      commit('success_user_roles', { roles: data })
    } catch (e) {
      // commit(types.FETCH_USER_FAILURE)
    }
  },

  async fetchUsers({ state, commit }) {
    try {
      const { data } = await axios.get('/api/users')
      commit('success_get_users', data)
    } catch (e) {
      // commit(types.FETCH_USER_FAILURE)
    }
  }

}
