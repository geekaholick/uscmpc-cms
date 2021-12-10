<template>
  <b-overlay
    :show="show"
    rounded="sm"
  >
    <b-card class="blog-edit-wrapper">
      <b-col
        cols="12"
        class="mb-2"
      >
        <div class="border rounded p-2">
          <b-media
            no-body
            vertical-align="center"
            class="flex-column flex-md-row"
          >
            <b-media-aside>
              <b-img
                ref="refPreviewEl"
                :src="
                  banner.image || require('@/assets/images/pages/no-image.png')
                "
                height="140"
                width="200"
                class="rounded mr-2 mb-1 mb-md-0"
              />
            </b-media-aside>
            <b-media-body>
              <small
                class="text-muted"
              >Required image resolution 800x400, image size 10mb.</small>
              <b-card-text class="my-50">
                <b-link id="blog-image-text">
                  {{
                  bannerFile
                    ? bannerFile.name
                    : banner.image
                      ? ''
                      : 'no image uploaded'
                }}
                </b-link>
              </b-card-text>
              <div class="d-inline-block">
                <b-button
                  v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                  variant="primary"
                  class="w-100 my-1"
                  @click="$refs.bannerImage.click()"
                >
                  Upload Banner
                </b-button>
                <input
                  ref="bannerImage"
                  type="file"
                  class="form-control"
                  accept="image/*"
                  hidden
                  @change="setBanner"
                >
              </div>
            </b-media-body>

            <b-media-aside>
              <b-img
                ref="refPreviewEl"
                :src="
                  banner.logo || require('@/assets/images/pages/no-image.png')
                "
                height="100"
                width="100"
                class="rounded-circle mr-2 mb-1 mb-md-0"
              />
            </b-media-aside>
            <b-media-body>
              <b-card-text class="my-50">
                <b-link id="blog-image-text">{{
                  logoFile
                    ? logoFile.name
                    : banner.logo
                      ? ''
                      : 'no image uploaded'
                }}</b-link>
              </b-card-text>
              <div class="d-inline-block">
                <b-button
                  v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                  variant="primary"
                  class="w-100 my-1"
                  @click="$refs.logoImage.click()"
                >
                  Upload Logo
                </b-button>
                <input
                  ref="logoImage"
                  type="file"
                  class="form-control"
                  accept="image/*"
                  hidden
                  @change="setLogo"
                >
              </div>
            </b-media-body>
          </b-media>
        </div>
      </b-col>

      <validation-observer ref="refFormObserver">
        <b-form
          class="mt-2"
          @reset.prevent="resetForm"
        >
          <b-row>
            <b-col md="6">
              <validation-provider
                #default="{ errors }"
                name="Title"
                rules="required"
                class="mb-2"
              >
                <b-form-group
                  label="Title"
                  label-for="blog-edit-title"
                >
                  <b-form-input
                    id="blog-edit-title"
                    v-model="banner.title"
                    autocomplete="off"
                    placeholder="Banner Title"
                    autofocus
                    :state="errors.length > 0 ? false : null"
                  />
                </b-form-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-col>
            <b-col md="6">
              <validation-provider
                #default="{ errors }"
                name="Subtitle"
                rules="required"
                class="mb-2"
              >
                <b-form-group
                  label="Subtitle"
                  label-for="sub-titl"
                  class="mb-2"
                >
                  <b-form-input
                    id="suntile"
                    v-model="banner.subtitle"
                    autocomplete="off"
                    placeholder="Banner subtitle"
                    :state="errors.length > 0 ? false : null"
                  />
                </b-form-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-col>
            <b-col md="6">
              <validation-provider
                #default="{ errors }"
                name="Button Text"
                rules="required"
                class="mb-2"
              >
                <b-form-group
                  label="Button Text"
                  label-for="button"
                  class="mb-2"
                >
                  <b-form-input
                    id="button"
                    v-model="banner.button_text"
                    autocomplete="off"
                    placeholder="Button Text"
                    :state="errors.length > 0 ? false : null"
                  />
                </b-form-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-col>
            <b-col md="6">
              <validation-provider
                #default="{ errors }"
                name="Url"
                rules="url"
              >
                <b-form-group
                  label="Link"
                  label-for="link"
                  class="mb-2"
                >
                  <b-form-input
                    id="link"
                    v-model="banner.link"
                    autocomplete="off"
                    placeholder="http://example.com"
                    :state="errors.length > 0 ? false : null"
                  />
                  <b-form-invalid-feedback>
                    {{ errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>
            <b-col md="6">
              <b-form-group
                label="Icon"
                label-for="icon"
                class="mb-2"
              >
                <b-form-input
                  id="icon"
                  v-model="banner.icon"
                  autocomplete="off"
                  placeholder="fa fa-something"
                />
              </b-form-group>
            </b-col>
            <b-col md="6">
              <b-form-group
                label="Icon"
                label-for="icon"
                class="mb-2"
              >
                 <b-form-select
                    v-model="selected"
                    :options="statusOptions"
                />
              </b-form-group>
            </b-col>
            <b-col cols="12">
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
                    v-model="banner.description"
                    :options="snowOption"
                    :state="errors.length > 0 ? false : null"
                  />
                </b-form-group>
                <b-form-invalid-feedback>
                  {{ errors[0] }}
                </b-form-invalid-feedback>
              </validation-provider>
            </b-col>
            <b-col
              cols="12"
              class="mt-50"
            >
              <b-button
                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                variant="outline-primary"
                class="mr-1"
                :disabled="isSaving || !isSaveEnable"
                @click="onSubmit()"
              >
                <b-spinner
                  v-show="isSaving"
                  variant="primary"
                  small
                />
                Save Changes
              </b-button>
              <router-link to="/banner">
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
    </b-card>
  </b-overlay>
</template>

<script>
import {
  BCard,
  BMedia,
  BCardText,
  BOverlay,
  BMediaAside,
  BMediaBody,
  BForm,
  BRow,
  BCol,
  BFormGroup,
  BFormSelect,
  BFormInput,
  BFormInvalidFeedback,
  BImg,
  BLink,
  BButton,
  BSpinner,
} from 'bootstrap-vue'
import { required, url } from '@validations'
import vSelect from 'vue-select'
import { quillEditor } from 'vue-quill-editor'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import Ripple from 'vue-ripple-directive'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { mapActions, mapGetters } from 'vuex'
import * as bannerTypes from '@/store/types/banner'

export default {
  components: {
    BCard,
    BMedia,
    BCardText,
    BMediaAside,
    BMediaBody,
    BForm,
    BLink,
    BImg,
    BRow,
    BCol,
    BButton,
    BSpinner,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BFormInvalidFeedback,
    BOverlay,
    vSelect,
    quillEditor,
    ValidationProvider,
    ValidationObserver,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      required,
      url,
      bannerFile: '',
      logoFile: '',
      show: false,
      selected: 1,
      statusOptions: [{value: 1, text: 'Active'}, {value: 0, text: 'Inactive'}],
      isSaving: false,
      currentBannerImage: '',
      currentLogoImage: '',
      banner: {
        title: '',
        description: '',
        link: '',
        image: '',
        subtitle: '',
        button_text: '',
        icon: '',
        logo: '',
        status: 1,
      },
      snowOption: {
        theme: 'snow',
      },
    }
  },
  computed: {
    ...mapGetters({
      selectedBanner: bannerTypes.GETTER_BANNER,
      successMessgae: bannerTypes.GETTER_SUCCESS_MESSAGE,
      errorMessage: bannerTypes.GETTER_ERROR_MESSAGE,
    }),
    isSaveEnable() {
      return (
        this.banner.title !== ''
        && this.banner.description !== ''
        && this.banner.link !== ''
        && this.banner.image !== ''
        && this.banner.subtitle !== ''
        && this.banner.button_text !== ''
        && this.banner.logo !== ''
      )
    },
    id() {
      return this.$route.params.id
    },
  },
  created() {
    if (this.id && parseInt(this.id)) {
      this.show = true
      this.getBanner(this.id).then(() => {
        this.banner = this.selectedBanner
        this.show = false
        this.selected = this.selectedBanner.status
        this.currentBannerImage = this.banner.image.substring(
          this.banner.image.indexOf('storage/') + 7,
        )
        this.currentLogoImage = this.banner.logo.substring(
          this.banner.logo.indexOf('storage/') + 7,
        )
      })
    }
  },
  methods: {
    ...mapActions({
      getBanner: bannerTypes.ACTION_GET_BANNER,
      createBanner: bannerTypes.ACTION_CREATE_BANNER,
      updateBanner: bannerTypes.ACTION_UPDATE_BANNER,
    }),
    setImage(e, isBanner = false) {
      const file = e.target.files[0]
      if (isBanner) {
        this.bannerFile = file
      } else {
        this.logoFile = file
      }
      const reader = new FileReader()
      if (this.bannerFile || this.logoFile) {
        reader.readAsDataURL(isBanner ? this.bannerFile : this.logoFile)
        reader.onload = es => {
          if (isBanner) {
            this.banner.image = es.target.result
          } else {
            this.banner.logo = es.target.result
          }
        }
      }
    },
    setBanner(e) {
      this.setImage(e, true)
    },
    setLogo(e) {
      this.setImage(e, false)
    },

    async onSubmit() {
      console.log(this.selected)
      this.isSaving = true
      const config = {
        headers: {
          'Content-type': 'multipart/form-data',
        },
      }

      const form = new FormData()
      form.append('title', this.banner.title)
      form.append('description', this.banner.description)
      form.append('subtitle', this.banner.subtitle)
      form.append('link', this.banner.link ? this.getValidUrl(this.banner.link): this.banner.link)
      form.append('image', this.bannerFile)
      form.append('logo', this.logoFile)
      form.append('button_text', this.banner.button_text)
      form.append('icon', this.banner.icon)
      form.append('status', this.selected)

      if (this.id && this.id !== 'new') {
        form.append('id', this.id)
        form.append('oldBannerImage', this.currentBannerImage)
        form.append('oldLogoImage', this.currentLogoImage)
        await this.updateBanner(form, config).then(() => {
          this.toastMessage()
        })
      } else {
        await this.createBanner(form, config).then(() => {
          this.toastMessage()
        })
      }
      if (this.successMessgae) {
          this.$router.push({ name: 'banner' })
        }
    },

      getValidUrl(bannerLink = '') {
        let newUrl = window.decodeURIComponent(bannerLink)
        newUrl = newUrl.trim().replace(/\s/g, '')
        if (/^(:\/\/)/.test(newUrl)) {
          return `http${newUrl}`
        }
        if (!/^(f|ht)tps?:\/\//i.test(newUrl)) {
          return `http://${newUrl}`
        }
        return newUrl
      },
    toastMessage() {
      this.isSaving = false
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

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
@import '@core/scss/vue/libs/quill.scss';
@import '@core/scss/vue/pages/page-blog.scss';
</style>
