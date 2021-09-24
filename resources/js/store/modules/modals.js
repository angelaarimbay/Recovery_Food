import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  policy: ''
}

// getters
export const getters = {
    policy: state => state.policy
}

// mutations
export const mutations = {
    ['getData'] (state,  data ) {
        state.policy = data;
    },
}

// actions
export const actions = { 
   
}
