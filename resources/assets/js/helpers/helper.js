/**
 * toastPosition other possible values include:
 * > bottom-right, bottom-left, bottom-center, top-right, top-left, top-center
 * > mid-center,
 * can also accept an object { top: '-', bottom: '-', left: '-', right: '-' } 
 */
const toastPosition = {
    right: 4,
    top: 64
};

export function getYoutubeId(url) {
    if(url.length == 11 && !isValidURL(url)) {
        return url;
    }
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    return (match&&match[7].length==11)? match[7] : false;
}

export function scrollToTop() {
    $("html, body").animate({
        scrollTop: 0
    }, 600);
}

export function isValidURL(str) {
    var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
    if(!regex .test(str)) {
        return false;
    } else {
        return true;
    }
}

export function showSuccessMsg(msg, headingTxt, timeout, position) {
    if (typeof(timeout) == 'undefined') {
        timeout = 6000;
    }

    $.toast({
        heading: typeof (headingTxt) != 'undefined' ? headingTxt : 'Success',
        text: msg,
        position: typeof (positioln) != 'undefined'? position : toastPosition,
        bgColor: '#48d841',
        icon: 'success',
        hideAfter: timeout
    });
}

export function showErrorMsg(msg, headingTxt, timeout, position) {
    if (typeof(timeout) == 'undefined') {
        timeout = 6000;
    }

    $.toast({
        heading: typeof (headingTxt) != 'undefined' ? headingTxt : 'Error',
        text: msg,
        position: typeof (positioln) != 'undefined'? position : toastPosition,
        bgColor: '#ff3636cc',
        icon: 'error',
        hideAfter: timeout
    });
}

export function showInfoMsg(msg, headingTxt, timeout, position) {
    if (typeof(timeout) == 'undefined') {
        timeout = 6000;
    }

    $.toast({
        heading: typeof (headingTxt) != 'undefined' ? headingTxt : 'Information',
        text: msg,
        position: typeof (positioln) != 'undefined'? position : toastPosition,
        bgColor: '#56b9ff',
        icon: 'info',
        hideAfter: timeout
    });
}

export function showWarningMsg(msg, headingTxt, timeout, position) {
    if (typeof(timeout) == 'undefined') {
        timeout = 6000;
    }

    $.toast({
        heading: typeof (headingTxt) != 'undefined' ? headingTxt : 'Success',
        text: msg,
        position: typeof (positioln) != 'undefined'? position : toastPosition,
        bgColor: '#ffc15e',
        icon: 'warning',
        hideAfter: timeout
    });
}

export function handleErrorResponse(status) {
    switch (status) {
        case 422:
            showErrorMsg("The given data was invalid.");
            break;
        case 401:
        case 419:
            showErrorMsg("Sorry, your session seems to have expired. Please login again.");
            break;
        default:
            showErrorMsg("Something went wrong while processing your request. Please reload and try again.");
            break;
    }
}

export function handleResponse(response) {
    if (response.success) {
        showSuccessMsg(response.message);
    } else {
        showErrorMsg(response.message);
    }
}

/**
 * @param amount - price amount in decimal
 */
export function getPrice(amount) {
    return (amount/100).toFixed(2);
}
