@extends("mails.layouts.overall")
@section("content")
<td align="center" style="padding: 20px;">
    <table class="content" width="600" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse; border: 1px solid #cccccc;">
        <!-- Header -->
        <tr>
            <td class="header" style="background-color: #ffcb28; padding: 40px; text-align: center; color: white; font-size: 24px;">
            Application Successful
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td class="body" style="padding: 40px; text-align: left; font-size: 16px; line-height: 1.6;">
            Dear, {{ $applicant_name }}! <br><br>
            Thank you for submitting your application for the {{ $job_title }} position at Ideas House Marketing Communications Limited. We appreciate your interest in joining our team and the time you have invested in applying.
            <br><br>
                We are currently in the process of reviewing all applications and will be shortlisting candidates whose qualifications and experience best meet the requirements of the role. If your application is shortlisted, we will contact you to schedule an interview within the next [time frame, e.g., two weeks].
            <br><br>
            In the meantime, if you have any questions or need further information, please feel free to reach out to us at [Your Contact Email] or [Your Contact Phone Number].
            </td>
        </tr>

        <!-- Call to action Button -->
        <!-- Footer -->
        <tr>
            <td class="footer" style="background-color: #5f5f62; padding: 40px; text-align: center; color: white; font-size: 14px;">
            Copyright &copy; 2024 | Ideas House Marketing Communications Limited
            </td>
        </tr>
    </table>
</td>
@endsection