Vue.component("filterroom", {
    template:
    `<div class="row">
        <div class="col-md-6">
            <small><b>{{ _r('Project', 'โปรเจกต์', lang) }}</b></small>
            <select class="form-control" v-model="filter.project" @change="changeProject()">
                <option value="All">{{ _r('All', 'ทั้งหมด', lang) }}</option>
                <option v-for="p in projects" :value="p.id_project_info">{{ _r(p.project_name_en, p.project_name_th, lang) }}</option>
            </select>
        </div>
        <div class="col-md-6">
            <small><b>{{ _r('Room', 'ห้องพัก', lang) }}</b></small>
            <select class="form-control" v-model="filter.room" @change="load()">
                <option value="All">{{ _r('All', 'ทั้งหมด', lang) }}</option>
                <option v-for="r in tmp_rooms" :value="r.id_room_details">{{ '('+  _r(r.room_type_name_en, r.room_type_name_th, lang) +') '+  _r(r.room_name_en, r.room_name_th, lang) }}</option>
            </select>
        </div>
    </div>`,
    props: ['lang', 'filter', 'projects', 'rooms'],
    data: () => { return {
        tmp_rooms: {}
    }},
    mounted() {
        this.tmp_rooms = JSON.parse(JSON.stringify(this.rooms));
    },
    methods: {
        changeProject() {
            let self = this;
            let tmp = [];
            this.rooms.forEach((r) => {
                if (self.filter.project == 'All' || self.filter.project == r.id_project_info) {
                    tmp.push(r);
                }
            });
            this.tmp_rooms = tmp;
            this.filter.room = 'All';
            this.load();
        },
        load() {
            this.$emit('change-filter', this.filter);
        }
    }
});