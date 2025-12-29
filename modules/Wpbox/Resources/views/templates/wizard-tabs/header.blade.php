<div class="p-3 border rounded bg-gray-50 relative">
    <div class="flex gap-3 items-start">
        <div class="text-2xl text-green-600"><i class="fa-solid fa-image"></i></div>
        <div>
            <h3 class="font-semibold">Header Configuration</h3>
            <div class="text-sm text-gray-500">Add an optional header — text, image, PDF or video.</div>
        </div>
    </div>

    <div class="absolute top-3 right-3">
        <label class="text-xs">
            <input type="checkbox" v-model="headerEnabled" @change="updateHeader"> Enable Header
        </label>
    </div>
</div>

<!-- Header Type Dropdown -->
<div v-show="headerEnabled" class="mt-4">
    <label class="block text-sm font-medium">Header type</label>
    <select v-model="headerType" @change="validateHeaderText" class="w-full p-2 border rounded">
        <option value="none">None</option>
        <option value="text">Text</option>
        <option value="image">Image</option>
        <option value="video">Video</option>
        <option value="pdf">PDF</option>
    </select>
</div>

<!-- =============================== -->
<!--        HEADER TEXT (OLD STYLE) -->
<!-- =============================== -->
<div v-if="headerEnabled && headerType === 'text'" class="mt-4">
    <label class="block text-sm font-medium">Header text</label>

    <div class="flex gap-2">
        <input 
            v-model="headerText" 
            @input="validateHeaderText" 
            type="text" 
            name="header_text" 
            id="header_text" 
            class="flex-1 p-2 border rounded" 
            placeholder="Header text"
        >
        <button 
            type="button" 
            class="px-3 py-1 border rounded bg-blue-50 hover:bg-blue-100"
            @click="addHeaderVariable"
        >
            Add variable
        </button>
    </div>

    <div class="text-xs text-gray-500 mt-2">Characters limit 60.</div>

    <div v-if="headervariableAdded" class="mt-3 bg-gray-50 p-3 rounded">
        <label class="block text-sm font-semibold">Samples for header content</label>
        <small class="text-gray-500">
            To help us review your content, provide examples for the header variable.
        </small>

        <div class="flex mt-2">
            <span class="px-3 py-2 bg-gray-100 border rounded-l">
                @{{ '{' }}{1}@{{ '}' }}
            </span>
            <input 
                v-model="headerExampleVariable" 
                type="text" 
                class="flex-1 p-2 border rounded-r"
                placeholder="Enter content for the header variable"
            >
        </div>
    </div>
</div>

<!-- =============================== -->
<!--        IMAGE UPLOAD BOX        -->
<!-- =============================== -->
<div v-if="headerEnabled && headerType === 'image'" class="mt-4">
    <div class="border rounded-lg p-4 bg-white">
        
        @include('wpbox::file_manager.mini', [
            'id' => 'header_image',
            'changevue' => 'handleImageUpload',
            'type' => 'image',
            'select_multi' => 0,
            'name' => __('Select image'),
            'required' => true,
            'accept' => '.jpg, .jpeg, .png',
        ])
        
    </div>
</div>

<!-- =============================== -->
<!--        VIDEO UPLOAD BOX        -->
<!-- =============================== -->
<div v-if="headerEnabled && headerType === 'video'" class="mt-4">
    <div class="border rounded-lg p-4 bg-white">
        
        @include('wpbox::file_manager.mini', [
            'id' => 'header_video',
            'changevue' => 'handleVideoUpload',
            'type' => 'video',
            'select_multi' => 0,
            'name' => __('Select video'),
            'required' => true,
            'accept' => '.mp4',
        ])
        
    </div>
</div>

<!-- =============================== -->
<!--        PDF UPLOAD BOX          -->
<!-- =============================== -->
<div v-if="headerEnabled && headerType === 'pdf'" class="mt-4">
    <div class="border rounded-lg p-4 bg-white">
        
        @include('wpbox::file_manager.mini', [
            'id' => 'header_pdf',
            'name' => __('Header PDF'),
            'type' => 'pdf',
            'required' => true,
            'accept' => 'application/pdf',
            'select_multi' => 0,
        ])
        
    </div>
</div>
