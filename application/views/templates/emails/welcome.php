<h2>Welcome to NubeFlash!</h2>

<p>Dear <?php echo $name; ?>,</p>

<p>Thank you for registering with NubeFlash. Your account has been successfully created.</p>

<h3>Your Account Details:</h3>
<ul>
    <li><strong>Email:</strong> <?php echo $email; ?></li>
    <li><strong>Username:</strong> <?php echo $username; ?></li>
</ul>

<?php if(isset($tokens) && !empty($tokens)): ?>
<h3>Your API Tokens:</h3>
<ul>
    <?php foreach($tokens as $token): ?>
        <li>
            <strong><?php echo ucfirst($token['type']); ?> Token:</strong><br>
            <code><?php echo $token['token']; ?></code>
        </li>
    <?php endforeach; ?>
</ul>

<p><strong>Important:</strong> Please keep these tokens secure and do not share them with anyone.</p>
<?php endif; ?>

<p>You can now log in to your account using your email and password.</p>

<p>
    <a href="<?php echo base_url('login'); ?>" class="btn">Login to Your Account</a>
</p>

<p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

<p>Best regards,<br>The NubeFlash Team</p> 