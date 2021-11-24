<template>
  <div class="container">
    <!--Filter Container Card-->

    <b-card title="Filters">
      <b-row>
        <!-- <b-col
          cols="12"
          md="4"
          class="d-flex align-items-center mb-1"
        >
          Type of Event // comment this line if the code is in used
          <b-form-group class="w-100">
            <label>Type of Event</label>
            <v-select
              v-model="eventType"
              label="type"
              :options="option"
            />
          </b-form-group>
        </b-col> -->
        <b-col
          cols="12"
          md="4"
          class="d-flex align-items-center mb-1"
        >
          <!-- Event Status -->
          <b-form-group class="w-100">
            <label>Investment Status</label>
            <v-select
              v-model="searchParams.status"
              label="status"
              :options="investmentStatuses"
            />
          </b-form-group>
        </b-col>
        <!-- <b-col
          cols="12"
          md="4"
          class="d-flex align-items-center mb-1"
        >
          Reoccuring Event // comment this line if this code is in used
          <b-form-group class="w-100">
            <label>Reoccurring Event</label>
            <v-select
              v-model="reocurringEvent"
              label="option"
              :options="option2"
            />
          </b-form-group>
        </b-col> -->
      </b-row>
    </b-card>

    <!-- Table Container Card -->

    <b-card
      no-body
      class="mb-0"
    >
      <div class="m-2">
        <!-- Table Top -->
        <b-row>
          <!-- Per Page -->
          <b-col
            cols="12"
            md="3"
            class="d-flex align-items-center justify-content-start mb-1 mb-md-0"
          >
            <label>Show</label>
            <v-select
              v-model="perPage"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="perPageOptions"
              :clearable="false"
              class="per-page-selector d-inline-block mx-50"
            />
            <label>Entries</label>
          </b-col>
          <!-- Search -->
          <b-col
            cols="12"
            md="6"
          >
            <b-form-input
              placeholder="Search"
              class="w-100"
              v-model="searchParams.title"
            />
          </b-col>
          <!-- Add New Event -->
          <b-col
            cols="12"
            md="3"
            class="text-right"
          >
            <b-button
              variant="primary"
              type="button"
              to="/investment/new"
              @click="isAddNewUserSidebarActive = true"
            >Add New Invstment</b-button>
          </b-col>
        </b-row>
      </div>

      <b-table
        ref="refEventListTable"
        class="position-relative"
        :filter="searchQuery"
        :filter-included-fields="investmentTableFields"
        :items="investmentsCopy"
        :fields="investmentTableFields"
        :current-page="currentPage"
        responsive
        primary-key="id"
        show-empty
        empty-text="No matching records found"
        :per-page="perPage"
      >
        <!-- Column: Investment Icon -->
        <template #cell(icon)="data">
          <span><i :class="data.item.icon"></i></span>
          <!-- <b-media vertical-align="center">
            <b-link
              :to="{ name: 'apps-users-view', params: { id: data.item.id } }"
              class="font-weight-bold d-block text-nowrap"
            >{{ data.item.fullName }}</b-link>
            <small class="text-muted">@{{ data.item.username }}</small>
          </b-media> -->
        </template>

        <!-- Column: Event Description -->
        <template #cell(role)="data">
          <div class="text-nowrap">
            <feather-icon
              size="18"
              class="mr-50"
            />
            <span class="align-text-top text-capitalize">
              {{ data.item.role }}
            </span>
          </div>
        </template>

        <!-- Column: Event Organizer -->
        <template #cell(organiser)="data">
          <div class="text-nowrap">
            <feather-icon
              size="18"
              class="mr-50"
            />
            <span class="align-text-top text-capitalize">
              {{ data.item.role }}
            </span>
          </div>
        </template>

        <!-- Column: Status -->
        <template #cell(status)="data">
          <b-badge
            pill
            class="text-capitalize"
            :variant="(variantColor(data.item)).variant"
          >{{ data.item.status }}</b-badge>
        </template>

        <!-- Column: Actions -->
        <template #cell(actions)="data">
          <b-dropdown
            variant="link"
            :right="$store.state.appConfig.isRTL"
            no-caret
          >
            <template #button-content>
              <feather-icon
                icon="MoreVerticalIcon"
                size="16"
                class="align-middle text-body"
              />
            </template>
            <!-- <b-dropdown-item @click="setInvestment(data.item, 'view-investment')">
              <feather-icon icon="FileTextIcon" />
              <span class="align-middle ml-50">Details</span>
            </b-dropdown-item> -->

            <b-dropdown-item @click="setInvestment(data.item, 'edit-investment')">
              <feather-icon icon="EditIcon" />
              <span class="align-middle ml-50">Edit</span>
            </b-dropdown-item>

            <b-dropdown-item @click="setInvestment(data.item, 'list-investment', true)">
              <feather-icon icon="TrashIcon" />
              <span class="align-middle ml-50">Delete</span>
            </b-dropdown-item>
          </b-dropdown>
        </template>
      </b-table>

      <div class="mx-2 mb-2">
        <b-row>
          <!-- Pagination -->
          <center>
            <b-pagination
              v-model="currentPage"
              :total-rows="rows"
              :per-page="perPage"
              class="mb-0 mt-1 mt-sm-0"
              prev-class="prev-item"
              next-class="next-item"
            >
              <template #prev-text>
                <feather-icon
                  icon="ChevronLeftIcon"
                  size="18"
                />
              </template>
              <template #next-text>
                <feather-icon
                  icon="ChevronRightIcon"
                  size="18"
                />
              </template>
            </b-pagination>
          </center>
        </b-row>
      </div>
    </b-card>
  </div>
