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
              v-model="investmentStatus"
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
        :items="investments"
        :fields="investmentTableFields"
        :current-page="currentPage"
        responsive
        primary-key="id"
        show-empty
        empty-text="No matching records found"
        :per-page="perPage"
      >
        <!-- Column: Event Name -->
        <template #cell(event)="data">
          <b-media vertical-align="center">
            <b-link
              :to="{ name: 'apps-users-view', params: { id: data.item.id } }"
              class="font-weight-bold d-block text-nowrap"
            >{{ data.item.fullName }}</b-link>
            <small class="text-muted">@{{ data.item.username }}</small>
          </b-media>
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
            no-caret
            :right="$store.state.appConfig.isRTL"
          >
            <template #button-content>
              <feather-icon
                icon="MoreVerticalIcon"
                size="16"
                class="align-middle text-body"
              />
            </template>
            <b-dropdown-item @click="setInvestment(data.item, 'view-investment')">
              <feather-icon icon="FileTextIcon" />
              <span class="align-middle ml-50">Details</span>
            </b-dropdown-item>

            <b-dropdown-item @click="setInvestment(data.item, 'edit-investment')">
              <feather-icon icon="EditIcon" />
              <span class="align-middle ml-50">Edit</span>
            </b-dropdown-item>

            <b-dropdown-item @click="setInvestment(data.item, 'list-investment')">
              <feather-icon icon="TrashIcon" />
              <span class="align-middle ml-50">Delete</span>
            </b-dropdown-item>
          </b-dropdown>
        </template>
      </b-table>

      <div class="mx-2 mb-2">
        <b-row>
          <b-col
            cols="12"
            sm="6"
            class="d-flex align-items-center justify-content-center justify-content-sm-start"
          >
          </b-col>
          <!-- Pagination -->
          <b-col
            cols="12"
            sm="6"
            class="d-flex align-items-center justify-content-center justify-content-sm-end"
          >
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
          </b-col>
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
} from 'bootstrap-vue'
import { mapGetters, mapActions, mapMutations } from 'vuex'
import vSelect from 'vue-select'
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
  },
  data: () => ({
    searchQuery: null,
    perPageOptions: [10, 20, 30, 40, 50],
    perPage: 10,
    currentPage: 1,
    eventType: null,
    investmentStatus: null,
    reocurringEvent: null,
    investmentTableFields: [
      'title',
      'icon',
      'status',
      'actions',
    ],
    dir: 'ltr',
    investmentStatuses: [
      { status: 'Active', variant: 'success', id: 1},
      { status: 'Inactive', variant: 'secondary', id: 0},
      { status: 'Removed', variant: 'warning', id: 2},
    ],
    option2: [{ option: 'Yes' }, { option: 'No' }],
  }),
  computed: {
    ...mapGetters({
      investments : InvestmentTypes.GETTER_INVESTMENTS
    }),
    rows() {
      return this.investments.length
    }
  },
  async mounted() {
    await this[InvestmentTypes.ACTION_INVESTMENTS]()
  },
  methods: {
    ...mapActions([InvestmentTypes.ACTION_INVESTMENTS]),
    ...mapMutations([InvestmentTypes.MUTATION_INVESTMENT]),
    setInvestment(investment, to) {
      this[InvestmentTypes.MUTATION_INVESTMENT](investment)
      this.$router.push({name: to})
    },
    variantColor(data) {
      return this.investmentStatuses.find(investmentStatus => {
        return investmentStatus.status.toLowerCase() === data.status.toLowerCase()
      })
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
</style>
