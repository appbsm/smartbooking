///// Excel Function
function download_csv(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV FILE
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // We have to create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Make sure that the link is not displayed
    downloadLink.style.display = "none";

    // Add the link to your DOM
    document.body.appendChild(downloadLink);

    // Lanzamos
    downloadLink.click();
}
function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
}
function export_table_to_csv(index) {
    var csv = [];
    var rows = document.querySelectorAll("table");

    var rowNew = rows[index].querySelectorAll('tr');

    for (var i = 0; i < rowNew.length; i++) {
        var row = [],
            cols = rowNew[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText.replace(/,/g, ''));

        csv.push(row.join(","));

    }


    return csv.join("\n");
}
function doExcel1(fileName) {
    var csv = [];
    var blob,
        wb = { SheetNames: [], Sheets: {} };

    for (let i = 0; i < document.querySelectorAll('.result_table').length; i++) {

        var sheetd = 'Sheet' + (i + 1);

        var ws1 = XLSX.read(export_table_to_csv(i), { type: "binary" }).Sheets.Sheet1;
        wb.SheetNames.push(sheetd);
        wb.Sheets[sheetd] = ws1;

    }

    blob = new Blob([s2ab(XLSX.write(wb, { bookType: 'xlsx', type: 'binary' }))], {
        type: "application/octet-stream"
    });

    download_csv(blob, fileName);
}

///// Date && Time
function getCurrentDate() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy +'-'+ mm +'-'+ dd;
    return today;
}
function validateDate(dateStr) {
    const regex = /^\d{4}-\d{2}-\d{2}$/;
    if (dateStr.match(regex) === null) {
        return false;
    }

    const date = new Date(dateStr);
    const timestamp = date.getTime();
    if (typeof timestamp !== 'number' || Number.isNaN(timestamp)) {
        return false;
    }

    return date.toISOString().startsWith(dateStr);
}
function validateTime(timeStr) {
    let d = timeStr.split(':');
    if (d.length == 2 && d[0].length == 2 && d[1].length == 2 && isNumber(d[0]) && isNumber(d[1]) && parseInt(d[0]) <= 23 && parseInt(d[1]) <= 59) {
        return true;
    }

    d = timeStr.split('.');
    if (d.length == 2 && d[0].length == 2 && d[1].length == 2 && isNumber(d[0]) && isNumber(d[1]) && parseInt(d[0]) <= 23 && parseInt(d[1]) <= 59) {
        return true;
    }

    return false;
}
function dateDiff(date1, date2) {
    var d1 = new Date(date1);
    var d2 = new Date(date2);

    var dif = d2.getTime() - d1.getTime();
    var daydiff = dif / (1000 * 60 * 60 * 24);

    return daydiff;
}
function hourDiff(date1, date2) {
    var d1 = new Date(date1);
    var d2 = new Date(date2);

    var dif = d2.getTime() - d1.getTime();
    var hourdiff = dif / (1000 * 60 * 60);

    return hourdiff;
}
function nextWeek() {
    var today = new Date();
    today.setDate(today.getDate() + 6);
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    return dd +'/'+ mm +'/'+ yyyy;
}
function currentDate() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    return dd +'/'+ mm +'/'+ yyyy;
}
function currentMonth() {
    var today = new Date();
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    return mm +'/'+ yyyy;
}
function convertMonthSlash(date) {
    if (date && date !== null && date !== undefined && date.length > 0 && date.includes('-')) {
        let d = date.split('-');
        return d[1] +'/'+ d[0];
    } else {
        return date;
    }
}
function convertDateSlash(date) {
    if (date && date !== null && date !== undefined && date.length > 0 && date.includes('-')) {
        let d = date.split('-');
        return d[2] +'/'+ d[1] +'/'+ d[0];
    } else {
        return date;
    }
}
function convertMonthDash(date) {
    if (date && date !== null && date !== undefined && date.length > 0 && date.includes('/')) {
        let d = date.split('/');
        return d[1] +'-'+ d[0];
    } else {
        return date;
    }
}
function convertDateDash(date) {
    if (date && date !== null && date !== undefined && date.length > 0 && date.includes('/')) {
        let d = date.split('/');
        return d[2] +'-'+ d[1] +'-'+ d[0];
    } else {
        return date;
    }
}
function formatDate(date) {
    if (date.includes('/')) {
        date = convertDateDash(date);
    }

    let d = date.split('-');
    let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    return months[parseInt(d[1]) - 1] +' '+ parseInt(d[2]) +', '+ d[0];
}
function formatDateThai(date) {
    if (date.includes('/')) {
        date = convertDateDash(date);
    }

    let d = date.split('-');
    let months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    return parseInt(d[2]) +' '+ months[parseInt(d[1]) - 1] +' '+ (parseInt(d[0]) + 543);
}
function formatDateShort(date) {
    if (date.includes('/')) {
        date = convertDateDash(date);
    }

    let d = date.split('-');
    let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    return months[parseInt(d[1]) - 1] +' '+ parseInt(d[2]);
}
function formatDateThaiShort(date) {
    if (date.includes('/')) {
        date = convertDateDash(date);
    }

    let d = date.split('-');
    let months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    return parseInt(d[2]) +' '+ months[parseInt(d[1]) - 1];
}

