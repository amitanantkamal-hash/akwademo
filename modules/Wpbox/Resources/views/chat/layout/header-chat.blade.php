<div class="card-header shadow-none d-flex align-items-center" style="min-height: 130px">
  <div class="flex-1">
    <button @click="showConversations" v-cloak v-if="mobileChat" class="btn btn-outline me-8">
      <svg xmlns="http://www.w3.org/2000/svg" fill="#2dce89" class="w-6 h-6" style="width: 20px; height:20px">
        <path fill-rule="evenodd"
          d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
          clip-rule="evenodd" />
      </svg>
    </button>

    <a href="'/contacts/manage/' + activeChat.id + '/edit'" v-if="!isFromMeta()">
      <div class="symbol symbol-50px symbol-circle me-5 relative">
        <span v-cloak
          v-if="activeChat&&activeChat.name&&activeChat.name[0]&&(activeChat.avatar==''||activeChat.avatar==null)"
          style="min-width:48px"
          class="symbol-label bg-light-primary text-primary fs-6 fw-bolder">@{{ activeChat.name[0] }}</span>
        <img v-cloak v-if="activeChat&&(activeChat.avatar!=''&&activeChat.avatar!=null)" alt=""
          :src="activeChat.avatar" :data-src="activeChat.avatar" class="avatar" />
        <div class="position-absolute translate-middle start-100 top-100 ms-2 mt-n7">
          <span id="userCountry" v-if="activeChat&&activeChat.country"
            :class="'fi-' + activeChat.country.iso2.toLowerCase()" class="fi  fis flag-icon"></span>
        </div>
        <b-tooltip target="userCountry">@{{ activeChat.country.name }}</b-tooltip>
      </div>
    </a>

    <div class="symbol symbol-50px symbol-circle me-5 relative" v-if="isFromMeta()">
      <span v-cloak style="min-width:48px"
        class="symbol-label bg-light-primary text-primary fs-6 fw-bolder">@{{ activeChat.name[0] }}</span>
      <img v-cloak v-if="activeChat&&(activeChat.avatar!=''&&activeChat.avatar!=null)" alt=""
        :src="activeChat.avatar" :data-src="activeChat.avatar" class="avatar" />
      <div class="position-absolute translate-middle start-100 top-100 ms-2 mt-n7">
        <span id="userCountry" class="meta-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" v-if="activeChat.platform == 'messenger'">
            <linearGradient id="Ld6sqrtcxMyckEl6xeDdMa_uLWV5A9vXIPu_gr1" x1="9.993" x2="40.615" y1="9.993"
              y2="40.615" gradientUnits="userSpaceOnUse">
              <stop offset="0" stop-color="#2aa4f4"></stop>
              <stop offset="1" stop-color="#007ad9"></stop>
            </linearGradient>
            <path fill="url(#Ld6sqrtcxMyckEl6xeDdMa_uLWV5A9vXIPu_gr1)"
              d="M24,4C12.954,4,4,12.954,4,24s8.954,20,20,20s20-8.954,20-20S35.046,4,24,4z"></path>
            <path fill="#fff"
              d="M26.707,29.301h5.176l0.813-5.258h-5.989v-2.874c0-2.184,0.714-4.121,2.757-4.121h3.283V12.46 c-0.577-0.078-1.797-0.248-4.102-0.248c-4.814,0-7.636,2.542-7.636,8.334v3.498H16.06v5.258h4.948v14.452 C21.988,43.9,22.981,44,24,44c0.921,0,1.82-0.084,2.707-0.204V29.301z">
            </path>
          </svg>

          <svg viewBox="0 0 48 48" v-if="activeChat.platform == 'instagram'">
            <radialGradient id="yOrnnhliCrdS2gy~4tD8ma_Xy10Jcu1L2Su_gr1" cx="19.38" cy="42.035" r="44.899"
              gradientUnits="userSpaceOnUse">
              <stop offset="0" stop-color="#fd5"></stop>
              <stop offset=".328" stop-color="#ff543f"></stop>
              <stop offset=".348" stop-color="#fc5245"></stop>
              <stop offset=".504" stop-color="#e64771"></stop>
              <stop offset=".643" stop-color="#d53e91"></stop>
              <stop offset=".761" stop-color="#cc39a4"></stop>
              <stop offset=".841" stop-color="#c837ab"></stop>
            </radialGradient>
            <path fill="url(#yOrnnhliCrdS2gy~4tD8ma_Xy10Jcu1L2Su_gr1)"
              d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z">
            </path>
            <radialGradient id="yOrnnhliCrdS2gy~4tD8mb_Xy10Jcu1L2Su_gr2" cx="11.786" cy="5.54" r="29.813"
              gradientTransform="matrix(1 0 0 .6663 0 1.849)" gradientUnits="userSpaceOnUse">
              <stop offset="0" stop-color="#4168c9"></stop>
              <stop offset=".999" stop-color="#4168c9" stop-opacity="0"></stop>
            </radialGradient>
            <path fill="url(#yOrnnhliCrdS2gy~4tD8mb_Xy10Jcu1L2Su_gr2)"
              d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z">
            </path>
            <path fill="#fff"
              d="M24,31c-3.859,0-7-3.14-7-7s3.141-7,7-7s7,3.14,7,7S27.859,31,24,31z M24,19c-2.757,0-5,2.243-5,5	s2.243,5,5,5s5-2.243,5-5S26.757,19,24,19z">
            </path>
            <circle cx="31.5" cy="16.5" r="1.5" fill="#fff"></circle>
            <path fill="#fff"
              d="M30,37H18c-3.859,0-7-3.14-7-7V18c0-3.86,3.141-7,7-7h12c3.859,0,7,3.14,7,7v12	C37,33.86,33.859,37,30,37z M18,13c-2.757,0-5,2.243-5,5v12c0,2.757,2.243,5,5,5h12c2.757,0,5-2.243,5-5V18c0-2.757-2.243-5-5-5H18z">
            </path>
          </svg>
        </span>
      </div>
    </div>
  </div>

  <div class="flex-fill d-flex-row">
    <div class="flex-1">
      <div class="d-flex align-items-center">
        <a :href="'/contacts/manage/' + activeChat.id + '/edit'" class="text-gray-800 text-hover-primary fs-4 fw-bold"
          v-if="!isFromMeta()">
          @{{ activeChat.name }}
        </a>

        <span class="text-gray-800 text-hover-primary fs-4 fw-bold" v-if="isFromMeta()">
          @{{ activeChat.name }}
        </span>

        <div class="ms-2">
          <span class="d-inline-block" tabindex="0" v-b-tooltip.hover.top="(getReplyNotification(activeChat)).text">
            <b-button class="m-0 p-0 btn bg-body" disabled>
              <span class=""><i class="ki-solid ki-timer fs-2x"
                  :class="(getReplyNotification(activeChat)).class">
                </i></span></b-button>
          </span>
        </div>
      </div>
      <span class="fw-semibold d-block">@{{ activeChat.phone }}</span>
    </div>
  </div>

  <div class="flex-1 justify-content-end" v-if="!isFromMeta()">
    <b-dropdown size="sm" id="dropdown-right" right :text="getAssignedUser(activeChat)" class="m-2">
      <b-dropdown-item v-for="(user, key) in users" :key="key" @click="assignUser(key, activeChat.id)">
        @{{ user }}
      </b-dropdown-item>
    </b-dropdown>
    @if ($company->getConfig('translation_enabled', false))
      <b-dropdown size="sm" id="dropdown-right" right :text="translationLanguage(activeChat)" class="m-2">
        <b-dropdown-item v-for="lang in languages" :key="key" @click="setLanguage(lang, activeChat)">
          @{{ lang }}
        </b-dropdown-item>
      </b-dropdown>
    @endif
  </div>
</div>
