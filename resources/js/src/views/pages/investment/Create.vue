<template>
  <div>
    <b-card title="Fill the needed Information">
      <validation-observer ref="">
        <b-form @submit.prevent>
          <validation-provider
            #default="{ errors }"
            name="InvestmentTitle"
            rules="required"
          >
            <b-form-group label="Title">
              <b-form-input
                id="investment-title"
                v-model="investment.type"
                :state="errors.length > 0 ? false : null"
                name="event-venue"
                placeholder="Event Type"
              />
            </b-form-group>
          </validation-provider>
          <b-form-group label="Investment Image">
            <b-form-file
              ref="img"
              multiple
              @change="showImages"
            />
            <div
              v-show="img.length"
              id="dropdown-cont"
            >
              <b-dropdown
                ref="imageListDropdown"
                text="Image/s to upload"
              >
                <b-dropdown-item
                  v-for="item in img"
                  :key="item.lastModified"
                >
                  {{ item.name }}
                </b-dropdown-item>
              </b-dropdown>
            </div>
          </b-form-group>
          <validation-provider
            #default="{ errors }"
            name="InvestmentDescription"
            rules="required"
          >
            <b-form-group label="Investment Description">
              <b-form-textarea
                id="investment-description"
                v-model="investment.content"
                :state="errors.length > 0 ? false : null"
                class="form-control-merge"
                name="investment-description"
                placeholder="Investment Description"
                rows="6"
                max-rows="6"
                no-resize
              />
            </b-form-group>
          </validation-provider>
          <div class="row">
            <div class="col text-center">
              <b-button
                variant="primary"
                type="submit"
              >
                Submit
                <b-spinner v-if="spinner" />
              </b-button>
            </div>
          </div>
        </b-form>
      </validation-observer>
    </b-card>
  </div>
</template>

<script>
import {
  BDropdown,
  BDropdownItem,
  BCard,
  BForm,
  BFormTextarea,
  BFormGroup,
  BFormInput,
  BFormFile,
  BButton,
  BRow,
  BCol,
  BFormCheckbox,
  BFormDatepicker,
  BFormTimepicker,
  BSpinner,
} from 'bootstrap-vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { required, email } from '@validations'
import { mapState, mapActions, mapMutations } from 'vuex'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  name: 'CreateEvent',
  components: {
    BDropdown,
    BDropdownItem,
    BSpinner,
    BCard,
    BRow,
    BButton,
    BCol,
    BForm,
    BFormTextarea,
    BFormInput,
    BFormCheckbox,
    BFormFile,
    BFormGroup,
    BFormDatepicker,
    ValidationObserver,
    ValidationProvider,
    BFormTimepicker,
  },
  data() {
    return {
      required,
      email,
      start_time: '00:00:00',
      end_time: '00:00:00',
      start_date: '',
      end_date: '',
      spinner: false,
      img: [],
      investment: {},
      showImages: false,
    }
  },
  computed: {
    // code ...
  },
  methods: {
    // code ...
  },
}
</script>

<style scoped>
.spinner-border {
  width: 15px;
  height: 15px;
}

#dropdown-cont {
  display: grid;
}

.dropdown-menu[role='menu'] {
  width: 100%;
}

#__BVID__120__BV_toggle_ {
  border: solid 1px #d8d6de !important;
}

</style>
