import * as ConsumerStoreTypes from '../types/consumer_store'
import axios from '@/libs/axios'

console.log(ConsumerStoreTypes)
export default {
  state: {
    consumerstores: [],
    consumerstore: {},
    investmentSearchParams: {},
  },
  getters: {
    [ConsumerStoreTypes.GETTER_CONSUMER_STORES]: state => state.consumerstores,
    [ConsumerStoreTypes.GETTER_CONSUMER_STORE]: state => state.consumerstore,
    [ConsumerStoreTypes.GETTER_CONSUMER_STORE_SEARCH]: state => state.consumerstoreSearchParams,
  },
  mutations: {
    [ConsumerStoreTypes.MUTATION_CONSUMER_STORE]: (state, consumerstore) => { console.log(consumerstore); state.consumerstore = consumerstore },
    [ConsumerStoreTypes.MUTATION_CONSUMER_STORES]: (state, consumerstores) => { console.log(consumerstores); state.consumerstores = consumerstores },
    [ConsumerStoreTypes.MUTATION_CONSUMER_STORE_SEARCH]: (state, searchParams) => { state.consumerstoreSearchParams = searchParams },
  },
  actions: {
    [ConsumerStoreTypes.ACTION_CONSUMER_STORES]: async ({ commit }) => {
      const response = await axios.get('/consumer_stores')
      if (response.data.success) {
        commit(ConsumerStoreTypes.MUTATION_CONSUMER_STORES, response.data.data)
      }
      return response
    },
    [ConsumerStoreTypes.ACTION_CREATE_CONSUMER_STORE]: async ({ dispatch, getters }) => {
      const consumerstore = getters[ConsumerStoreTypes.GETTER_CONSUMER_STORE]

      const data = new FormData()

      data.append('item_name', consumerstore.item_name)
      data.append('price_item', consumerstore.price_item)
      data.append('price_batch', consumerstore.price_batch)
      data.append('description', consumerstore.description)
      data.append('status', consumerstore.status)
      data.append('effective_date', consumerstore.effective_date)
      const response = await axios.post('/consumer_store', data)
      if (response.data.success) {
        dispatch(ConsumerStoreTypes.ACTION_CONSUMER_STORES)
      }
      return response
    },

    [ConsumerStoreTypes.ACTION_EDIT_CONSUMER_STORE]: async ({ dispatch, getters }) => {
      const consumerstore = getters[ConsumerStoreTypes.GETTER_CONSUMER_STORE]
      // const data = new FormData()
      // data.append('item_name', consumerstore.item_name)
      // data.append('price_item', consumerstore.price_item)
      // data.append('price_batch', consumerstore.price_batch)
      // data.append('description', consumerstore.description)
      // data.append('status', consumerstore.status)
      // data.append('effective_date', consumerstore.effective_date)
      const response = await axios.put(`/consumer_stores/${consumerstore.id}`, consumerstore)
      if (response.data.success) {
        dispatch(ConsumerStoreTypes.ACTION_CONSUMER_STORES)
      }
      return response
    },
    [ConsumerStoreTypes.ACTION_DELETE_CONSUMER_STORE]: async ({ dispatch, getters }) => {
      const consumerstore = getters[ConsumerStoreTypes.GETTER_CONSUMER_STORE]
      const response = await axios.delete(`consumer_stores/${consumerstore.id}`)
      if (response.success) {
        dispatch(ConsumerStoreTypes.ACTION_CONSUMER_STORES)
      }
      return response
    },
  },
}
