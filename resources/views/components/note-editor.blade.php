<div data-ng-app="NoteManager">
    <div data-ng-controller="MainController as $ctrl" class="position-static">
        <div class="d-flex position-static" style="top: 0; bottom: 0; left: 0; right: 0;">
            <div class="h-100 col-4 position-static">
                <div class="d-flex align-items-center">
                    <h3>{{__('Notes')}}</h3>
                    <button class="btn btn-sm ms-auto" data-ng-click="$ctrl.create()" title="{{__('Add note')}}">
                        <span class="ki-outline ki-plus-square fs-1 text-primary"></span>
                    </button>
                </div>
                <div data-ng-if="$ctrl.notes.length" class="d-flex flex-column gap-5 my-5">
                    <div ng-repeat="note in $ctrl.notes" class="d-flex flex-stack">
                        <a href="#" data-ng-click="$ctrl.select(note)" class="fs-6 fw-bold text-gray-800 @{{$ctrl.currentNoteId == note.id ? 'active' : ''}} text-hover-primary text-active-primary">@{{note.title}}</a>
                    </div>
                </div>
                <div data-ng-if="!$ctrl.notes.length" class="d-flex flex-column gap-5 my-5">
                    @foreach (App\Models\Note::where('user_id', auth()->user()->id)->get() as $note)
                        <div class="d-flex flex-stack">
                            <a href="#" data-ng-click="$ctrl.select({ user_id: {{$note->user_id}}, title: '{{$note->title}}', body: '{{$note->body}}', id: {{$note->id}} })" class="fs-6 fw-bold text-gray-800 @{{$ctrl.currentNoteId == note.id ? 'active' : ''}} text-hover-primary text-active-primary">{{$note->title}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="h-100 col-8">
                <div class="my-3">
                    <label for="title" class="form-label">{{__('Title')}}</label>
                    <input type="text" autofocus id="title" data-ng-model="$ctrl.currentNoteTitle" class="form-control">
                </div>
                <div class="my-3">
                    <label class="form-label" for="body">{{__('Body')}}</label>
                    <textarea data-ng-model="$ctrl.currentNoteText" id="body" class="form-control" style="resize: none; min-height: 50vh;"></textarea>
                </div>
                <div class="text-end">
                    <button data-ng-click="$ctrl.delete($ctrl.currentNoteId)" data-ng-if="$ctrl.currentNoteId != 0" class="btn btn-danger">
                        <span class="d-flex align-items-center">
                            <span class="ki-outline ki-trash fs-3 me-2 text-white"></span>
                            {{__('Delete')}}
                        </span>
                    </button>
                    <button class="btn btn-info" data-ng-click="$ctrl.save()">
                        <span data-ng-if="$ctrl.currentNoteId != 0" class="d-flex align-items-center">
                            <span class="ki-outline ki-exit-up fs-3 me-2 text-white"></span>{{__('Update')}}
                        </span>
                        <span data-ng-if="$ctrl.currentNoteId == 0" class="d-flex align-items-center">
                            <span class="ki-outline ki-exit-up fs-3 me-2 text-white"></span>{{__('Save')}}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js') }}/angular-1.8.2/angular.min.js"></script>
<script>
    (function() {
        const app = angular
            .module('NoteManager', [])
            .controller('MainController', class MainController {
                notes = [];
                userId = {{auth()->user()->id}};
                currentNote = null;
                currentNoteTitle = "";
                currentNoteText = "";
                currentNoteId = 0;
                csrfToken = "";

                constructor() {
                    this.csrfToken = this.getCookieValue('XSRF-TOKEN');
                    this.load();
                    this.create();
                }

                getCookieValue(name) {
                    let value = "; " + document.cookie;
                    let parts = value.split("; " + name + "=");
                    if (parts.length === 2) return parts.pop().split(";").shift();
                }

                async load() {
                    const response = await fetch('/notes/' + this.userId, {
                        headers: {
                            'XSRF-TOKEN': this.csrfToken,
                        }
                    });
                    const data = await response.json();
                    this.notes = [];
                    data.forEach(note => this.notes.push(note))
                }

                select(note) {
                    this.currentNoteTitle = note.title;
                    this.currentNoteText = note.body;
                    this.currentNoteId = note.id;
                }

                create() {
                    this.currentNoteTitle = "";
                    this.currentNoteText = "";
                    this.currentNoteId = 0;
                }

                async store() {
                    const title = this.currentNoteTitle;
                    const body = this.currentNoteText;
                    const user_id = this.userId;
                    const formData = new FormData();

                    formData.append('title', title);
                    formData.append('body', body);
                    formData.append('user_id', user_id);

                    const response = await fetch('/notes', {
                        method: 'POST',
                        body: formData
                    })

                    const data = await response.json();

                    this.load();
                }

                async update() {
                    const title = this.currentNoteTitle;
                    const body = this.currentNoteText;
                    const id = this.currentNoteId;
                    const user_id = this.userId;
                    const formData = new FormData();

                    formData.append('title', title);
                    formData.append('body', body);
                    formData.append('user_id', user_id);
                    formData.append('id', id);

                    const response = await fetch('/notes/' + id, {
                        method: 'PUT',
                        body: formData
                    })

                    const data = await response.json();

                    this.load();
                }

                async delete(id) {
                    const response = await fetch('/notes/' + id, {
                        method: 'DELETE'
                    });
                    const data = await response.json();

                    this.load();
                }

                save() {
                    if (this.currentNoteText && this.currentNoteTitle) {
                        if (this.currentNoteId == 0) {
                            this.store();
                        } else {
                            this.update();
                        }
                    } else {
                        alert('{{__("Notes require a title and some content.")}}');
                    }
                }
            });
    })();
</script>
