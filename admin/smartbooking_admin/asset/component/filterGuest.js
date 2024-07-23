Vue.component("filterguest", {
    template:
    `<div class="row">
        <div class="col-md-12">
            <small><b>{{ _r('Guest', 'ผู้เข้าพัก', lang) }}</b></small>
            <div style="overflow:hidden; white-space:nowrap;">
                <input type="text" style="width:calc(100% - 38px); float:left;" class="form-control" v-model="filter.guest_name" @change="load()" disabled>
                <button style="border-radius:0px; width:38px; height:38px; float:left;" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#searchGuestModal"><i class="fa fa-search"></i></button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="searchGuestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="height:90vh;">
                <div class="modal-content" style="height:100%;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">{{ _r('Search', 'ค้นหา', lang) }} Guest</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="overflow-y:auto;">
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-12">
                                <div style="overflow:hidden; white-space:nowrap;">
                                    <input type="text" placeholder="Search Name, Phone, Email or Username" style="width:calc(100% - 52px); float:left;" class="form-control" v-model="guestSearchQuery" @keyup.enter="searchGuest()" id="searchGuestInput">
                                    <button style="margin-left:-3px; border-radius:0px; padding-left:5px; padding-right:5px; width:52px; height:38px; float:left;" class="btn btn-sm btn-success" @click="searchGuest()">Search</button>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:10px">
                                <table style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th style="width:70px">{{ _r('Photo', 'รูปภาพ', lang) }}</th>
                                            <th style="width:200px">{{ _r('Email', 'อีเมล', lang) }}</th>
                                            <th>{{ _r('Name', 'ชื่อ', lang) }}</th>
                                            <th style="width:200px">{{ _r('Contact Number', 'เบอร์โทรติดต่อ', lang) }}</th>
                                            <th style="width:70px; font-size:13px; font-weight:normal;">{{ _r('Action', 'ดำเนินการ', lang) }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(g, i) in guestSearchResult">
                                            <td class="text-center">
                                                <img style="width:40px;" :src="g.photo_url">
                                            </td>
                                            <td class="text-left">{{ g.email }}</td>
                                            <td class="text-left">{{ g.name }}</td>
                                            <td class="text-right">{{ g.contact_number }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success" @click="selectGuest(i)">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 text-center" style="margin-top:10px; font-size:16px;" v-if="guestSearchResult.length == 0 && searched">
                                {{ _r('No Result Found !!', 'ไม่พบผลลัพธ์ !!', lang) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`,
    props: ['lang', 'filter', 'search_guest_url'],
    data: () => { return {
        searched: false,
        guestSearchQuery: '',
        guestSearchResult: {}
    }},
    mounted() {
        $(document).on('shown.bs.modal', '#searchGuestModal', function (e) {
            $('#searchGuestInput').focus();
        });
    },
    methods: {
        searchGuest() {
            if (!this.guestSearchQuery) {
                return;
            }

            let self = this;
            let param = {query: this.guestSearchQuery};
            $.post(this.search_guest_url, param, function(res) {
                if (res.result == 'false') {
                    alert(res.message);
                    return;
                } else {
                    self.searched = true;
                    self.guestSearchResult = res.message;
                }
            });
        },
        selectGuest(id) {
            let guest = JSON.parse(JSON.stringify(this.guestSearchResult[id]));
            this.filter.guest_id = guest.id_guest;
            this.filter.guest_name = guest.name;

            this.$emit('change-filter', this.filter);
            $('#searchGuestModal').modal('hide');
        },
        load() {
            this.$emit('change-filter', this.filter);
        }
    }
});