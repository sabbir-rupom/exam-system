/**
 * Create and submit form dynamically on request
 *
 * @param {object} $this jQuery dom-element object
 * @param {string} action Form action category
 * @param {string} method Form submission method ( default: POST )
 * @returns
 */
function formSubmitOnPage($this, action, method = 'post')
{
    let url = $this.data('route'),
        inputHtml = '<input type="hidden" name="_token" value="' + $('meta[name=csrf-token]').attr('content') + '">';

    method = method.toLowerCase();
    action = action.trim();

    if (method == '' || url == '') {
        return false;
    }
    if (method !== 'post') {
        inputHtml += '<input name="_method" type="hidden" value="' + method + '">';
    }

    switch (action) {
        case 'course-progress':
            let progressVal = parseInt($this.data('progress')),
                courseOwner = parseInt($this.data('owner')),
                courseId = parseInt($this.data('course'));
            inputHtml += '<input type="hidden" name="course_progress" value="' + progressVal + '">'
                + '<input type="hidden" name="course_id" value="' + courseId + '">'
                + '<input type="hidden" name="owner" value="' + courseOwner + '">'
                + '<input type="hidden" name="course_id" value="' + courseId + '">';
            break;

        default:
            break;
    }

    pageLoader(true);

    $('<form>', {
        "id": "form--dynamic",
        "html": inputHtml,
        "action": url,
        "method": method
    }).appendTo(document.body).trigger('submit');
}

/**
 * Show / Hide page pre-loader
 *
 * @param bool show
 */
function pageLoader(show = false)
{
    if (show) {
        $('#preloader').fadeIn('slow');
    } else {
        $('#preloader').fadeOut('slow');
    }
}

/**
 * Open / Close fullscreen mode
 *
 * @param {dom} elem
 */
function openFullscreen(elem)
{
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) { /* Safari */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { /* IE11 */
        elem.msRequestFullscreen();
    }
}
function closeFullscreen()
{
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.webkitExitFullscreen) { /* Safari */
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) { /* IE11 */
        document.msExitFullscreen();
    }
}

/**
 * Process & handle fetch call request asynchronously
 *
 * @param {string} url
 * @param {array|object} data
 * @param {string} method
 * @param {array|object} headers
 * @returns {object} Fetch object
 */
async function fetchCall(url, data = [], method = 'POST', headers, callback = '')
{
    let ajaxUrl = (url.indexOf("http://") == 0 || url.indexOf("https://") == 0) ? url : $('#base_url').val() + url;

    var fetchResult = null,
        requestHeaders = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'url': ajaxUrl,
            "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
        };

    if (headers) {
        for (var key in headers) {
            if (key === 'token') {
                requestHeaders['X-CSRF-Token'] = headers[key];
            } else {
                requestHeaders[key] = headers[key];
            }
        }
    }

    pageLoader();

    var sendObj = {
        method: method,
        headers: requestHeaders,
        credentials: "same-origin",
    };

    if (method.toUpperCase() !== 'GET') {
        sendObj.body = JSON.stringify(data);
    }

    try {
        fetchResult = await fetch(ajaxUrl, sendObj);

        const result = await fetchResult.json();

        pageLoader(false);

        if (fetchResult.ok) {
            if (result['refresh-csrf']) {
                $('meta[name="csrf-token"]').attr('content', result['refresh-csrf'])
            }
            if (callback != '') {
                (new Function('return ' + callback)())();
                return true;
            } else {
                return result;
            }
        } else {
            const responseError = {
                type: 'Error',
                message: result.message.replace(/\n/g, ' ') || 'Something went wrong',
                data: result.data || '',
                code: result.code || '',
            };
            const error = new Error();
            error.info = responseError;
            return error;
        }
    } catch (err) {
        pageLoader(false);

        console.log(err.message);

        const error = new Error('Something went wrong');
        return error;
    }
}

/**
 * Sweet alert confirmation dialogue handle promise async
 *
 * @param {object} obj Dom element
 * @returns
 */
