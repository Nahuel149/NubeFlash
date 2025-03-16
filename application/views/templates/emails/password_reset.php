<h2>Password Reset Request</h2>

<p>Dear <?php echo $name; ?>,</p>

<p>We received a request to reset your password. If you didn't make this request, you can safely ignore this email.</p>

<p>To reset your password, click the button below:</p>

<p>
    <a href="<?php echo $reset_link; ?>" class="btn">Reset Password</a>
</p>

<p>Or copy and paste this URL into your browser:</p>
<p><code><?php echo $reset_link; ?></code></p>

<p>This link will expire in <?php echo $expiry_time; ?> hours.</p>

<p><strong>Important:</strong> If you did not request a password reset, please contact our support team immediately.</p>

<p>Best regards,<br>The NubeFlash Team</p> 