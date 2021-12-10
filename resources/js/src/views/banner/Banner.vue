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
          label="Status"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          label-for="sortBySelect"
          class="mb-0"
        >
          <b-input-group>
            <b-form-select
              id="sortBySelect"
              v-model="sortBy"
              :options="sortOptions"
              class="w-75"
              @change="sortByStatus()"
            >
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
          label-for="filterInput"
          class="mb-0"
        >
          <b-input-group>
            <b-form-input
              id="filterInput"
              v-model="filter"
              type="search"
              placeholder="Type to Search"
            />
            <b-input-group-append>
              <router-link to="/bannerform/new">
                <b-button
                  v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                  variant="primary"
                  class="ml-2"
                >
                  Add Banner
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
          show-empty
          empty-text="No matching records found"
          :per-page="perPage"
          :current-page="currentPage"
          :items="items"
          :fields="fields"
          :filter="filter"
          :filter-included-fields="filterOn"
          @filtered="onFiltered"
        >
          <template #cell(image)="data">
            <b-avatar
              :src="data.value"
              size="lg"
            />
          </template>

          <template #cell(logo)="data">
            <b-avatar :src="data.value" />
          </template>

          <template #cell(status)="data">
            <b-badge :variant="status[1][data.value]">
              {{ status[0][data.value] }}
            </b-badge>
          </template>

          <template #cell(actions)="data">
            <b-dropdown
              v-if="data.item.status !== 2"
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
              <!-- Edit -->
              <b-dropdown-item
                :to="{
                  name: 'bannerform',
                  params: { id: data.item.id },
                }"
              >
                <feather-icon icon="EditIcon" />
                <span class="align-middle ml-50">Edit</span>
              </b-dropdown-item>
              <b-dropdown-item @click="deleteBanner(data.item.id)">
                <feather-icon icon="TrashIcon" />
                <span class="align-middle ml-50">Delete</span>
              </b-dropdown-item>
            </b-dropdown>
          </template>
        </b-table>
      </b-col>

      <b-col cols="12" v-if="items.length > 0">
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
import * as bannerTypes from '@/store/types/banner'

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
      perPage: 5,
      pageOptions: [5, 10, 20],
      totalRows: 1,
      currentPage: 1,
      sortBy: 3,
      sortOptions: [
        {value: 3, text: 'All'},
        {value: 0, text: 'Inactive'},
        {value: 1, text: 'Active'},
        {value: 2, text: 'Removed'},
      ],
      filter: null,
      filterOn: [],
      show: false,
      infoModal: {
        id: 'info-modal',
        title: '',
        content: '',
      },
      fields: [
        {
          key: 'image',
          label: 'Image',
        },
        { key: 'logo', label: 'Logo' },
        { key: 'title', label: 'Title', sortable: true },
        { key: 'subtitle', label: 'Subtitle', sortable: true },
        { key: 'button_text', label: 'Button Text', sortable: true },
        { key: 'link', label: 'Link', sortable: true },
        { key: 'status', label: 'Status', sortable: true },
        { key: 'actions' },
      ],
      items: [],
      status: [
        {
          0: 'Inactive',
          1: 'Active',
          2: 'Removed',
        },
        {
          0: 'light-warning',
          1: 'light-success',
          2: 'light-danger',
        },
      ],
    }
  },
  computed: {
    ...mapGetters({
      banners: bannerTypes.GETTER_BANNERS,
      successMessgae: bannerTypes.GETTER_SUCCESS_MESSAGE,
      errorMessage: bannerTypes.GETTER_ERROR_MESSAGE,
    }),
  },
  mounted() {
    // Set the initial number of items
    this.totalRows = this.items.length
  },
  created() {
    this.show = true
    this.getBanners().then(() => {
      this.items = this.banners
      this.totalRows = this.banners.length
      this.show = false
    })
  },
  methods: {
    ...mapActions({
      getBanners: bannerTypes.ACTION_GET_BANNERS,
      removeBanner: bannerTypes.ACTION_DELETE_BANNER,
    }),
    deleteBanner(id) {
      this.show = true
      this.removeBanner(id).then(() => {
        this.items = this.banners
        this.toastMessage()
        this.show = false
      })
    },
    info(item, index, button) {
      this.infoModal.title = `Row index: ${index}`
      this.infoModal.content = JSON.stringify(item, null, 2)
      this.$root.$emit('bv::show::modal', this.infoModal.id, button)
    },
    resetInfoModal() {
      this.infoModal.title = ''
      this.infoModal.content = ''
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length
      this.currentPage = 1
    },
    sortByStatus() {
      if (this.sortBy === 3) {
        this.items = this.banners
        this.totalRows = this.banners.length
      }else {
        const newItems = this.banners.filter(item => item.status === this.sortBy)
        this.items = newItems
        this.totalRows = newItems.length
      }
    },
    toastMessage() {
      // this.isSaving = false
      this.$toast({
        component: ToastificationContent,
        props: {
          title: this.successMessgae ? this.successMessgae : this.errorMessage,
          icon: this.successMessgae ? 'CheckIcon' : 'AlertCircleIcon',
          variant: this.successMessgae ? 'success' : 'danger',
        },
      })
    },
  },
}
</script>
