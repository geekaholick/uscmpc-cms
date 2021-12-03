<template>
  <b-overlay
    :show="show"
    rounded="sm"
  >
    <b-row>
      <b-col
        md="2"
        sm="4"
        class="my-1"
      >
        <b-form-group class="mb-0">
          <label class="d-inline-block text-sm-left mr-50">Per page</label>
          <b-form-select
            id="perPageSelect"
            v-model="perPage"
            size="sm"
            :options="pageOptions"
            class="w-50"
          />
        </b-form-group>
      </b-col>
      <b-col
        md="4"
        sm="8"
        class="my-1"
      >
        <b-form-group
          label="Sort"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          label-for="sortBySelect"
          class="mb-0"
        >
          <b-input-group size="sm">
            <b-form-select
              id="sortBySelect"
              v-model="sortBy"
              :options="sortOptions"
              class="w-75"
            >
              <template v-slot:first>
                <option value="">
                  -- none --
                </option>
              </template>
            </b-form-select>
            <b-form-select
              v-model="sortDesc"
              size="sm"
              :disabled="!sortBy"
              class="w-25"
            >
              <option :value="false">
                Asc
              </option>
              <option :value="true">
                Desc
              </option>
            </b-form-select>
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col
        md="6"
        class="my-1"
      >
        <b-form-group
          label="Filter"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          label-for="filterInput"
          class="mb-0"
        >
          <b-input-group size="sm">
            <b-form-input
              id="filterInput"
              v-model="filter"
              type="search"
              placeholder="Type to Search"
            />
            <b-input-group-append>
              <router-link to="/other-services/add">
                <b-button
                  v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                  variant="primary"
                  class="ml-2"
                >
                  Add Services
                </b-button>
              </router-link>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>

      <b-col cols="12">
        <b-table
          striped
          hover
          responsive
          :per-page="perPage"
          :current-page="currentPage"
          :items="items"
          :fields="fields"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          :sort-direction="sortDirection"
          :filter="filter"
          :filter-included-fields="filterOn"
          @filtered="onFiltered"
        >
          <!-- <template #cell(status)="data">
            <b-badge :variant="status[1][data.value]">
              {{ status[0][data.value] }}
            </b-badge>
          </template> -->

          <template #cell(actions)="data">
            <b-dropdown
              variant="link"
              no-caret
            >
              <template #button-content>
                <feather-icon
                  icon="MoreVerticalIcon"
                  size="16"
                  class="align-middle text-body"
                />
              </template>
              <b-dropdown-item
                :to="{
                  name: 'edit-other-services',
                  params: { id: data.item.id },
                }"
              >
                <feather-icon icon="EditIcon" />
                <span class="align-middle ml-50">Edit</span>
              </b-dropdown-item>
              <!-- <b-dropdown-item>
               <router-link to="/other-services/edit">
                <b-button
                  v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                  variant="primary"
                  class="ml-2"
                >
                  Add Services
                </b-button>
              </router-link>
              </b-dropdown-item> -->
              <b-dropdown-item @click="deleteService(data.item.id)">
                <feather-icon icon="TrashIcon" />
                <span class="align-middle ml-50">Delete</span>
              </b-dropdown-item>
            </b-dropdown>
          </template>
        </b-table>
      </b-col>

      <b-col cols="12">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="center"
          size="sm"
          class="my-0 float-right"
        />
      </b-col>
    </b-row>
  </b-overlay>
</template>

<script>
import {
  BTable,
  BAvatar,
  BBadge,
  BRow,
  BCol,
  BFormGroup,
  BFormSelect,
  BPagination,
  BInputGroup,
  BFormInput,
  BInputGroupAppend,
  BButton,
  BDropdown,
  BDropdownItem,
  BOverlay,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { mapActions, mapGetters } from 'vuex'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import * as types from '@/store/types/otherServices.js'
export default {
  components: {
    BTable,
    BAvatar,
    BBadge,
    BRow,
    BCol,
    BFormGroup,
    BFormSelect,
    BPagination,
    BInputGroup,
    BFormInput,
    BInputGroupAppend,
    BButton,
    BDropdown,
    BDropdownItem,
    BOverlay,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      errorMessage: 'Something went wrong!',
      successMessage: '',
      perPage: 3,
      pageOptions: [3, 5, 10],
      totalRows: 1,
      currentPage: 1,
      sortBy: '',
      sortDesc: false,
      sortDirection: 'asc',
      filter: null,
      filterOn: [],
      show: false,
    //   infoModal: {
    //     id: 'info-modal',
    //     title: '',
    //     content: '',
    //   },
      fields: [
        // {
        //   key: 'image',
        //   label: 'Image',
        // },
        // { key: 'logo', label: 'Logo' },
        { key: 'title', label: 'Title', sortable: true },
        { key: 'description', label: 'Description', sortable: true },
        { key: 'status', label: 'Status', sortable: true },
        { key: 'actions' },
      ],
      items: [],
    //   status: [
    //     {
    //       0: 'Inactive',
    //       1: 'Active',
    //       2: 'Removed',
    //     },
    //     {
    //       0: 'light-warning',
    //       1: 'light-success',
    //       2: 'light-danger',
    //     },
    //   ],
    }
  },
  computed: {
    ...mapGetters({
      otherServices: types.GETTER_OTHER_SERVICES,
      // successMessgae: types.GETTER_SUCCESS_MESSAGE,
      // errorMessage: types.GETTER_ERROR_MESSAGE,
    }),
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter(f => f.sortable)
        .map(f => ({ text: f.label, value: f.key }))
    },
  },
  watch: {
    otherServices(newval) {
      this.items = newval
    }
  },
  mounted() {
    // Set the initial number of items
    this.totalRows = this.items.length
  },
  created() {
    this.show = true
    this.getOtherServices().then(() => {
      this.items = this.otherServices
      this.totalRows = this.otherServices.length
      this.show = false
    })
  },
  methods: {
    ...mapActions({
      getOtherServices: types.ACTION_GET_OTHER_SERVICES,
      removeService: types.ACTION_DELETE_OTHER_SERVICE,
    }),
    deleteService(id) {

      this.show = true
      this.removeService(id).then((res) => {
        this.items = this.otherServices
        // manual setting
        if (res.data.success) {
          this.successMessage = 'Successfully deleted!'
        }
        this.toastMessage()
        this.show = false
      })
    },
    // info(item, index, button) {
    //   this.infoModal.title = `Row index: ${index}`
    //   this.infoModal.content = JSON.stringify(item, null, 2)
    //   this.$root.$emit('bv::show::modal', this.infoModal.id, button)
    // },
    // resetInfoModal() {
    //   this.infoModal.title = ''
    //   this.infoModal.content = ''
    // },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length
      this.currentPage = 1
    },
    toastMessage() {
      // this.isSaving = false
      this.$toast({
        component: ToastificationContent,
        props: {
          title: this.successMessage ? this.successMessage : this.errorMessage,
          icon: this.successMessage ? 'CheckIcon' : 'AlertCircleIcon',
          variant: this.successMessage ? 'success' : 'danger',
        },
      })
    },
  },
}
</script>