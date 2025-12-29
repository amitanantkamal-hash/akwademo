<div class="p-3 border rounded bg-gray-50">
    <div class="flex gap-3 items-start">
        <div class="text-2xl text-green-600"><i class="fa-solid fa-pen"></i></div>
        <div>
            <h3 class="font-semibold">Message Body</h3>
            <div class="text-sm text-gray-500">Write the main content of your message. Use variables for dynamic values if needed.</div>
        </div>
    </div>
</div>

<div class="flex gap-2 mt-3 mb-2">
    <button type="button" class="px-2 py-1 border rounded" @click="wrapSelectionWith('*')"><b>B</b></button>
    <button type="button" class="px-2 py-1 border rounded" @click="wrapSelectionWith('_')"><i>I</i></button>
    <button type="button" class="px-2 py-1 border rounded" @click="wrapSelectionWith('~')"><s>S</s></button>
    <button type="button" class="px-2 py-1 border rounded" @click="wrapSelectionWith('`')"><code>&lt;/&gt;</code></button>

    <div class="ml-auto">
        <button type="button" class="px-3 py-1 bg-green-600 text-white rounded" @click="addVariable">+ Add Variable</button>
    </div>
</div>

<div class="mb-3">
    <textarea rows="6" v-model="bodyText" name="body" id="body" class="w-full p-3 border rounded h-40" placeholder="Type your message..." @keydown="handleKeydown" @input="limitBodyText" ref="messageInput"></textarea>
    <div class="text-xs text-gray-500 mt-2">Shortcut Keys: CTRL + B for Bold, CTRL + I for Italics, CTRL + SHIFT + C for Monospace, CTRL + SHIFT + X for Strikethrough. Character limit: 1024.</div>
</div>

<div v-if="bodyVariables" class="mt-3 bg-gray-50 p-3 rounded">
    <label class="block text-sm font-semibold">Samples for body content</label>
    <div class="text-sm text-gray-500 mb-2">To help us review your content, provide examples of the variables in the body.</div>

    <div v-for="(v, index) in bodyVariables" :key="index" class="input-group mb-2 flex gap-2">
        <span class="px-3 py-2 bg-gray-100 border rounded">@{{ v }}</span>
        <input v-model="bodyExampleVariable[index]" type="text" class="flex-1 p-2 border rounded" placeholder="Enter content for the variable">
    </div>
</div>