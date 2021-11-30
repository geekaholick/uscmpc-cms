<template>
  <b-overlay rounded="sm">
    <router-link to="/history/edit">
      <b-button
        v-ripple.400="'rgba(113, 102, 240, 0.15)'"
        variant="outline-primary"
      >
        <!-- <edit-icon icon="editButton"/> -->
        <feather-icon
          icon="EditIcon"
          class="mr-1"
        />
        <span class="align-middle mt-5">UPDATE HISTORY</span>
      </b-button>
    </router-link>
    <div class="blog-detail-wrapper">
      <b-row>
        <div
          v-if="allCoopHistory.length === 0 && !isLoading"
          class="empty-state"
        >
          <div class="card">
            <img
              class="card-img-top empty-img"
              src="@/assets/images/logo/empty-box.png"
              alt="Card image cap"
            >
            <p class="card-text text-muted text-center mt-4 mb-5">
              There's no details about USCMPC. Click the button below to create
              a new one.
            </p>
            <router-link
              to="/history/add"
              class="mx-auto"
            >
              <b-button
                v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                variant="outline-primary"
                class="ml-2"
              >
                <feather-icon
                  icon="PlusIcon"
                  class="mr-1"
                />
                <span class="align-middle text-center ">New Details</span>
              </b-button>
            </router-link>
          </div>
        </div>
        <b-col
          id="update"
          cols="12"
        >
          <b-card
            v-for="history in allCoopHistory"
            :key="history.id"
            class="mr-5"
          >
            <div>
              <b-img
                center
                :src="history.image"
                alt="Coop logo"
                width="300"
                class="img-fluid mt-1"
              />
            </div>
            <div
              class="title mt-4 text-center"
              v-html="history.title"
            />
            <div class="my-1 py-25">
              <b-link>
                <b-badge
                  pill
                  class="mr-75"
                />
              </b-link>
            </div>
            <div class="blog-content" />
            <div v-html="history.content" />
            <div class="editIcon">
              <router-link to="/history/edit">
                <edit-icon
                  size="2x"
                  color="white"
                  scale="0.5"
                  class="custom-class text-center mr-5 w-25 bg-primary rounded"
                  style="margin-left: 55px;padding: 6px; float:right height:30px"
                />
              </router-link>
            </div>
            <div />
          </b-card>
        </b-col>
      </b-row>
    </div>
  </b-overlay>
</template>
<style>
.card-img,
.card-img-top {
  border-top-left-radius: calc(0.428rem - 1px);
  border-top-right-radius: calc(0.428rem - 1px);
  max-width: 264px !important;
  margin-top: 29px !important;
}
.btn {
  float: right;
}
.textarea {
  margin-left: 47px;
}
.modal .modal-footer > .btn {
  margin-left: 0.75rem;
  display: none;
}
.editIcon {
  position: fixed;
  right: -5vh;
  top: 60vw;
  color: black;
}
.empty-state {
  margin: 10% auto;
  width: 30vw;
}
.empty-img {
  opacity: 0.3;
  margin: 0 auto;
}
.title {
  font-weight: bold;
}
/* .editButton{

} */
.btn-outline-primary {
  border: 1px solid #7367f0 !important;
  background-color: transparent;
  margin-top: -52px;
  margin-right: 45px;
}
.align-middle{
    margin-top: -52px;
    margin-bottom: 4.5rem !important;
}
</style>

<script>
import {
  BLink,
  BCard,
  BRow,
  BCol,
  BBadge,
  BImg,
  BButton,
  BOverlay,
} from 'bootstrap-vue'
import { mapActions, mapGetters } from 'vuex'
import Ripple from 'vue-ripple-directive'
import { EditIcon } from 'vue-feather-icons'
import * as coopHistoryTypes from '@/store/types/history'

export default {
  components: {
    BLink,
    BCard,
    BRow,
    BCol,
    BBadge,
    BImg,
    BButton,
    BOverlay,
    EditIcon,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      type: {
        title: '',
        content: '',
        image: '',
      },
      isLoading: true,
      fields: ['title', 'content', 'image'],
    }
  },
  computed: mapGetters({
    allCoopHistory: coopHistoryTypes.GET_HISTORY,
  }),
  async created() {
    await this.fetchCoopHistory().then(() => {
      this.isLoading = false
    })
  },
  methods: {
    ...mapActions({
      fetchCoopHistory: coopHistoryTypes.ACTION_HISTORY_REQUEST,
      updateHistory: coopHistoryTypes.ACTION_EDIT_HISTORY,
    }),
    getMessage(content, title, image) {
      this.content = content
      this.title = title
      this.image = image
    },
    update() {
      this.updateHistory({
        content: this.content,
        title: this.title,
        image: this.image,
      })
    },
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-blog.scss';
@import '@core/scss/vue/libs/quill.scss';
@import '@core/scss/vue/libs/vue-select.scss';
</style>