</template>

<script>
import {
  BPagination,
  BFormGroup,
  BFormInput,
  BButton,
  BBadge,
  BTable,
  BDropdown,
  BDropdownItem,
  BCol,
  BCard,
  BRow,
  BIcon,
} from 'bootstrap-vue'
import { mapGetters, mapActions, mapMutations } from 'vuex'
import vSelect from 'vue-select'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import * as InvestmentTypes from '../../../store/types/investment'

export default {
  components: {
    BPagination,
    BFormGroup,
    BFormInput,
    BButton,
    BBadge,
    BTable,
    BDropdown,
    BDropdownItem,
    BCol,
    BCard,
    BRow,
    vSelect,
    BIcon,
  },
  data: () => ({
    searchQuery: null,
    searchParams: {},
    perPageOptions: [10, 20, 30, 40, 50],
    perPage: 10,
    currentPage: 1,
    investmentsCopy:[],
    investmentTableFields: [
      {key: 'title', sortable: true},
      {key: 'icon', sortable: true},
      {key: 'status', sortable: true},
      {key: 'actions', sortable: true},
    ],
    dir: 'ltr',
    investmentStatuses: [
      { status: 'Active', variant: 'success', id: 1},
      { status: 'Inactive', variant: 'secondary', id: 0},
      { status: 'Removed', variant: 'warning', id: 2},
    ],
    option2: [{ option: 'Yes' }, { option: 'No' }],
  }),
  watch: {
    searchParams: {
      handler(newVal) {
        if (!newVal.status) newVal.status = null
        this[InvestmentTypes.MUTATION_INVESTMENT_SEARCH](newVal)
        this.filterInvestment()
      },
      deep: true,
    }
  },
  computed: {
    ...mapGetters({
      investments : InvestmentTypes.GETTER_INVESTMENTS,
      searchItems : InvestmentTypes.GETTER_INVESTMENT_SEARCH,
    }),
    rows() {
      return this.investmentsCopy.length
    }
  },
  async mounted() {
    await this[InvestmentTypes.ACTION_INVESTMENTS]()
    this[InvestmentTypes.MUTATION_INVESTMENT_SEARCH]({})
    this.investmentsCopy = this.investments
  },
  methods: {
    ...mapActions([InvestmentTypes.ACTION_INVESTMENTS, InvestmentTypes.ACTION_DELETE_INVESTMENT]),
    ...mapMutations([
        InvestmentTypes.MUTATION_INVESTMENT, 
        InvestmentTypes.MUTATION_INVESTMENT_SEARCH,
    ]),
    async setInvestment(investment, to, isDelete = false) {
      this[InvestmentTypes.MUTATION_INVESTMENT](investment)
      if (isDelete) {
        await this.deleteInvestment()
      }
      this.$router.push({name: to})
    },
    variantColor(data) {
      return this.investmentStatuses.find(investmentStatus => {
        return investmentStatus.status.toLowerCase() === data.status.toLowerCase()
      })
    },
    filterInvestment() {
      console.log(this.searchItems)
      let retVal = {title: false, status: false}
      keys.forEach(key => {
        this.investmentsCopy = this.investments.filter(investment => {
          return investment.title.toLowerCase().includes(this.searchItems.title ? 
                  this.searchItems.title.toLowerCase(): '') &&
                 investment.status.toLowerCase() === (this.searchItems.status ? 
                  this.searchItems.status.status.toLowerCase() : investment.status.toLowerCase())
        })
      })
    },
    async deleteInvestment() {
      const response = await this[InvestmentTypes.ACTION_DELETE_INVESTMENT]()
      if (response.success) {
        this.$toast({
              component: ToastificationContent,
              props: {
                title: 'Investment Deleted',
                icon: 'EditIcon',
                variant: 'success',
         },
        })
      } else {
        this.$toast({
              component: ToastificationContent,
              props: {
                title: 'Failed to Delete',
                icon: 'EditIcon',
                variant: 'danger',
              },
        })
      }
    },
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
</style>
