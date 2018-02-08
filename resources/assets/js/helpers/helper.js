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
        timeout = 5000;
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
        timeout = 5000;
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
        timeout = 5000;
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
        timeout = 5000;
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
            showErrorMsg("Something went wrong while processing your request.");
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

export function copyToClipboard(elem) {
    // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
        succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}