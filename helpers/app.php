<?php

use App\Library\Resource\FileStorage;
use App\Models\Question\Question;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

if (!function_exists('get_subdomain')) {

    function get_subdomain(string $host)
    {
        $hostParts = explode('.', $host);

        if (count($hostParts) === 3) {
            return $hostParts[0];
        } elseif (count($hostParts) > 3) {
            return 'redirect-app';
        } else {
            return '';
        }
    }
}

if (!function_exists('app_url')) {

    function app_url(string $path = '')
    {
        $url = get_protocol() . 'app.' . config('app.short_url');

        return $url . (!empty($path) ? "/$path" : '/');
    }
}

if (!function_exists('get_protocol')) {

    function get_protocol()
    {
        return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)) ? "https://" : "http://";
    }
}

if (!function_exists('get_remote_host')) {

    function get_remote_host()
    {
        return isset($_SERVER['HTTP_ORIGIN']) && !empty($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
    }
}

if (!function_exists('image_file_resolver')) {

    function image_file_resolver($file)
    {
        return is_array(getimagesize($file));
    }
}

if (!function_exists('has_role')) {
    /**
     * Check user role with Laratrust
     *
     * @param User $user
     * @param string $role
     * @return boolean
     */
    function has_role(User $user = null, string $role)
    {
        return $user && $user->hasRole($role);
    }
}

if (!function_exists('array_unique_multidimensional')) {
    /**
     * Remove duplicate array from multidimensional array list
     *
     * @param array $input
     * @return array
     */
    function array_unique_multidimensional(array $input)
    {
        $serialized = array_map('serialize', $input);
        $unique = array_unique($serialized);
        return array_intersect_key($input, $unique);
    }
}

if (!function_exists('storage_url')) {
    /**
     * Return public url for storage file
     *
     * @param string $fileName
     * @return string
     */
    function storage_url(string $fileName): string
    {
        return FileStorage::url($fileName);
    }
}

if (!function_exists('star_rating')) {
    /**
     * Create rating with star icons
     *
     * @param float $rating
     * @return string
     */
    function star_rating(float $rating, string $class = ''): string
    {
        $starRating = '<div class="' . $class . '">';
        $maxPoint = 5;
        if ($rating > $maxPoint) {
            $rating = $maxPoint;
        }

        $rateAbs = floor($rating);
        for ($i = 0; $i < $rateAbs; $i++) {
            if ($rating < 1) {
                break;
            }
            $starRating .= '<span class="mdi mdi-star text-warning"></span>';
            $rating--;
            $maxPoint--;
        }

        $rateAbs = floor($rating);

        if ($rating > ($rateAbs + 0.2)) {
            $starRating .= '<div class="rating-symbol" style="display: inline-block; position: relative;"><div class="rating-symbol-background mdi mdi-star-outline text-muted" style="visibility: visible;"></div><div class="rating-symbol-foreground" style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px; width: 50%;"><span class="mdi mdi-star text-warning"></span></div></div>';
            $maxPoint--;
        }

        for ($i = 0; $i < $maxPoint; $i++) {
            $starRating .= '<span class="mdi mdi-star-outline"></span>';
        }

        $starRating .= '</div>';

        return $starRating;
    }
}

if (!function_exists('maintenance')) {
    /**
     * Show maintenance page
     *
     * @return void
     */
    function maintenance()
    {
        dd('page under maintenance');
    }
}

if (!function_exists('encode_short')) {
    /**
     * Show maintenance page
     *
     * @param string|int $id
     * @return string
     */
    function encode_short($id)
    {
        $array = str_split($id);
        $encoded = '';
        foreach ($array as $val) {
            // 65 = A
            // 65 + 1 = B
            $encoded .= chr($val + 97);
        }

        return $encoded . '-' . Str::random(5);
    }
}

if (!function_exists('decode_short')) {
    /**
     * decode the short encoded string
     *
     * @param string|int $id
     * @return string
     */
    function decode_short($encoded)
    {
        if (strpos($encoded, '-') === false) {
            return 0;
        }
        $array = str_split(explode('-', $encoded)[0]);
        $decoded = '';

        foreach ($array as $val) {
            // Convert to ASCII value
            $decoded .= ord($val) - 97;
        }

        return $decoded;
    }
}

if (!function_exists('time_diff_human')) {
    /**
     * Get time difference from now in human readable format
     *
     * @param string|object $dateTime
     * @return string
     */
    function time_diff_human($dateTime)
    {
        if (is_string($dateTime)) {
            return \Carbon\Carbon::parse($dateTime)->diffForHumans();
        } elseif ($dateTime instanceof \Carbon\Carbon) {
            return $dateTime->diffForHumans();
        } else {
            return date('Y/m/d H:i:s');
        }

    }
}

if (!function_exists('format_ymd_from_days')) {
    /**
     * Format to years, month and days from day number
     *
     * @param int $days
     * @return string
     */
    function format_ymd_from_days(int $days)
    {
        if ($days <= 0) {
            return '0 days';
        }
        $years = floor($days / 365);
        if ($years > 0) {
            $days = $days - $years * 365;
        }
        $months = floor($days / 30);
        if ($months > 0) {
            $days = $days - $months * 30;
        }

        $cHtml = ($years > 0) ? "$years year " : '';
        $cHtml .= ($months > 0) ? "$months month " : '';
        $cHtml .= "$days days";

        return $cHtml;
    }
}

if (!function_exists('convert_to_jstime')) {
    /**
     * Convert timestring into
     *
     * @return string
     */
    function convert_to_jstime($dateTime)
    {
        if (is_string($dateTime)) {
            return \Carbon\Carbon::parse($dateTime)->format('Y/m/d H:i:s');
        } elseif ($dateTime instanceof \Carbon\Carbon) {
            return $dateTime->format('Y/m/d H:i:s');
        } elseif (empty($dateTime)) {
            return 'n/a';
        } else {
            return date('Y/m/d H:i:s');
        }

    }
}

if (!function_exists('same_array')) {
    /**
     * Check 2 arrays has same values or not
     *
     * @return bool
     */
    function same_array(array $a, array $b)
    {
        // $a = array_values($a);
        // $b = array_values($b);
        return count($a) == count($b) && !array_diff($a, $b);

    }
}

if (!function_exists('few_words')) {
    /**
     * Get 1st n characters of words
     *
     * @param string $message
     * @param integer $K
     * @return void
     */
    function few_words(string $message, int $K = 20) {

        if ($K < 1) {
            return '';
        }

        if (strlen($message) <= $K) {
            return trim($message);
        }

        if($message[$K] === " ") {
            return trim(substr($message,0,$K));
        }

        while($message[--$K] !== ' ');

        return trim(substr($message,0,$K));
    }
}

if (!function_exists('slug_create')) {
    /**
     * Get code / slug from string
     *
     * @param string $string
     * @param integer $K
     * @return void
     */
    function slug_create(string $string) {

        if (strlen($string) > 50) {
            $string = few_words($string, 50);
        }

        $string = preg_replace('/\s+/', ' ', strtolower($string));

        return trim(str_replace(' ', '-', $string));
    }
}

if (!function_exists('question_type_match')) {
    /**
     * Check which type of question
     *
     * @param string $key
     * @param integer $type
     * @return boolean
     */
    function question_type_match(string $key, int $type)
    {
        if ($key === 'single') {
            return (Question::TYPE_SINGLE == $type);
        } elseif ($key === 'multiple') {
            return (Question::TYPE_MULTIPLE == $type);
        } else {
            return false;
        }
    }
}

if (!function_exists('exam_status')) {
    /**
     * Check exam result status and return html string
     *
     * @param integer $status
     * @return string
     */
    function exam_status(int $status): string
    {
        if ($status == Quiz::RESULT_PASS) {
            return '<span class="text-success">Passed</span>';
        } elseif ($status == Quiz::RESULT_FAIL) {
            return '<span class="text-danger">Failed</span>';
        } else {
            return '<span class="text-secondary">Pending</span>';
        }
    }
}

// if (!function_exists('badge_status')) {
//     /**
//      * Check exam result status and return html string
//      *
//      * @param integer|string $status
//      * @return string
//      */
//     function badge_status($status): string
//     {
//         if (is_numeric($status)) {
//             $status = intval($status);
//         }

//         if ($status === Quiz::RESULT_PASS) {
//             return '<span class="badge-status bg-success">Passed</span>';
//         } elseif ($status === Quiz::RESULT_FAIL || $status === 'fail') {
//             return '<span class="badge-status bg-danger">Failed</span>';
//         } elseif ($status === 'expire') {
//             return '<span class="badge-status bg-danger">Expired</span>';
//         } elseif ($status === 'complete') {
//             return '<span class="badge-status bg-success">Completed</span>';
//         } elseif ($status === 'in-progress') {
//             return '<span class="badge-status bg-theme-orange">In Progress</span>';
//         } elseif ($status === 'no-assign') {
//             return '<span class="badge-status bg-danger">Not Assigned</span>';
//         } elseif ($status === 'no-enroll') {
//             return '<span class="badge-status bg-warning">Not Enrolled</span>';
//         } elseif ($status === 'active') {
//             return '<span class="badge-status bg-success">Active</span>';
//         } elseif ($status === 'in-active') {
//             return '<span class="badge-status bg-danger">In Active</span>';
//         } else {
//             return '<span class="badge-status bg-warning">Pending</span>';
//         }
//     }
// }

if (!function_exists('render_quiz_option')) {
    /**
     * Generate html code for question option based on question type
     *
     * @return string
     */
    function render_quiz_option(int $type, $options)
    {
        if (empty($options)) {
            return '';
        }
        $viewHtml = '';
        switch ($type) {
            case Question::TYPE_SINGLE:
                $viewHtml = view('raw.quiz.option-single')->with('options', $options)->render();
                break;
            case Question::TYPE_MULTIPLE:
                $viewHtml = view('raw.quiz.option-multiple')->with('options', $options)->render();
                break;
                // case Question::TYPE_MAPPING:
                //     $suffle1 = $suffle2 = $options;
                //     shuffle($suffle1);
                //     shuffle($suffle2);
                //     $viewHtml = view('raw.quiz.option-mapping')->with([
                //         'shuffle1' => $suffle1,
                //         'shuffle2' => $suffle1,
                //     ])->render();
                //     break;
        }

        return $viewHtml;

    }
}

if (!function_exists('abort_to')) {
    /**
     * Force redircet
     *
     * @param string $to
     * @return void
     */
    function abort_to($to = '/')
    {
        throw new HttpResponseException(redirect($to));
    }
}

if (!function_exists('check_expired')) {
    /**
     * Force redircet
     *
     * @param string|null $date
     * @return void
     */
    function check_expired($date = null)
    {
        if (empty($date)) {
            return false;
        }
        $otherDate = Carbon::parse($date);
        $nowDate = Carbon::now();

        return (!$otherDate->isToday() && $nowDate->gt($otherDate));
    }
}

if (!function_exists('upload_path')) {
    /**
     * Get default file upload path
     *
     * @return string
     */
    function upload_path(string $path = '')
    {
        return FileStorage::getUploadPath($path);
    }
}

if (!function_exists('upload_url')) {
    /**
     * Get default file upload path
     *
     * @param string $path
     * @return string
     */
    function upload_url(string $path = '')
    {
        return FileStorage::getUploadUrl($path);
    }
}

if (!function_exists('excel_file_type')) {
    /**
     * Check excel file type according to Maatweb Excel
     *
     * @param string $mime
     * @return string
     */
    function excel_file_type(string $mime)
    {
        $csvTypes = array(
            'text/csv',
            'application/csv',
            'text/comma-separated-values',
            'application/octet-stream',
        );
        $xlsType = array(
            'application/excel',
            'application/vnd.ms-excel',
            'application/vnd.msexcel',
        );
        return in_array($mime, $csvTypes) ? \Maatwebsite\Excel\Excel::TSV
        : (
            in_array($mime, $xlsType) ? \Maatwebsite\Excel\Excel::XLS : \Maatwebsite\Excel\Excel::XLSX
        );
    }
}

if (!function_exists('truncate_words')) {
    /**
     * Get 1st few words from long string
     *
     * @param string $string
     * @param integer $maxlength
     * @param string $extension
     * @return string
     */
    function truncate_words(string $string, int $maxlength = 10, string $extension = '...'): string
    {

        // Set the replacement for the "string break" in the wordwrap function
        $cutmarker = "**cut**";

        // Checking if the given string is longer than $maxlength
        if (!empty($string) && strlen($string) > $maxlength) {

            // Using wordwrap() to set the cutmarker
            // NOTE: wordwrap (PHP 4 >= 4.0.2, PHP 5)
            $string = wordwrap($string, $maxlength, $cutmarker);

            // Exploding the string at the cutmarker, set by wordwrap()
            $string = explode($cutmarker, $string);

            // Adding $extension to the first value of the array $string, returned by explode()
            $string = $string[0] . $extension;
        }

        // returning $string
        return $string;

    }
}

if (!function_exists('get_exam_link')) {
    /**
     * Generate quiz exam link
     *
     * @return string
     */
    function get_exam_link(Model $exam): string
    {

        if (empty($exam->id)) {
            return '';
        }

        return url('exam/start?code=' . encode_short($exam->id) . '$' . encode_short($exam->owner_id));

    }
}

if (!function_exists('session_profile')) {
    /**
     * Get user profile data from session | default: ''
     *
     * @return string
     */
    function session_profile($key = ''): string
    {

        if (session()->has('profile')) {
            $profile = session('profile');

            if (empty($key)) {
                return $profile;
            }

            if (is_array($profile)) {
                if (isset($profile[$key])) {
                    return $profile[$key];
                } elseif ($key == 'fullname') {
                    return $profile['firstname'] . (isset($profile['lastname']) && !empty($profile['lastname']) ? ' ' . $profile['lastname'] : '');
                }
            }
        }

        return '';

    }
}
