<?php $this->view('frontend/email/_header', ['title' => isset($dato['title']) ? $dato['title'] : 'Actualización de Pedido']); ?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" valign="top">
            <table border="0" cellpadding="20" cellspacing="0" width="600" id="emailContainer">
                <tr>
                    <td align="left" valign="top" class="textContent">
                        <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:135%;">
                            <h3 style="color:#EB7035; font-size:18px; margin-bottom:10px;">Hola <?php echo htmlspecialchars(isset($dato['customer_name']) ? $dato['customer_name'] : 'Cliente'); ?>,</h3>
                            <p style="margin-bottom:10px;">
                                Te informamos que el estado de tu pedido N° <strong><?php echo htmlspecialchars(isset($dato['order_number']) ? $dato['order_number'] : 'N/A'); ?></strong> ha sido actualizado a:
                            </p>
                            <p style="font-size:17px; color:#EB7035; margin-bottom:20px;">
                                <strong><?php echo htmlspecialchars(isset($dato['new_status']) ? $dato['new_status'] : 'Desconocido'); ?></strong>
                            </p>
                            <?php if (isset($dato['tracking_link']) && !empty($dato['tracking_link']) && $dato['tracking_link'] !== base_url()): ?>
                                <p style="margin-bottom:20px;">
                                    Puedes seguir el estado de tu envío aquí:
                                    <a href="<?php echo htmlspecialchars($dato['tracking_link']); ?>" target="_blank" style="color:#EB7035;text-decoration:none;font-weight:bold;">Seguir mi pedido</a>
                                </p>
                            <?php endif; ?>
                            <p style="margin-bottom:10px;">
                                Gracias por confiar en <?php echo htmlspecialchars(isset($dato['store_name']) ? $dato['store_name'] : 'nosotros'); ?>.
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php $this->view('frontend/email/_footer'); ?> 