@include('template.email.include.header')

<p>Dear {{ isset($fullname) ? $fullname : 'Concern' }},</p>
<p>This is a test email

<br><br>
<small>
Best Regards,<br>
Somriddhi<br>
Email: lms@marketaccesspl.com
</small>

<br><br>
<sub>*** This is an automatically generated email, please do not reply ***</sub>
@include('template.email.include.footer')
