Vue.component("filterdateall", {
    template:
    `<div class="row">
        <div class="col-md-4">
            <small><b>{{ _r('Date Type', 'ค้นหาจากวัน', lang) }}</b></small>
            <select class="form-control" v-model="filter.date_type" @change="load()">
                <option value="Created">{{ _r('Created Date', 'วันที่ทำการจอง/ทำรายการ', lang) }}</option>
                <option value="Confirmed">{{ _r('Paid Date', 'วันที่ชำระเงิน', lang) }}</option>
                <option value="Check-in">{{ _r('Booking Check-in Date', 'วัน check-in (Booking)', lang) }}</option>
                <option value="Check-out">{{ _r('Booking Check-out Date', 'วัน check-out (Booking)', lang) }}</option>
                <option value="Service">{{ _r('Order Service Date', 'วันที่ใช้บริการ (Order)', lang) }}</option>
            </select>
        </div>
        <div class="col-md-4">
            <small><b>{{ _r('Range', 'ช่วงเวลา', lang) }}</b></small>
            <select class="form-control" v-model="filter.range" @change="load()">
                <option value="Day">{{ _r('Daily', 'รายวัน', lang) }}</option>
                <option value="Month">{{ _r('Monthly', 'รายเดือน', lang) }}</option>
            </select>
        </div>
        <div class="col-md-4" v-show="filter.range == '' || filter.range == 'Month'">
            <small><b>{{ _r(filter.range, range_th[filter.range], lang) }}</b></small>
            <input type="text" class="form-control" id="Month" v-model="current_month">
        </div>
        <div class="col-md-2" v-show="filter.range == '' || filter.range == 'Day'">
            <small><b>{{ _r('From '+ filter.range, 'จาก'+ range_th[filter.range] +'ที่', lang) }}</b></small>
            <input type="text" class="form-control" id="DayFrom" v-model="current_date_from">
        </div>
        <div class="col-md-2" v-show="filter.range == '' || filter.range == 'Day'">
            <small><b>{{ _r('To '+ filter.range, 'ถึง'+ range_th[filter.range] +'ที่', lang) }}</b></small>
            <input type="text" class="form-control" id="DayTo" v-model="current_date_to">
        </div>
    </div>`,
    props: ['lang', 'filter'],
    data: () => { return {
        range_th: {'Day': 'วัน', 'Month': 'เดือน'},
        current_date_from: currentDate(),
        current_date_to: currentDate(),
        current_month: currentMonth()
    }},
    mounted() {
        let self = this;
        setTimeout(() => {
            self.filter.range = 'Day';
        }, 10);

        $("#DayFrom").datepicker({
            dateFormat: "dd/mm/yy",
            onSelect: function(d) {
                self.filter.from_day = convertDateDash(d);
                self.current_date = convertDateSlash(self.filter.from_day) +' - '+ convertDateSlash(self.filter.to_day);
                self.load();
            }
        });
        $("#DayTo").datepicker({
            dateFormat: "dd/mm/yy",
            onSelect: function(d) {
                self.filter.to_day = convertDateDash(d);
                self.current_date = convertDateSlash(self.filter.from_day) +' - '+ convertDateSlash(self.filter.to_day);
                self.load();
            }
        });

        $("#Month").datepicker({
            dateFormat: "mm/yy",
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                var m = $.datepicker.formatDate("mm/yy", new Date(year, month, 1));
                self.current_month = m;
                self.filter.month = convertMonthDash(m);
                self.load();
            }
        });
        $("#Month").focus(function() {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({my: "center top", at: "center bottom", of: $(this)});
        });
    },
    methods: {
        load() {
            this.$emit('change-filter', this.filter);
        }
    }
});