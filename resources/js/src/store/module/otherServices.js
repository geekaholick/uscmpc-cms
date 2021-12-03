import Api from '../../services/api'
import * as types from '../types/otherServices'

export default {
  // namespaced: true,
  state: {
    otherServices: [],
    otherService: {},
    successMessage: '',
    errorMessage: '',
  },
  getters: {
    [types.GETTER_OTHER_SERVICES]: state => state.otherServices,
    [types.GETTER_OTHER_SERVICE]: state => state.otherService,
    [types.GETTER_SUCCESS_MESSAGE]: state => state.successMessage,
    [types.GETTER_ERROR_MESSAGE]: state => state.errorMessage
  },
  actions: {

    async [types.ACTION_GET_OTHER_SERVICES]({ commit }) {
      commit(types.MUTATION_CLEAR_MESSAGES, '')
      await Api()
        .get("/otherServices")
        .then(res => {
          console.log(res.data);
          commit(types.MUTATION_SET_OTHER_SERVICES, res.data);
        })
        .catch(error => {
          commit(types.MUTATION_ERROR_MESSAGE, error.error || 'Something went wrong!')
        })
    },

    async [types.ACTION_GET_OTHER_SERVICE]({ commit }, id) {
      await Api().get(`/otherService/${id}`).then(res => {
        commit(types.MUTATION_SET_OTHER_SERVICE, res.data)
      })
    },

    async [types.ACTION_DELETE_OTHER_SERVICE]({commit, dispatch}, id){
      commit(types.MUTATION_CLEAR_MESSAGES, '')
      return new Promise((resolve, reject) => {
        Api().delete(`otherService/${id}`).then(res => {
          dispatch(types.ACTION_GET_OTHER_SERVICES);
          resolve(res)
        })
        .catch(error => {
          commit(types.MUTATION_ERROR_MESSAGE, error.error || 'Something went wrong!')
          reject(error)
        })
      })
    },

    async [types.ACTION_UPDATE_OTHER_SERVICE]({ commit, getters }, otherService, header){
      commit(types.MUTATION_CLEAR_MESSAGES, '')
      const service = getters[types.GETTER_OTHER_SERVICE]
      console.log("ID ID ",service.id);
      await Api().post(`/otherService/${service.id}`, otherService, header).then(res => {
        console.log("result",res.data);
        commit(types.MUTATION_SET_OTHER_SERVICE, res.data)
      })
      .catch(error => {
        commit(types.MUTATION_ERROR_MESSAGE, error.error || 'Something went wrong!')
      })
    },

    async [types.ACTION_ADD_OTHER_SERVICE]({ commit }, otherService, header){
      commit(types.MUTATION_CLEAR_MESSAGES, '')
      await Api().post('/otherService', otherService, header).then(res => {
        commit(types.MUTATION_SET_OTHER_SERVICE, res.data)
        console.log("result",res.data);
      })
      .catch(error => {
        commit(types.MUTATION_ERROR_MESSAGE, error.error || 'Something went wrong!')
      })
    },

  },
  mutations: {
    [types.MUTATION_SET_OTHER_SERVICES](state, otherServices) {
      state.otherServices = otherServices
      state.successMessage = 'Changes has been saved!'
    },
    [types.MUTATION_SET_OTHER_SERVICE](state, otherService) {
      state.otherService = otherService
      state.successMessage = 'Changes has been saved!'
    },
    [types.MUTATION_CLEAR_MESSAGES](state, message) {
      state.successMessage = message
      state.errorMessage = message
    }
  },
}
