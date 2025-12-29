<script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
<script>
    var journey_id = "{{ $journey->id }}";

    //Stages
    var stages = @json($journey->stages);

    console.log(stages);
    document.addEventListener('DOMContentLoaded', function() {
        var KanbanTest = new jKanban({
            element: "#myKanban",
            gutter: "10px",
            widthBoard: "285px",
            itemHandleOptions: {
                enabled: false,
            },
            dragBoards: false, // Disable board/stage reordering
            click: function(el) {
                console.log("Trigger on all items click!");
            },
            context: function(el, e) {
                console.log("Trigger on all items right-click!");
            },
            dropEl: function(el, target, source, sibling) {
                console.log("element dropped")
                console.log(target.parentElement.getAttribute('data-id'));

                //Get the element id
                var elementId = el.dataset.eid;
                console.log(elementId);

                //Make a post request to the move contact to stage endpoint
                var url = "/stages/" + target.parentElement.getAttribute('data-id') +
                    "/move-contact/" + elementId;
                console.log(url);
                axios.get(url).then(response => {
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                });
            },
            boards: stages.map(stage => ({
                id: stage.id.toString(),
                title: `${stage.name} <a href="/stages/${stage.id}/edit" class="btn btn-sm btn-secondary float-right" style="opacity: 0.8"><i class="ki-duotone ki-pencil"><span class="path1"></span><span class="path2"></span></i></a>`,
                class: "info",
                item: [
                    ...stage.contacts.map(contact => ({
                        id: contact.id.toString(),
                        title: `
    <div class="d-flex align-items-center">
         <div class="symbol symbol-30px symbol-circle me-3">
                ${contact.avatar
                    ? `<img src="${contact.avatar}" alt="${contact.name}">`
                    : `<span class="symbol-label bg-primary text-white fw-bold">${contact.name.charAt(0).toUpperCase()}</span>`
                }
            </div>
            <div>
                <div class="fw-semibold text-gray-900">${contact.name}</div>
                <div class="text-muted fs-8">${contact.phone}</div>
            </div>
    </div>
`,

                        drag: function(el, source) {
                            console.log("START DRAG: " + el.dataset.eid);
                        },
                        dragend: function(el) {
                            console.log("END DRAG: " + el.dataset.eid);
                        },
                        drop: function(el) {
                            console.log("DROPPED: " + el.dataset.eid);
                        }
                    }))
                ]
            }))
        });
    });
</script>