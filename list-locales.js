const moment = require('moment/min/moment-with-locales');

const list = moment.locales();

const obj = {
    list
}
console.log(JSON.stringify(obj));
