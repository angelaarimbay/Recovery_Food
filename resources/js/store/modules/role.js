import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  roles: []
}

// getters
export const getters = {
    roles: state => state.roles,
}

// mutations
export const mutations = {
    
    ['getRoles'](state,roles){
      state.roles = roles
    }
}

// actions
export const actions = {
    async fetchRoles ({ commit }) {
        try {
        const { data } = await axios.get('/api/roles')
        console.log(data)
        commit('getRoles',data)
        } catch (e) {
        }
    },

}
