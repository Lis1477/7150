// функция форматирования цены
function number_format(number) {

    var decimals = 2;
    var dec_point = '.';
    var thousands_sep = '';

    var sign = number < 0 ? '-' : '';

    var s_number = Math.abs(parseInt(number = (+number || 0).toFixed(decimals))) + "";
    var len = s_number.length;
    var tchunk = len > 3 ? len % 3 : 0;

    var ch_first = (tchunk ? s_number.substr(0, tchunk) + thousands_sep : '');
    var ch_rest = s_number.substr(tchunk).replace(/(\d\d\d)(?=\d)/g, '$1' + thousands_sep);
    var ch_last = decimals ? dec_point + (Math.abs(number) - s_number).toFixed(decimals).slice(2) : '';

    return sign + ch_first + ch_rest + ch_last;
}
