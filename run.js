const moment = require('moment');

const args = process.argv.slice(2);
const m = moment.unix(args[0]).locale(args[1]);

if (!m.isValid()) {
    console.log("Invalid moment; bad timestamp");
    process.exit();
}

const obj = {
    'formats': [
        m.format('L'),
        m.format('LL'),
        m.format('LT'),
        m.format('LTS'),
        m.format('LLL'),
        m.format('LLLL'),
        m.fromNow(),
    ]
}
console.log(JSON.stringify(obj));
