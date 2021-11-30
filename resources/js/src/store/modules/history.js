import * as types from "@/store/types/history";
import Api from "@/store/api/api";

const state = {
  data: [],
  successMessage: '',
  errorMessage: '',
}

const getters = {
  [types.GET_HISTORY]: states => states.data,
  [types.GET_SUCCESS_MSG]: states => states.successMessage,
  [types.GET_ERROR_MSG]: states => states.errorMessage,
}

const actions = {
  async [types.ACTION_HISTORY_REQUEST]({ commit }) {
    await Api()
      .get('/coop/history')
      .then(res => {
        commit(types.MUTATION_SET_HISTORY, res.data)
      })
      .catch(error => {
        commit(`There might some problem with serve -> ${error}`)
      })
  },

  async [types.ACTION_EDIT_HISTORY]({ commit }, details,config) {
    await Api()
      .post('/history/1', details, config)
      .then(res => {
        commit(types.MUTATION_EDIT_HISTORY, res.data.updated)
      })
      .catch(error => {
        commit(`Cannot update history -> ${error}`)
      })
  },

  async [types.ACTION_CREATE_DESCRIPTION]({ commit }, details) {
    commit(types.MUTATION_RESET_MESSAGES, '')
    await Api()
      .post('/history', details)
      .then(res => {
        commit(types.MUTATION_SET_HISTORY, res.data)
      })
      .catch(error => {
        commit(
          types.MUTATION_SET_ERROR_MSG,
          error.error || 'Something went wrong!',
        )
      })
  },
}

const mutations = {
  [types.MUTATION_SET_HISTORY](stateHistory, allHistory) {
    stateHistory.data = allHistory // eslint-disable-line no-param-reassign
  },
  [types.MUTATION_EDIT_HISTORY](updateHistory, history) {
    updateHistory.data = history
  },
  [types.MUTATION_SET_ERROR_MSG](states, message) {
    states.errorMessage = message
  },
  [types.MUTATION_RESET_MESSAGES](states, message) {
    states.successMessage = message
    states.errorMessage = message
  },
}
export default {
  state,
  getters,
  mutations,
  actions,
}
