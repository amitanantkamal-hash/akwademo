<div class="p-3 border rounded bg-gray-50 relative">
    <div class="flex gap-3 items-start">
        <div class="text-2xl text-green-600"><i class="fa-solid fa-align-left"></i></div>
        <div>
            <h3 class="font-semibold">Footer</h3>
            <div class="text-sm text-gray-500">Add an optional footer text.</div>
        </div>
    </div>

    <div class="absolute top-3 right-3">
        <label class="text-xs">
            <input type="checkbox" v-model="footerEnabled" @change="validateFooterText"> Enable Footer
        </label>
    </div>
</div>

<div v-show="footerEnabled" class="mt-3">
    <input v-model="footerText" @input="validateFooterText" maxlength="60" class="w-full p-2 border rounded" placeholder="Footer text">
    <p class="text-red-600 text-sm mt-2" v-text="footerError"></p>
</div>