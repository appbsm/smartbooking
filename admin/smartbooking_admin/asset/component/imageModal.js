Vue.component("imagemodal", {
    template:
    `<div class="modal fade" id="showImageModal" tabindex="-1" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="height:90vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="modallabel">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="row">
                        <div class="col-md-12">
                            <img :src="showimage" style="width:100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`,
    props: ['showimage', 'title'],
    data: () => { return {
    }},
    mounted() {
    },
    methods: {
    }
});