async function handleConfirmation(obj)
{
    return new Promise(resolve =>
    {
        let title = text = confirmText = '';

        if (obj instanceof HTMLElement) {
            title = $(obj).data('title'),
                text = $(obj).data('text'),
                confirmText = $(obj).data('confirm_text');
        }

        Swal.fire({
            title: title ? title : 'Are you sure?',
            text: text ? text : "Your data will be lost!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmText ? confirmText : 'Yes, Proceed'
        }).then((result) =>
        {
            if (result.value) {
                resolve(true);
            } else {
                resolve(false);
            }
        });
    });
}

/**
 * Sweet confirmation before form submit
 *
 * @param {object} obj
 * @returns bool
 */
function sweetConfirmSubmit(obj, form = true)
{
    let confirm = handleConfirmation(obj);

    if (confirm instanceof Error) {
        toastr.error(confirm.message, 'Error!');
    } else {
        confirm.then(value =>
        {
            if (value) {
                if (form) {
                    $(obj).closest('form').trigger('submit');
                }
            }
        });
    }
}

/**
 * Convert javascript date object to Datetime string
 *
 * @param {object} date
 * @returns Datetime string (Y-m-d h:i:s)
 */
function convertUTCtoDatetime(date)
{
    if (date instanceof Date) {
        return date.toISOString().
            replace(/T/, ' ').      // replace T with a space
            replace(/\..+/, '');
    } else {
        return new Date().toISOString().
            replace(/T/, ' ').
            replace(/\..+/, '');
    }
}

/**
 * Convert php datestring to local time
 *
 * @param {string} datetime
 * @param {bool} time
 * @returns Datetime string (Y-m-d h:i:s)
 */
function convertUTCtoLocal(datetime, time = false)
{
    var localDate = new Date(datetime);
    var offset = localDate.getTimezoneOffset() / 60;
    var hours = localDate.getHours();

    localDate.setHours(hours - offset);

    var localTime = localDate.toLocaleDateString("en-US", { day: 'numeric' }) + " " + localDate.toLocaleDateString("en-US", { month: 'short' }) + ", " + localDate.getFullYear();

    if (time) {
        localTime += ' at ' + formatAMPM(localDate);
    }
    return localTime;
}
/**
 * Convert php datestring to local time and get local time difference
 *
 * @param {string} datetime
 * @returns string Time difference (months / hours / minutes)
 */
function convertUTCtoLocalAway(datetime)
{
    var datePrevious = new Date(datetime);
    var localOffset = datePrevious.getTimezoneOffset() / 60;
    var localHours = datePrevious.getHours();

    datePrevious.setHours(localHours - localOffset);

    var dateNow = new Date();

    var seconds = Math.abs(Math.floor((datePrevious - (dateNow)) / 1000));
    var minutes = Math.floor(seconds / 60);

    if (minutes < 60) {
        if (minutes < 2) {
            return 'few seconds ago';
        } else {
            return minutes + ' minutes ago';
        }
    }

    var hours = Math.floor(minutes / 60);
    if (hours < 24) {
        if (hours > 1) {
            return hours + ' hours ago';
        } else {
            return 'an hour ago';
        }
    }

    var days = Math.floor(hours / 24);
    if (days < 31) {
        if (days > 1) {
            return days + ' days ago';
        } else {
            return '1 day ago';
        }
    }

    var months = Math.floor(days / 30);
    if (months < 12) {
        if (months > 1) {
            return months + ' days ago';
        } else {
            return '1 month ago';
        }
    } else {
        return 'an year ago';
    }
}

/**
 * Convert javascript date object to local Hours:Minutes Merideum
 *
 * @param {object} date
 * @returns
 */
function formatAMPM(date)
{
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

/**
 * Concert formdata object to array object
 *
 * @param {*} formData
 * @returns
 */
function formDataToArray(formData)
{
    let array = {};
    formData.forEach((value, key) =>
    {
        key = key.replace('[]', '');
        // Reflect.has in favor of: object.hasOwnProperty(key)
        if (!Reflect.has(array, key)) {
            array[key] = value;
            return;
        }
        if (!Array.isArray(array[key])) {
            array[key] = [array[key]];
        }
        array[key].push(value);
    });

    return array;
}
