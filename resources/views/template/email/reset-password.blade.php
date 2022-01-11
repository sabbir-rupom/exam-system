@include('template.email.include.header')

<p>Dear User,</p>
<p>
    Please click on the following link to proceed your password reset form:
</p>
<br>
<div style="text-align: center">
    <a class="action-button" href="{{ $url }}">Reset Password</a>
</div>
<br><br>

<small>
    Best Regards,<br>
    Somriddhi<br>
    Email: lms@marketaccesspl.com
</small>

<br><br>
<sub>*** This is an automatically generated email, please do not reply ***</sub>
@include('template.email.include.footer')