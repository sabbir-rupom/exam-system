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
    action = $.trim(action);

    if (method == '' || url == '') {
        return false;
    }
    if (method !== 'post') {
        inputHtml += '<input name="_method" type="hidden" value="' + method + '">';
    }

    let orgId = null;
    if ($this.attr('data-org')) {
        orgId = parseInt($this.data('org'));
        inputHtml += '<input type="hidden" name="org_id" value="' + orgId + '">';
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

    preloader(true);

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
function preloader(show = false)
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