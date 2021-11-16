<template>
  <div>
    <b-card title="Fill the needed Information">
      <validation-observer ref="validateForm">
        <b-form @submit.prevent>
          <validation-provider
            #default="{ errors }"
            name="InvestmentTitle"
            rules="required"
          >
            <b-form-group label="Title">
              <b-form-input
                id="investment-title"
                v-model="investment_edit.title"
                :state="errors.length > 0 ? false : null"
                name="event-venue"
                placeholder="Event Type"
              />
            </b-form-group>
          </validation-provider>
          <b-form-group label="Investment Image">
            <b-form-file
              ref="img"
            />
          </b-form-group>
          <validation-provider
            #default="{ errors }"
            name="InvestmentDescription"
            rules="required"
          >
            <b-form-group label="Investment Description">
              <b-form-textarea
                id="investment-description"
                v-model="investment_edit.description"
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
                @click="onSubmit"
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
import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import * as InvestmentTypes from '../../../store/types/investment.js'

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
      investment_edit: {},
      start_time: '00:00:00',
      end_time: '00:00:00',
      start_date: '',
      end_date: '',
      spinner: false,
      img: [],
      showImages: false,
    }
  },
  computed: {
    ...mapGetters({
      'investment': InvestmentTypes.GETTER_INVESTMENT
    })
  },
  mounted() {
    this.investment_edit = this.investment
  },
  methods: {
    ...mapMutations([InvestmentTypes.MUTATION_INVESTMENT,]),
    ...mapActions([InvestmentTypes.ACTION_EDIT_INVESTMENT, ]),
    onSubmit() {
      // get image
      this.spinner = true
      this.investment_edit.image = this.$refs.img.$refs.input.files[0]
      this.$refs.validateForm.validate().then(async success => {
        if (success) {
          this[InvestmentTypes.MUTATION_INVESTMENT](this.investment_edit)
          const response = await this[InvestmentTypes.ACTION_EDIT_INVESTMENT]()
          if (response.data.success) {
            // show when the response is success
            this.$toast({
              component: ToastificationContent,
              props: {
                title: 'Form Submitted',
                icon: 'EditIcon',
                variant: 'success',
              },
            })
            this.$router.push({name: 'list-investment'})
          } else {
            this.$toast({
              component: ToastificationContent,
              props: {
                title: 'Something went wrong',
                icon: 'EditIcon',
                variant: 'danger',
              },
            })
          }
        } else {
          this.$toast({
              component: ToastificationContent,
              props: {
                title: 'Please supply all information needed',
                icon: 'EditIcon',
                variant: 'warning',
              },
            })
        }
      })
      this.spinner = false
    },
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
