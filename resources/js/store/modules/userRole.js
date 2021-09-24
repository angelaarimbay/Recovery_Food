import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  users: []
}

// getters
export const getters = {
    users: state => state.users,
}

// mutations
export const mutations = {
    
    ['getUsersRoles'](state,users){
      state.users = users
    }
}

// actions
export const actions = {
    async fetchUsersRoles ({ commit }) {
        try {
        const { data } = await axios.get('/api/users')
        // console.log(data)
        commit('getUsersRoles',data)
        } catch (e) {
        }
    },

}
