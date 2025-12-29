<div class="section-box p-4 border rounded bg-gray-50">
    <div class="flex gap-4">
        <div class="section-icon text-2xl text-green-600"><i class="fa-solid fa-hand-pointer"></i></div>
        <div class="flex-1">
            <div class="section-title font-semibold text-lg">Interactive Buttons</div>
            <div class="section-desc text-sm text-gray-500 mt-1 flex items-center justify-between">
                Add quick replies or call-to-action buttons.
                <button type="button"
                        @click="addButton()"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    + Add Button
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Dynamic Buttons -->
<div v-for="(btn, index) in buttonsList" :key="btn.id" class="mt-4 border p-4 rounded bg-white">
    <div class="flex gap-2 items-center mb-2">
        <select v-model="btn.type" @change="updateButtonType(index)" class="flex-1 p-2 border rounded">
            <option value="quick_reply">Quick Reply</option>
            <option value="visitWebsite">Website URL</option>
            <option value="callPhone">Phone Number</option>
            <option value="offerCode">Offer Code</option>
        </select>
        <button type="button" class="text-red-600 font-semibold px-2 py-1 rounded border border-red-600 hover:bg-red-50"
                @click="deleteButton(index)">Delete</button>
    </div>

    <!-- Input fields based on type -->
    <input v-if="btn.type === 'quick_reply'" v-model="btn.text" @input="limitQuickReplyText(index)"
           placeholder="Button text - Limit 25 Char" class="p-2 border rounded w-full mt-2">

    <div v-if="btn.type === 'visitWebsite'" class="grid grid-cols-2 gap-2 mt-2">
        <input v-model="btn.title" @input="limitVisitWebsiteText(index)" placeholder="Button text" class="p-2 border rounded w-full">
        <input v-model="btn.url" @input="limitVisitWebsiteUrl(index)" placeholder="https://example.com" class="p-2 border rounded w-full">
    </div>

    <div v-if="btn.type === 'callPhone'" class="grid grid-cols-3 gap-2 mt-2">
        <input v-model="btn.text" @input="limitCallPhoneText(index)" placeholder="Button text" class="p-2 border rounded w-full">
        <input v-model="btn.dialCode" @input="validateNumbers('dialCode', index)" placeholder="{{__('Dial code')}}" class="p-2 border rounded">
        <input v-model="btn.phoneNumber" @input="validateNumbers('phoneNumber', index)" placeholder="{{__('Phone number')}}" class="p-2 border rounded">
    </div>

    <div v-if="btn.type === 'offerCode'" class="grid grid-cols-2 gap-2 mt-2">
        <input v-model="btn.offerCode" @input="limitCouponCodeText(index)" placeholder="Offer code" class="p-2 border rounded w-full">
        <div class="text-xs text-gray-500">Characters limit 15.</div>
    </div>
</div>
