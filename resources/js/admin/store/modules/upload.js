import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  code: null,
  uploader: null
}

// getters
export const getters = {
  code: state => state.code,
  uploader: state => state.uploader,
}

// mutations
export const mutations = {

  [types.CODE_SAVE] (state, { code }) {
    state.code = code
  },
  [types.CODE_UPDATE] (state, { code }) {
    state.code = code
  },
  [types.Uploader] (state, { uploader }) {
    state.uploader = uploader
  }
}

// actions
export const actions = {
  saveCode ({ commit, dispatch }, payload) {
    commit(types.CODE_SAVE, payload)
  },

  updateCode ({ commit }, payload) {
    commit(types.CODE_UPDATE, payload)
  },
  setUploader: function({commit, dispatch}, payload) {
    commit(types.Uploader, payload)
  },
}
