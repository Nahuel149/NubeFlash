<?php $this->view('frontend/email/_header',array('img' => base_url('assets/public/superflash.png'))); ?>
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
    <tr>
        <td align="center" valign="top">
            <!-- CENTERING TABLE // -->
            <table border="0" cellpadding="0" cellspacing="0" width="500">
                <tr>
                    <td align="center" valign="top">
                     <!-- FLEXIBLE CONTAINER // -->
                     <br>
                        <img src="https://i.ibb.co/YSs3qT9/superflash.png" width="100"/>
                    <!-- // FLEXIBLE CONTAINER -->
                    </td>
                </tr>
            </table>
            <!-- // CENTERING TABLE -->
        </td>
    </tr>
    <!-- // MODULE ROW -->
    <br>
    <!-- MODULE ROW // -->
    <tr>
        <td align="center" valign="top">
            <!-- CENTERING TABLE // -->
            <table border="0" cellpadding="0" cellspacing="0" width="500">
                <tr>
                    <td align="center" valign="top">
                        <!-- FLEXIBLE CONTAINER // -->
                        <table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
                            <tr>
                                <td style="padding-top:0;" align="center" valign="top" width="500" class="flexibleContainerCell">
                                    <!-- CONTENT TABLE // -->
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="flexibleContainer">
                                        <tr>
                                            <td>
                                                <div style="text-align:center;font-family:Helvetica,Arial,sans-serif;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:135%;">
                                                    <strong><h4>¡TU REGISTRO FUE REALIZADO CON ÉXITO!</h4></strong><br>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="flexibleContainer">
                                        <tr>
                                            <td align="center" valign="top" class="textContent">
                                                <div style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:135%;">
                                                    <span>Revisa tu correo electrónico para confirmar el registro</span><br>
                                                    <span>¡No te olvides de chequear el SPAM!</span><br>
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