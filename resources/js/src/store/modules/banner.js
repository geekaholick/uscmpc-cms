import * as bannerTypes from "@/store/types/banner";
import Api from "@/store/api/api";

const state = {
  banners: [],
  banner: {},
  successMessage: '',
  errorMessage: '',
};

const getters = {
  [bannerTypes.GETTER_BANNERS]: states => states.banners,
  [bannerTypes.GETTER_BANNER]: states => states.banner,
  [bannerTypes.GETTER_SUCCESS_MESSAGE]: states => states.successMessage,
  [bannerTypes.GETTER_ERROR_MESSAGE]: states => states.errorMessage
};

const actions = {
  async [bannerTypes.ACTION_GET_BANNERS]({ commit }) {
    commit(bannerTypes.MUTATION_CLEAR_MESSAGES, '')
    await Api()
      .get("/all/banners")
      .then(res => {
        commit(bannerTypes.MUTATION_SET_BANNERS, res.data);
      })
      .catch(error => {
        commit(bannerTypes.MUTATION_ERROR_MESSAGE, error.error || 'Something went wrong!')
      })
  },

  async [bannerTypes.ACTION_GET_BANNER]({ commit }, id) {
    commit(bannerTypes.MUTATION_CLEAR_MESSAGES, '')
    await Api().get(`/banner/${id}`).then(res => {
      commit(bannerTypes.MUTATION_SET_BANNER, res.data)
    })
    .catch(error => {
      commit(bannerTypes.MUTATION_ERROR_MESSAGE, error.error || 'Something went wrong!')
    })
  },

  async [bannerTypes.ACTION_CREATE_BANNER]({ commit }, banner, header){
    commit(bannerTypes.MUTATION_CLEAR_MESSAGES, '')
    await Api().post('/banner', banner, header).then(res => {
      commit(bannerTypes.MUTATION_SET_BANNER, res.data)
    })
    .catch(error => {
      commit(bannerTypes.MUTATION_ERROR_MESSAGE, error.error || 'Something went wrong!')
    })
  },

  async [bannerTypes.ACTION_UPDATE_BANNER]({ commit }, banner, header){
    commit(bannerTypes.MUTATION_CLEAR_MESSAGES, '')
    await Api().post(`banner/${banner.get('id')}`, banner, header).then(res => {
      commit(bannerTypes.MUTATION_SET_BANNER, res.data)
    })
    .catch(error => {
      commit(bannerTypes.MUTATION_ERROR_MESSAGE, error.error || 'Something went wrong!')
    })
  },

  async [bannerTypes.ACTION_DELETE_BANNER]({ commit }, id){
    commit(bannerTypes.MUTATION_CLEAR_MESSAGES, '')
    await Api().delete(`banner/${id}`).then(res => {
      commit(bannerTypes.MUTATION_SET_BANNERS, res.data);
    })
    .catch(error => {
      commit(bannerTypes.MUTATION_ERROR_MESSAGE, error.error || 'Something went wrong!')
    })
  }
};

const mutations = {
  [bannerTypes.MUTATION_SET_BANNERS](states, banners) {
    states.banners = banners;
    states.successMessage = 'Changes has been saved!'
  },

  [bannerTypes.MUTATION_SET_BANNER](states, banner) {
    states.banner = banner
    states.successMessage = 'Changes has been saved!'
  },

  [bannerTypes.MUTATION_ERROR_MESSAGE](states, message) {
    states.errorMessage = message
  },

  [bannerTypes.MUTATION_CLEAR_MESSAGES](states, message) {
    states.successMessage = message
    states.errorMessage = message
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};