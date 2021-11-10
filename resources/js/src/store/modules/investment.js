import * as InvestmentTypes from '@/store/types/investment'
import axios from '@/libs/axios'

export default {
    state: {
        investments: [],
        investment: {}
    },
    getters: {
        [InvestmentTypes.GETTER_INVESTMENTS]: state => state.investments,
        [InvestmentTypes.GETTER_INVESTMENT]: state => state.investment,
    },
    mutations: {
        [InvestmentTypes.MUTATION_INVESTMENTS]: (state, investments) => state.investments = investments,
        [InvestmentTypes.MUTATION_INVESTMENT]: (state, investment) => state.investment = investment, 
    },
    actions: {
        [InvesstmentTypes.ACTION_INVESTMENTS]: async ({commit}) => {
            const response = await axios.get('investments/')
            if (response.data.success) {
                commit(InvesstmentTypes.MUTATION_INVESTMENTS, response.data.data)
            }
        },
        [InvestmentTypes.ACTION_CREATE_INVESTMENT]: async ({dispatch}, investment) => {
            const response = await axios.post('investments/', investment)
            if (response.data.success) {
                dispatch(InvesstmentTypes.ACTION_INVESTMENTS)
            }
        },
        [InvestmentTypes.ACTION_EDIT_INVESTMENT]: async ({dispatch}, investment) => {
            const response = await axios.post('investments/', investment)
            if (response.data.success) {
                dispatch(InvesstmentTypes.ACTION_INVESTMENTS)
            }
        }
    },
}
