<template>
  <div class="form">
    <!-- Personal Data  -->
    <b-card>
      <b-media-aside>
        <b-img
          ref="refPreviewEl"
          :src="
            otherService.image ||
            require('@/assets/images/avatars/10-small.png')
          "
          height="140"
          width="200"
          class="rounded mr-2 mb-1 mb-md-0"
        />
      </b-media-aside>
      <b-media-body>
        <!-- <small
          class="text-muted"
        >Required image resolution 800x400, image size 10mb.</small> -->
        <!-- <b-card-text class="my-50">
          <b-link id="blog-image-text"> no image uploaded </b-link>
        </b-card-text> -->
        <div class="d-inline-block">
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            class="w-100 my-1"
            @click="$refs.serviceImage.click()"
          >
            Upload Image
          </b-button>
          <input
            ref="serviceImage"
            type="file"
            class="form-control"
            accept="image/*"
            hidden
            @change="setServiceImage"
          />
        </div>
      </b-media-body>

      <!-- form -->
      <validation-observer ref="refFormObserver">
        <b-form class="mt-2" @reset.prevent="resetForm">
          <b-row>
            <b-col md="6">
              <validation-provider name="Title" rules="required">
                <b-form-group
                  label="Title"
                  label-for="blog-edit-title"
                  class="mb-2"
                >
                  <b-form-input
                    id="blog-edit-title"
                    v-model="otherService.title"
                    placeholder="Service Title"
                    autofocus
                  />
                </b-form-group>
              </validation-provider>
            </b-col>

            <b-col md="6">
              <validation-provider name="description" rules="required">
                <b-form-group
                  label="Description"
                  label-for="blog-edit-description"
                  class="mb-2"
                >
                  <b-form-input
                    id="blog-edit-description"
                    v-model="otherService.description"
                    placeholder="Description"
                    autofocus
                  />
                </b-form-group>
              </validation-provider>
            </b-col>

            <!-- <b-col cols="12">
              <validation-provider
                #default="{ errors }"
                name="Description"
                rules="required"
              >
                <b-form-group
                  label="Content"
                  label-for="blog-content"
                  class="mb-2"
                >
                  <quill-editor
                    id="blog-content"
                    v-model="otherService.description"
                    :options="snowOption"
                    :state="errors.length > 0 ? false : null"
                  />
                </b-form-group>
              </validation-provider>
            </b-col> -->

           

            <b-col md="6">
              <b-form-group label="Icon" label-for="icon" class="mb-2">
                <b-form-input
                  id="icon"
                  v-model="otherService.icon"
                  placeholder="fa fa-something"
                />
              </b-form-group>
            </b-col>

            <b-col cols="12" class="mt-50">
              <b-button
                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                variant="primary"
                class="mr-1"
                :disabled="isSaving || !isSaveEnable"
                @click="onSubmit()"
              >
                Save Changes
              </b-button>
              <router-link to="/otherService">
                <b-button
                  v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                  variant="outline-danger"
                >
                  Cancel
                </b-button>
              </router-link>
            </b-col>
          </b-row>
        </b-form>
      </validation-observer>
      <!--/ form -->
    </b-card>
    <!-- /Personal Data  -->
  </div>
</template>

<script>
import {
  BFormInput,
  BForm,
  BFormCheckbox,
  BFormGroup,
  BButton,
  BCard,
  BCardText,
  BRow,
  BCol,
  BFormFile,
  BFormInvalidFeedback,
  BMediaAside,
  BMediaBody,
  BLink,
  BImg,
} from 'bootstrap-vue'
import { required, url } from '@validations'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import Ripple from 'vue-ripple-directive'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
// import { quillEditor } from 'vue-quill-editor'
import { mapActions, mapGetters } from 'vuex'
import * as types from '@/store/types/otherServices.js'

export default {
  components: {
    BFormInput,
    BForm,
    BFormCheckbox,
    BFormGroup,
    BButton,
    BCard,
    BCardText,
    BRow,
    BCol,
    ValidationProvider,
    ValidationObserver,
    BFormFile,
    // quillEditor,
    BFormInvalidFeedback,
    BMediaAside,
    BMediaBody,
    BLink,
    BImg,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      required,
      url,
      imageFile: '',
      // logoFile: '',
      show: false,
      selected: 'Internal',
      isSaving: false,
      otherService: {
        title: '',
        description: '',
        link: '',
        image: '',
        icon: '',
      },
      // statusOption: ['Internal', 'External'],
      snowOption: {
        theme: 'snow',
      },
    }
  },

  computed: {
    ...mapGetters({
        selectedService :types.GETTER_OTHER_SERVICE,
        successMessage: types.GETTER_SUCCESS_MESSAGE,
        errorMessage: types.GETTER_ERROR_MESSAGE,
    }),
     isSaveEnable() {
      return (
        this.otherService.title !== ''
        && this.otherService.description !== ''
        && this.otherService.image !== ''
        && this.otherService.icon !== ''
      )
    },
    id() {
      return this.$route.params.id
    },
  },

  created() {
    this.show = true
    this.getOtherService(this.id).then(() => {
    this.otherService = this.selectedService
    this.show = false
    })
  },

  methods: {
    ...mapActions({
    getOtherService: types.ACTION_GET_OTHER_SERVICE,
    updateService: types.ACTION_UPDATE_OTHER_SERVICE,
    }),

    setImage(e, isImage = false) {
      const file = e.target.files[0]
      if (isImage) {
        this.imageFile = file
        console.log(this.imageFile);
      }
      const reader = new FileReader()
      reader.readAsDataURL(this.imageFile)
      reader.onload = es => {
        if (isImage) {
          this.otherService.image = es.target.result
        }
      }
    },

    setServiceImage(e) {
      this.setImage(e, true)
    },

    async onSubmit() {
      const config = {
          headers: {
            'Content-type': 'multipart/form-data',
          },
        }
      const otherServiceID = this.id;
      const form = new FormData()
      form.append('title', this.otherService.title)
      form.append('description', this.otherService.description)
      form.append('image', this.imageFile)
      form.append('icon', this.otherService.icon)
      // form.append('status', 1)
      this.updateService(form, config).then(() => {
        this.toastMessage()
        if (this.successMessage) {
          this.$router.push({ path: '/other-services' })
        }
      })

    },
      toastMessage() {
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

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
// @import '@core/scss/vue/libs/quill.scss';
@import '@core/scss/vue/pages/page-blog.scss';
.form {
  margin: auto;
  padding: 40px;
  border: 1px solid lightgrey;
  box-shadow: 15px 15px 10px lightgrey;
}

label {
  margin-right: 1%;
}
.address {
  width: 88%;
}
</style>
