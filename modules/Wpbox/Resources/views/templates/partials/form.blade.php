<div class="max-w-7xl mx-auto grid grid-cols-12 gap-5" id="template_creator">
    <!-- LEFT FORM -->
    <div class="col-span-8 bg-white p-6 rounded shadow">

        <!-- STEP NAVIGATION -->
        <div class="flex items-center justify-between mb-4">
            <template v-for="(s, index) in [
                { id: 'basic', label: 'Basic Info' },
                { id: 'header', label: 'Header' },
                { id: 'body', label: 'Message Body' },
                { id: 'footer', label: 'Footer' },
                { id: 'buttons', label: 'Buttons' }
            ]">
                <div class="flex-1 text-center cursor-pointer"  :key="s.id" @click.prevent="goToStep(s.id)">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 mx-auto"
                        :class="step === s.id ? 'border-green-600 text-green-600' : 'border-gray-300'">
                        <span>@{{ stepsMap[s.id].completed ? '✓' : (Object.keys(stepsMap).length ? (Object.keys(stepsMap).indexOf(s.id) + 1) : (index+1)) }}</span>
                    </div>
                    <div class="text-xs mt-1">@{{ s.label }}</div>
                </div>
            </template>
        </div>

        <hr class="my-4">

        <!-- STEP: BASIC -->
        <div v-show="step === 'basic'">
            @include('wpbox::templates.wizard-tabs.basic')
        </div>

        <!-- STEP: HEADER -->
        <div v-show="step === 'header'" class="mt-6">
            @include('wpbox::templates.wizard-tabs.header')
        </div>

        <!-- STEP: BODY -->
        <div v-show="step === 'body'" class="mt-6">
            @include('wpbox::templates.wizard-tabs.body')
        </div>

        <!-- STEP: FOOTER -->
        <div v-show="step === 'footer'" class="mt-6">
            @include('wpbox::templates.wizard-tabs.footer')
        </div>

        <!-- STEP: BUTTONS -->
        <div v-show="step === 'buttons'" class="mt-6">
            @include('wpbox::templates.wizard-tabs.buttons')
        </div>

        <!-- NAVIGATION BUTTONS -->
        <div class="mt-6 flex items-center justify-between">
            <button type="button" class="px-4 py-2 bg-gray-200 rounded" @click="previous">Previous</button>

            <div class="text-center">
                <small class="text-gray-500 mr-3" style="text-align: center;">Step @{{ stepIndex }} of 5</small>
            </div>
            <div class="text-right">
                <button type="button" class="btn btn-info px-4 py-2 rounded" @click="next" v-if="step !== 'buttons'">Next</button>
                
            </div>
        </div>

    </div>

    <!-- RIGHT PREVIEW -->
    <div class="col-span-4 bg-white rounded-lg shadow p-4 border">
        @include('wpbox::templates.wizard-tabs.preview')
    </div>
</div>