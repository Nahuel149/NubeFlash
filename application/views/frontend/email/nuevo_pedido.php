<?php $this->view('frontend/email/_header', array()); ?>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;background-color:rgb(247,190,13);">
                <tr>
                    <td align="center" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                        <tr>
                            <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" valign="top" class="textContent">
                                        <h2 style="text-align:center;font-weight:normal;font-family:Helvetica,Arial,sans-serif;font-size:23px;margin-bottom:0px;margin-top: 0px;color:#fff;line-height:135%;">
                                            <?php echo $dato['title']; ?>
                                        </h2>
                                    </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- // MODULE ROW -->
    <br>
    <!-- MODULE ROW // -->
    <tr>
        <td align="center" valign="top">
            <!-- CENTERING TABLE // -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="center" valign="top">
                        <!-- FLEXIBLE CONTAINER // -->
                        <table border="0" cellpadding="30" cellspacing="0" width="100%" class="flexibleContainer">
                            <tr>
                                <td style="padding-top:0;" align="center" valign="top" width="100%" class="flexibleContainerCell">
                                    <!-- CONTENT TABLE // -->
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" class="flexibleContainer">
                                        <tr>
                                            <td align="left" valign="top" class="textContent">
                                                <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:135%;pointer-events: none;cursor: default;">
                                                    <?php if (!isset($dato['message'])): ?>
                                                        <b>Store: </b><?php echo $dato['store']; ?><br>
                                                        <b>Cliente: </b><?php echo $dato['client']; ?><br>
                                                        <b>Email: </b><?php echo $dato['email']; ?><br>
                                                        <b>Provincia: </b><?php echo $dato['province']; ?><br>
                                                        <b>Ciudad: </b><?php echo $dato['city']; ?><br>
                                                        <b>Código postal: </b><?php echo $dato['postal_code']; ?><br>
                                                        <b>Dirección: </b><?php echo $dato['address']; ?><br>
                                                        <b>Teléfono: </b><?php echo $dato['telephone']; ?><br>
                                                        <b>Volumen: </b><?php echo $dato['volume']; ?> cm3<br>
                                                        <b>Peso: </b><?php echo $dato['weight']; ?> kg<br>
                                                        <b>Precio: </b> $ <?php echo $dato['price']; ?><br>
                                                    <?php else:?>
                                                        <b>Store: </b><?php echo $dato['store']; ?><br>
                                                        <b>Cliente: </b><?php echo $dato['client']; ?><br>
                                                        <b>Email: </b><?php echo $dato['email']; ?><br>
                                                        <b>Provincia: </b><?php echo $dato['province']; ?><br>
                                                        <b>Ciudad: </b><?php echo $dato['city']; ?><br>
                                                        <b>Código postal: </b><?php echo $dato['postal_code']; ?><br>
                                                        <b>Dirección: </b><?php echo $dato['address']; ?><br>
                                                        <b>Teléfono: </b><?php echo $dato['telephone']; ?><br>
                                                        <b>Volumen: </b><?php echo $dato['volume']; ?> cm3<br>
                                                        <b>Peso: </b><?php echo $dato['weight']; ?> kg<br>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // CONTENT TABLE -->
                                </td>
                            </tr>
                        </table>
                        <!-- // FLEXIBLE CONTAINER -->
                    </td>
                </tr>
            </table>
            <!-- // CENTERING TABLE -->
        </td>
    </tr>
<?php $this->view('frontend/email/_footer'); ?>