<div class="mb-4 p-4 rounded bg-gray-50 border">
        <div class="flex gap-3 items-start">
            <div class="text-2xl text-green-600"><i class="fa-solid fa-circle-info"></i></div>
            <div>
                <h3 class="font-semibold">Basic Information</h3>
                <div class="text-sm text-gray-500">Enter the essential details such as template name, language, and category to identify your message.</div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="block text-sm font-medium">Template Name *</label>
        <input v-model="template_name" type="text" name="name" id="name" class="w-full p-2 border rounded" placeholder="Enter a descriptive template name">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Languages *</label>
            <select v-model="language" name="language" id="language" class="w-full p-2 border rounded">
                <option value="">{{ __('Select Language') }}</option>
                @foreach ($languages as $language)
                    <option value="{{ $language[1] }}">{{ $language[0] }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Category *</label>
            <select v-model="category" name="category" id="category" class="w-full p-2 border rounded">
                <option value="MARKETING">Marketing</option>
                <option value="UTILITY">Utility</option>
            </select>
        </div>
    </div>