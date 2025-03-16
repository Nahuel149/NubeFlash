<h2>Order Confirmation</h2>

<p>Dear <?php echo $customer_name; ?>,</p>

<p>Thank you for your order. We are pleased to confirm that your order has been received and is being processed.</p>

<h3>Order Details:</h3>
<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 2px solid #ddd;">Order Number</th>
        <td style="text-align: right; padding: 8px; border-bottom: 2px solid #ddd;"><?php echo $order_number; ?></td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Date</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $order_date; ?></td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Status</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $order_status; ?></td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Tracking Number</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $tracking_number; ?></td>
    </tr>
</table>

<h3>Shipping Details:</h3>
<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Recipient</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $shipping_name; ?></td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Address</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $shipping_address; ?></td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">City</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $shipping_city; ?></td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Province</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $shipping_province; ?></td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Postal Code</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $shipping_postal_code; ?></td>
    </tr>
</table>

<h3>Package Details:</h3>
<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Weight</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $weight; ?> kg</td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Volume</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $volume; ?> m³</td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Dimensions</th>
        <td style="text-align: right; padding: 8px; border-bottom: 1px solid #ddd;"><?php echo $length; ?> x <?php echo $width; ?> x <?php echo $height; ?> cm</td>
    </tr>
</table>

<p>
    <a href="<?php echo base_url('tracking/' . $tracking_number); ?>" class="btn">Track Your Package</a>
</p>

<p>If you have any questions about your order, please contact our customer service team.</p>

<p>Thank you for choosing NubeFlash!</p>

<p>Best regards,<br>The NubeFlash Team</p> 