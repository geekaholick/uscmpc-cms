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
            <label>Consumer Store</label>
            <b-form-select
              v-model="selectedStatus"
              label="status"
              :options="consumerStoreStatuses"
              @change="filterStatus"
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
              v-model="searchQuery"
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
              to="/banner/new"
              @click="isAddNewUserSidebarActive = true"
            >Add Consumer Store</b-button>
          </b-col>
        </b-row>
      </div>

      <b-table
        ref="refEventListTable"
        class="position-relative"
        :filter="searchQuery"
        :items="consumerStoreCopy"
        :fields="consumerStoreTableFields"
        :current-page="currentPage"
        responsive
        primary-key="id"
        show-empty
        empty-text="No matching records found"
        :per-page="perPage"
        :filter-included-fields="filterOn"
        @filtered="onFiltered"
      >
        <!-- Column: Investment Icon -->
        <template #cell(icon)="data">
          <span><i :class="data.item.icon" /></span>
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
            :variant="variantColor(data.item).variant"
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

            <b-dropdown-item
              @click="setconsumerStore(data.item, 'edit-consumerstore')"
            >
              <feather-icon icon="EditIcon" />
              <span class="align-middle ml-50">Edit</span>
            </b-dropdown-item>

            <b-dropdown-item
              @click="setconsumerStore(data.item, 'list-consumerstore', true)"
            >
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
  BFormSelect,
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
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import * as ConsumerStoreTypes from '../../../store/types/consumer_store'

export default {
  components: {
    BPagination,
    BFormGroup,
    BFormInput,
    BFormSelect,
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
    searchParams: {},
    selectedStatus: 'all',
    perPageOptions: [10, 20, 30, 40, 50],
    perPage: 10,
    filterOn: [],
    rows: 1,
    currentPage: 1,
    consumerStoreCopy: [],
    consumerStoreTableFields: [
      { key: 'item_name', label: 'name', sortable: true },
      { key: 'price_item', label: 'price', sortable: true },
      { key: 'price_batch', label: 'price batch', sortable: true },
      // { key: 'description', label: 'description', sortable: true },
      { key: 'status', label: 'status', sortable: true },
      { key: 'effective_date', label: 'effective_date', sortable: true },
      { key: 'actions', label: 'actions', sortable: true },
    ],
    dir: 'ltr',
    consumerStoreStatuses: [
      {
        status: 'All', variant: '', id: 3, text: 'All', value: 'all',
      },
      {
        status: 'Active', variant: 'success', id: 1, text: 'Active', value: 'active',
      },
      {
        status: 'Inactive',
        variant: 'secondary',
        id: 0,
        text: 'Inactive',
        value: 'inactive',
      },
      {
        status: 'Removed',
        variant: 'warning',
        id: 2,
        text: 'Removed',
        value: 'removed',
      },
    ],
    option2: [{ option: 'Yes' }, { option: 'No' }],
  }),
  computed: {
    ...mapGetters({
      consumerstores: ConsumerStoreTypes.GETTER_CONSUMER_STORES,
      searchItems: ConsumerStoreTypes.GETTER_CONSUMER_STORE_SEARCH,
    }),
    // rows() {
    //   return this.consumerStoreCopy.length
    // },
  },
  watch: {
    searchParams: {
      handler(newVal) {
        // eslint-disable-next-line no-param-reassign
        if (!newVal.status) newVal.status = null
        this[ConsumerStoreTypes.MUTATION_CONSUMER_STORE_SEARCH](newVal)
        this.filterConsumerStore()
      },
      deep: true,
    },
  },
  async mounted() {
    await this[ConsumerStoreTypes.ACTION_CONSUMER_STORES]()
    this[ConsumerStoreTypes.MUTATION_CONSUMER_STORE_SEARCH]({})
    this.consumerStoreCopy = this.consumerstores
  },
  methods: {
    ...mapActions([
      ConsumerStoreTypes.ACTION_CONSUMER_STORES,
      ConsumerStoreTypes.ACTION_DELETE_CONSUMER_STORE,
    ]),
    ...mapMutations([
      ConsumerStoreTypes.MUTATION_CONSUMER_STORE,
      ConsumerStoreTypes.MUTATION_CONSUMER_STORE_SEARCH,
    ]),
    async setconsumerStore(consumerstore, to, isDelete = false) {
      this[ConsumerStoreTypes.MUTATION_CONSUMER_STORE](consumerstore)
      if (isDelete) {
        await this.deleteConsumerStore()
        return
      }
      this.$router.push({ name: to })
    },
    variantColor(data) {
      return this.consumerStoreStatuses.find(
        consumerStoreStatus => consumerStoreStatus.status.toLowerCase()
          === data.status.toLowerCase(),
      )
    },
    filterConsumerStore() {
      const keys = Object.keys(this.searchItems)
      // let retVal = { title: false, status: false }
      keys.forEach(() => {
        this.consumerStoreCopy = this.inv.filter(
          consumerstore => consumerstore.title
            .toLowerCase()
            .includes(
              this.searchItems.title
                ? this.searchItems.title.toLowerCase()
                : '',
            )
            && consumerstore.status.toLowerCase()
              === (this.searchItems.status
                ? this.searchItems.status.status.toLowerCase()
                : consumerstore.status.toLowerCase()),
        )
      })
    },
    onFiltered(filteredItems) {
      this.rows = filteredItems.length
      this.currentPage = 1
    },

    filterStatus() {
      if (this.selectedStatus === 'all') {
        this.consumerStoreCopy = this.consumerstores
      } else {
        this.consumerStoreCopy = this.consumerstores.filter(item => item.status === this.selectedStatus)
      }
    },

    async deleteConsumerStore() {
      const response = await this[
        ConsumerStoreTypes.ACTION_DELETE_CONSUMER_STORE
      ]()
      console.log(response)
      if (response.data.success) {
        this.$toast({
          component: ToastificationContent,
          props: {
            title: 'Consumer Store Deleted',
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
