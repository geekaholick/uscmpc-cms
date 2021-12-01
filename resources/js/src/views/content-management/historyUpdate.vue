<template>
  <b-overlay
    :show="show"
    rounded="sm"
  >
    <b-card class="blog-edit-wrapper">
      <b-form class="mt-2">
        <b-row>
              <b-col
        cols="6"
        class="mb-2 ml-auto mr-auto"
      >
            <div class="border rounded p-2">
          <b-media
            no-body
            vertical-align="center"
            class="flex-column"
          >
          <b-media-aside>
              <b-img
                ref="refPreviewEl"
                 :src="banner.image ||
                  require('@/assets/images/avatars/10-small.png')
                "
                height="240"
                width="400"
                class="rounded mt-2"
              />
            </b-media-aside>
             <b-media-body>
            <div class="inline-block">
                <b-button
                  v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                  variant="primary"
                  class="my-1 d-block mt-1"
                  @click="$refs.bannerImage.click()"
                >
                 Upload Image
                </b-button>
                <input
                  ref="bannerImage"
                  type="file"
                  class="form-control"
                  accept="image/*"
                  hidden
                  @change="setBanner"
                />
                 </div>
       </b-media-body>
        </b-media>
            </div>
            </b-col>
          <b-col cols="12">
            <b-form-group>
                <h4>TITLE:</h4>
              <quill-editor
                id="blog-content"
                v-model="title"
                :options="snowOption"
              />
            </b-form-group>
          </b-col>

          <b-col cols="12">
            <b-form-group>
                 <h4>CONTENT:</h4>
              <quill-editor
                id="blog-content"
                v-model="content"
                :options="snowOption"
              />
            </b-form-group>
          </b-col>

            <router-link to="/history">
              <b-button
                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                variant="primary"
                class="mr-1 ml-1"
                @click="update()"
              >
                {{ action === 'add' ? 'Save' : 'Update' }}
              </b-button>
            </router-link>

             <router-link to="/history">
              <b-button
                v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                variant="danger"
                class=""
              >
                Cancel
              </b-button>
            </router-link>


        </b-row>
      </b-form>
    </b-card>
  </b-overlay>
</template>

<script>
import {
  BCard,
  BMedia,
  BCardText,
  BMediaBody,
  BForm,
  BRow,
  BCol,
  BFormGroup,
  BButton,
  BOverlay,
  BFormFile,
  BMediaAside,
  BLink,
  BImg,
  BSpinner,
} from 'bootstrap-vue'
import { required, url } from '@validations'
import { quillEditor } from 'vue-quill-editor'
import { mapActions, mapGetters } from 'vuex'
import Ripple from 'vue-ripple-directive'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import * as coopHistoryTypes from '@/store/types/history'

export default {
  components: {
    BCard,
    BMedia,
    BCardText,
    BMediaBody,
    BForm,
    BRow,
    BCol,
    BButton,
    BFormGroup,
    BOverlay,
    quillEditor,
    BFormFile,
    BMediaAside,
    BLink,
    BImg,
    BSpinner,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      show: true,
      title: '',
      snowOption: {
        theme: 'snow',
      },
      s: 'asdsad',
      content: '',
       currentBannerImage: '',
     required,
      url,
      bannerFile: '',
      logoFile: '',
      show: false,
      selected: 'Internal',
      isSaving: false,
      currentBannerImage: '',
      currentLogoImage: '',
      banner: {
        image: '',
      },
    }
  },
  computed: {
    ...mapGetters({
      allCoopHistory: coopHistoryTypes.GET_HISTORY,
      getSuccessMessage: coopHistoryTypes.GET_SUCCESS_MSG,
      getErrorMessage: coopHistoryTypes.GET_ERROR_MSG,
    }),
    action() {
      return this.$route.params.action
    },
  },
  async created() {
    if (this.action === 'add') {
      this.show = false
    } else {
     await this.fetchCoopHistory().then(() => {
        this.show = false
        this.content = this.allCoopHistory[0].content
        this.title = this.allCoopHistory[0].title
        this.banner.image = this.allCoopHistory[0].image
      })
    }
  if(this.id && this.id !== 'new') {
    this.getBanner(this.id).then(() => {
      this.banner = this.selectedBanner
      this.currentBannerImage = this.banner.image.substring(this.banner.image.indexOf('storage/') + 7)
      console.log(this.selectedBanner)
    })
  }
  },

  methods: {
    ...mapActions({
      fetchCoopHistory: coopHistoryTypes.ACTION_HISTORY_REQUEST,
      updateHistory: coopHistoryTypes.ACTION_EDIT_HISTORY,
      createNew: coopHistoryTypes.ACTION_CREATE_DESCRIPTION,
    }),
    getMessage(title, content, image) {
      (this.title = title)(this.content = content)(this.image = image)
    },
    async update() {
         const config = {
        headers: {
          'Content-type': 'multipart/form-data',
        },
      }
        const form = new FormData()
        form.append("title",this.title)
        form.append("content",this.content)
        form.append("image",this.bannerFile)

      if (this.action === 'add') {
        await this.createNew(form)

      } else {

        await this.updateHistory(form,config)
      }
      this.toastMessage()
      if (this.getSuccessMessage) {
        this.$router.push({ name: 'History' })
      }
    },
    toastMessage() {
      this.isSaving = false
      this.$toast({
        component: ToastificationContent,
        props: {
          title: this.getSuccessMessage
            ? this.getSuccessMessage
            : this.getErrorMessage,
          icon: this.getSuccessMessage ? 'CheckIcon' : 'AlertCircleIcon',
          variant: this.getSuccessMessage ? 'success' : 'danger',
        },
      })
    },

     setBanner(e){
      this.setImage(e, true)
    },

    setImage(e, isBanner = false) {
      const file = e.target.files[0]
      if (isBanner) {
        this.bannerFile = file
      } else {
        this.logoFile = file
      }

      const reader = new FileReader()
      reader.readAsDataURL(isBanner ? this.bannerFile : this.logoFile)
      reader.onload = es => {
          console.log(this.banner)
        if (isBanner) {
          this.banner.image = es.target.result
        } else {
          this.banner.logo = es.target.result
        }
      }
    },
    setLogo(e){
      this.setImage(e, false)
    },
  },

}


</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
@import '@core/scss/vue/libs/quill.scss';
@import '@core/scss/vue/pages/page-blog.scss';
</style>
