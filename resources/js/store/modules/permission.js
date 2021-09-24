import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  permissions: []
}

// getters
export const getters = {
    permissions: state => state.permissions,
}

// mutations
export const mutations = {
    
    ['getPermissions'](state,permissions){
      state.permissions = permissions
    }
}

// actions
export const actions = {
    async fetchPermissions ({ commit }) {
        try {
        const { data } = await axios.get('/api/permissions')
        console.log(data)
        commit('getPermissions',data)
        } catch (e) {
        }
    },

}
