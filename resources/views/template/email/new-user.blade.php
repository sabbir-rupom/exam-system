@include('template.email.include.header')

<p>Dear {{ isset($fullname) ? $fullname : 'Concern' }},</p>
<p>Welcome to Somriddhi.</p>
<p>
    To complete your registration, please activate your account with the following activation link:
</p>
<br>
<div style="text-align: center">
    <a class="action-button" href="{{ $url }}">Activate Account</a>
</div>
<br><br>
<p>
    Your Username <span class="special">{{ $username }}</span>
</p>
@isset($password)
<p>
    Your Password <span class="special">{{ $password }}</span>
</p>
@endisset
<p>
    We hope you will enjoy your experience with us.
    <br>
    If you have any queries, please email us at your convenience lms@marketaccesspl.com
</p>

<small>
    Best Regards,<br>
    Somriddhi<br>
    Email: lms@marketaccesspl.com
</small>

<br><br>
<sub>*** This is an automatically generated email, please do not reply ***</sub>
@include('template.email.include.footer')