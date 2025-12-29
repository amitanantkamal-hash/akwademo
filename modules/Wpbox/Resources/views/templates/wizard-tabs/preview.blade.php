<div class="flex items-center gap-2 pb-3 border-b mb-3">
    <i class="fa-solid fa-eye text-green-600"></i>
    <span class="font-semibold text-gray-700">Template Preview</span>
</div>

<!-- Chat Bubble Card -->
<div class="p-4 rounded-lg bg-white">
    <div class="p-3 rounded-lg" style="background: url('{{ asset('uploads/default/dotflo/bg.png') }}'); background-size: cover;">
        <div class="wh-message">
            <!-- Header -->
            <div v-if="headerType !== 'none'">
    
                <!-- Image -->
                <img v-if="headerType == 'image' && headerImage"
                    :src="headerImage"
                    class="wh-header-img rounded mb-2" />

                <!-- Video -->
                <video v-if="headerType == 'video' && headerVideo"
                    :src="headerVideo"
                    class="wh-header-video rounded mb-2"
                    controls></video>

                <!-- PDF -->
                <iframe v-if="headerType == 'pdf' && headerPdf"
                        :src="headerPdf"
                        class="wh-header-pdf rounded mb-2 w-full h-48"></iframe>

                <!-- Text -->
                <h4 v-if="headerType == 'text'" class="wh-body p-2 card-title mb-2 break-words whitespace-pre-wrap"><strong>@{{ headerReplacedWithExample }}</strong></h4>
            </div>

            


            <!-- Body -->
            <div class="wh-body p-2 rounded text-gray break-words whitespace-pre-wrap" v-html="formattedBodyText"></div>

            <!-- Footer -->
            <span class="wh-body p-2 text-muted text-xs break-words whitespace-pre-wrap">@{{ footerText }}</span>

            <!-- Time -->
            <div class="wh-time mt-1 text-right small text-gray-500">
                @{{ new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}
            </div>

            <!-- Buttons / Quick Actions -->
            <div v-if="buttonsList.length > 0" class="wh-divider border-t mt-2 pt-2"></div>

            <div class="mt-2">
                <div v-for="(btn, i) in buttonsList" :key="btn.id">

                    <!-- Quick Reply -->
                    <div v-if="btn.type === 'quick_reply'"
                        class="wh-btn block w-full bg-white text-green-600 border px-3 py-2 rounded mb-2 text-center">
                        <i class="fa-regular fa-message"></i> @{{ btn.text }}
                    </div>

                    <!-- Website URL -->
                    <div v-if="btn.type === 'visitWebsite'"
                        class="wh-btn block w-full bg-white text-green-600 border px-3 py-2 rounded mb-2 text-center">
                        <i class="fa-solid fa-globe"></i> @{{ btn.title }}
                    </div>

                    <!-- Call Phone -->
                    <div v-if="btn.type === 'callPhone'"
                        class="wh-btn block w-full bg-white text-green-600 border px-3 py-2 rounded mb-2 text-center">
                        <i class="fa-solid fa-phone"></i> @{{ btn.text }}
                    </div>

                    <!-- Offer Code -->
                    <div v-if="btn.type === 'offerCode'"
                        class="wh-btn block w-full bg-white text-green-600 border px-3 py-2 rounded mb-2 text-center">
                        <i class="fa-solid fa-copy"></i> @{{ btn.offerCode }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Save Template Button -->
<div class="mt-4 text-right">
    <button type="button" class="btn btn-info rounded mt-2" @click="submitTemplate">
        Save Template
    </button>
</div>
