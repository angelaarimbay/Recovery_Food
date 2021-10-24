import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  class_container: []
}

// getters
export const getters = {
    class_container: state => state.class_container,
}

// mutations
export const mutations = { 
    ['container'](state,data){
      state.class_container = data
    }
}

// actions
export const actions = { 
}
