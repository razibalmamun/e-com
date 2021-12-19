export default ({ app, $axios }, inject) => {
    inject('getValidationError', (errors, key) => {
        if (errors == null) {
            return null;
        } else if (errors[key]) {
            return errors[key].join();
        } else {
            return "";
        }
    });
    inject('formatDate', (date, separator = '/') => {
        if (!date) return null
        const [year, month, day] = date.split('-')
        return `${day}${separator}${month}${separator}${year}`
    });
    inject('formatDateTime', (date) => {
        if (!date) return null
        let [onlyDate, onlyTime] = date.split('T');
        if (typeof onlyTime === "undefined") {
            let [onlyDate, onlyTime] = date.split(' ');
            let [year, month, day] = onlyDate.split('-');
            let [onlyHour, onlyMinute] = onlyTime.split(':');
            return `${day}/${month}/${year} ${onlyHour}:${onlyMinute}`
        } else {
            let [year, month, day] = onlyDate.split('-');
            let [onlyHour, onlyMinute] = onlyTime.split(':');
            return `${day}/${month}/${year} ${onlyHour}:${onlyMinute}`
        }
    });
    inject('jsDateTime', () => {
        return new Date().toISOString().slice(0, 19).replace('T', ' ');
    });
    inject('currentDate', () => {
        return new Date().getFullYear() + "-" + (new Date().getMonth() + 1) + "-" + new Date().getDate();
    });
}