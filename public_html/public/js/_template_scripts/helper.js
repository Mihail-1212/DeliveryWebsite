"use strict"
function clone(cloneElement, ParentElement){
    var cln = cloneElement.cloneNode(true);
    ParentElement.appendChild(cln);
}

Array.prototype.sum = function (prop) {
    var total = 0
    for ( var i = 0, _len = this.length; i < _len; i++ ) {
        total += this[i][prop]
    }
    return total
}

function getDateTime(date){
    var ye = new Intl.DateTimeFormat('ru', { year: 'numeric' }).format(date)
    , mo = new Intl.DateTimeFormat('ru', { month: '2-digit' }).format(date)
    , da = new Intl.DateTimeFormat('ru', { day: '2-digit' }).format(date)
    , hour = new Intl.DateTimeFormat('ru', { hour: '2-digit' }).format(date)
    , minute = new Intl.DateTimeFormat('ru', { minute: '2-digit' }).format(date)
    , second =new Intl.DateTimeFormat('ru', { second: '2-digit' }).format(date);
    return da+'.'+mo+'.'+ye + ' ' + hour + ':' + minute + ':' + second;
}