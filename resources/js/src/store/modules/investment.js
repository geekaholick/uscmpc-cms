import * as InvestmentTypes from '@/store/types/investment'
import axios from '@/libs/axios'

export default {
    state: {
        investments: [],
        investment: {},
        investmentSearchParams: {},
    },
    getters: {
        [InvestmentTypes.GETTER_INVESTMENTS]: state => state.investments,
        [InvestmentTypes.GETTER_INVESTMENT]: state => state.investment,
        [InvestmentTypes.GETTER_INVESTMENT_SEARCH]: state => state.investmentSearchParams,
    },
    mutations: {
        [InvestmentTypes.MUTATION_INVESTMENTS]: (state, investments) => state.investments = investments,
        [InvestmentTypes.MUTATION_INVESTMENT]: (state, investment) => state.investment = investment,
        [InvestmentTypes.MUTATION_INVESTMENT_SEARCH]: (state, searchParams) => state.investmentSearchParams = searchParams
    },
    actions: {
        [InvestmentTypes.ACTION_INVESTMENTS]: async ({commit}) => {
            const response = await axios.get('investments/')
            if (response.data.success) {
                commit(InvestmentTypes.MUTATION_INVESTMENTS, response.data.data)
            }
            return response
        },
        [InvestmentTypes.ACTION_CREATE_INVESTMENT]: async ({dispatch, getters}) => {
            const investment = getters[InvestmentTypes.GETTER_INVESTMENT]

            const data = new FormData()
            // Test, Partial changes
            data.append('description',investment.description)
            data.append('title',investment.title)
            data.append('image', investment.image)
            data.append('icon', investment.icon || 'fa fa-search')

            const response = await axios.post('investments/', data)
            if (response.data.success) {
                dispatch(InvestmentTypes.ACTION_INVESTMENTS)
            }
            return response
        },
        [InvestmentTypes.ACTION_EDIT_INVESTMENT]: async ({dispatch, getters}) => {
            const investment = getters[InvestmentTypes.GETTER_INVESTMENT]
            const data = new FormData()
            // Test, Partial changes
            data.append('description',investment.description)
            data.append('title',investment.title)
            data.append('image', investment.image)
            data.append('icon', investment.icon || 'fa fa-search')
            
            const response = await axios.post(`/investments/${investment.id}`, data)
            if (response.data.success) {
                dispatch(InvestmentTypes.ACTION_INVESTMENTS)
            }
            return response
        },
        [InvestmentTypes.ACTION_DELETE_INVESTMENT]: async ({dispatch}) => {
            const investment = getters[InvestmentTypes.GETTER_INVESTMENT]
            const response = await axios.delete(`investments/${investment.id}`)
            if (response.success) {
                dispatch(InvestmentTypes.ACTION_INVESTMENTS)
            }
            return response
        }
    },
}