/////
function shift_json(json) {
    tmp = JSON.parse(JSON.stringify(json))
    tmp.shift();
    return tmp;
}
function formatBaht(v) {
    return (v || '0').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function isNumber(v) {
    return /^\d+$/.test(v);
}
function onlyNumbers(array) {
    return array.every((v) => {
        return isNumber(v.trim());
    });
}
function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}
function getBsClass(status) {
    if (status == 'Booked' || status == 'Ordered') {
        return 'danger';
    } else if (status == 'Verifying') {
        return 'warning';
    } else if (status == 'Confirmed') {
        return 'success';
    } else if (status == 'Checked-in') {
        return 'primary';
    } else if (status == 'Checked-out' || status == 'Closed') {
        return 'info';
    } else if (status == 'Cancel') {
        return 'secondary';
    } else if (status == 'Expired') {
        return 'light border border-secondary';
    }
}
function joinArrayValue(array, key, type = '') {
    let tmp = [];
    array.forEach((v) => {
        tmp.push(type == 'number' ? formatBaht(v[key]) : v[key]);
    });

    return tmp.join(type == 'number' ? ' | ' : ', ');
}
function getMax(array) {
    max = '-';
    array.forEach((v) => {
        if (max == '-' || v > max) {
            max = v;
        }
    });
    return max;
}
function getMin(array) {
    min = '-';
    array.forEach((v) => {
        if (min == '-' || v < min) {
            min = v;
        }
    });
    return min;
}
function changeLanguage(url = '', lang = 'EN', step = '') {
    let param = {'lang': lang};
    $.post(url, param, function(res) {
        if (res.result == 'false') {
            alert(res.message);
            return;
        } else {
            $.blockUI({css:{'backgroundColor':'#d9d9d9', 'padding-top':'10px'}});
            let href = window.location.href;
            if (href.slice(-1) == '#') {
                href = href.substring(0, href.length - 1);
            }

            // empty query string
            if (!href.includes('?')) {
                // empty step
                if (!step) {
                    window.location.href =  href;
                // have step
                } else {
                    window.location.href =  href +'?step='+ step;
                }
            // have query string
            } else {
                // empty step
                if (!step) {
                    window.location.href =  href;
                // have step
                } else {
                    // have step param
                    if (href.includes('step=')) {
                        let url = new URL(href);
                        let search_params = url.searchParams;
                        search_params.set('step', step);
                        url.search = search_params.toString();
                        window.location.href = url.toString();
                    // no step param
                    } else {
                        window.location.href =  href +'&step='+ step;
                    }
                }
            }

            setTimeout(() => {
                $.unblockUI();
            }, 1000);
        }
    });
}
function _r(en = '', th = '', lang = '') {
    return lang == 'TH' ? th : en;
}
function showImage(img) {
    app.show_image = img;
}

function sumByCol(array, col) {
    let sum = 0;
    array.forEach((v, i) => {
        sum += parseFloat(v[col]);
    });
    return sum.toFixed(2);
}

function sumByCol_string(array, col) {
    let sum = 0;
    array.forEach((v, i) => {
        sum += parseFloat(v[col]);
    });
    return sum;
}

function sumByCol_stringToArray(array=[], col='') {
    //alert(col)
    let result = '';
	let sum1 = 0; 
    let sum2 = 0;
    /*
    var array = ['1|0', '2|1'];
    var ctr = 0;
    array.forEach((v) => {
        console.log(v);
        let col_split = v.split("|");
        console.log(col_split);
        sum1 += parseInt(col_split[0]);
		sum2 += parseInt(col_split[1]);
        ctr++;
        console.log('COUNTER:'+ctr);
        
    });
    console.log('SUM'+sum1+' '+sum2);
    */
    array.forEach((v, i) => {
        let col_split = v[col].split("|");
		sum1 += parseInt(col_split[0]);
		sum2 += parseInt(col_split[1]);
    });
	result = sum1+'|'+sum2;
    return result;
}

function add_days_to_date (date, days) {
    const d = new Date(date);
    var unix_date = d.setDate(d.getDate() + days);
    //var s = new Date(unix_date).toLocaleDateString();
    var s = new Date(unix_date);
    return (days == 0) ? date : formatDate(s);
}

function formatDate(date = new Date()) {
    const year = date.toLocaleString('default', {year: 'numeric'});
    const month = date.toLocaleString('default', {
      month: '2-digit',
    });
    const day = date.toLocaleString('default', {day: '2-digit'});
  
    return [year, month, day].join('-');
  }


setTimeout(() => {
    //console.clear();
}, 500);