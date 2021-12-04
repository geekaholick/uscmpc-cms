<template>
  <div>
    <b-card title="Fill the needed Information">
      <validation-observer ref="validateForm">
        <b-form @submit.prevent>
          <validation-provider
            #default="{ errors }"
            name="ItemName"
            rules="required"
          >
            <b-form-group label="Item Name">
              <b-form-input
                id="item-name"
                v-model="consumerstore.item_name"
                :state="errors.length > 0 ? false : null"
                name="item-name"
                placeholder="Item Name"
              />
            </b-form-group>
          </validation-provider>
          <validation-provider
            #default="{ errors }"
            name="PriceItem"
            rules="required"
          >
            <b-form-group label="Price Item">
              <b-form-input
                id="price-item"
                v-model="consumerstore.price_item"
                :state="errors.length > 0 ? false : null"
                type="number"
                step="0.01"
                name="price-item"
                placeholder="Price Item"
              />
            </b-form-group>
          </validation-provider>
          <validation-provider
            #default="{ errors }"
            name="PriceBatch"
            rules="required"
          >
            <b-form-group label="Price Batch">
              <b-form-input
                id="price-batch"
                v-model="consumerstore.price_batch"
                :state="errors.length > 0 ? false : null"
                type="number"
                step="0.01"
                name="price-batch"
                placeholder="Price Batch"
              />
            </b-form-group>
          </validation-provider>
          <validation-provider
            #default="{ errors }"
            name="Description"
            rules="required"
          >
            <b-form-group label="Description">
              <b-form-textarea
                id="description"
                v-model="consumerstore.description"
                :state="errors.length > 0 ? false : null"
                class="form-control-merge"
                name="description"
                placeholder="Description"
                rows="6"
                max-rows="6"
                no-resize
              />
            </b-form-group>
          </validation-provider>
          <validation-provider
            #default="{ errors }"
            name="effective date"
            rules="required"
          >
            <b-form-group label="Effective Date">
              <b-form-datepicker
                id="effective_date"
                v-model="consumerstore.effective_date"
                :state="errors.length > 0 ? false : null"
                class="mb-2"
              />
            </b-form-group>
          </validation-provider>
          <validation-provider
            #default="{ errors }"
            name="Status"
            rules="required"
          >
            <b-form-group label="Status">
              <b-form-select
                id="status"
                v-model="consumerstore.status"
                :state="errors.length > 0 ? false : null"
                :options="consumerstoreOptions"
                name="status"
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
  BCard,
  BForm,
  BFormTextarea,
  BFormGroup,
  BFormInput,
  BButton,
  BFormDatepicker,
  BSpinner,
  BFormSelect,
} from 'bootstrap-vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { required, email } from '@validations'
import { mapActions, mapMutations } from 'vuex'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
// eslint-disable-next-line import/newline-after-import
import * as ConsumerStoreTypes from '../../../store/types/consumer_store'
export default {
  name: 'CreateEvent',
  components: {
    BSpinner,
    BCard,
    BButton,
    BForm,
    BFormTextarea,
    BFormInput,
    BFormGroup,
    BFormDatepicker,
    ValidationObserver,
    ValidationProvider,
    BFormSelect,
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
      consumerstore: {},
      showImages: false,
      consumerstoreOptions: [
        { value: null, text: 'Please select an status' },
        { value: 'active', text: 'active' },
        { value: 'inactive', text: 'inactive' },
        { value: 'removed', text: 'removed' },
      ],
    }
  },
  computed: {
    // code ...
  },
  methods: {
    ...mapMutations([
      ConsumerStoreTypes.MUTATION_CONSUMER_STORE,
    ]),
    ...mapActions([
      ConsumerStoreTypes.ACTION_CREATE_CONSUMER_STORE,
    ]),
    onSubmit() {
      this.spinner = true

      this.$refs.validateForm.validate().then(async success => {
        if (success) {
          this[ConsumerStoreTypes.MUTATION_CONSUMER_STORE](this.consumerstore)
          const response = await this[ConsumerStoreTypes.ACTION_CREATE_CONSUMER_STORE]()
          console.log(response)
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
            this.$router.push({ name: 'list-consumerstore' })
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
