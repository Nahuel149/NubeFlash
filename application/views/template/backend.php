<?php if ($this->ion_auth->logged_in()){ ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
    <title><?php echo $title; ?></title>
    <?php 
        $this->load->view('template/backend/header');
        $this->load->view('template/backend/css');
        $this->load->view('template/backend/js');
        $user_row = $this->ion_auth->user()->row();
    ?>
    <!-- Custom Menu Styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/css/menu.css') ?>">
    <!-- Responsive Tables Styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/css/responsive-tables.css') ?>">
    <!-- Dropdown Menu Fix Styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/backend/css/dropdown-fix.css') ?>">
  </head>
  <body style="padding: 0px;">
  <div class="all-wrapper menu-top">
      <div class="layout-w">

        <?php include("backend/nav.php"); ?>

        <div class="content-w">
          
          <?php include("backend/header_container.php"); ?>
          <div class="content-i" style="min-height: 700px;">
            <div class="content-box">
              <div class="element-wrapper">
                
                <?php include("backend/breadcrumb.php"); ?>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                        <?php echo $contenido_main; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php include("backend/footer.php"); ?>

        </div>
    </div>
    <?php $this->load->view('template/backend/modal'); ?>    
    <!-- Custom Menu Scripts -->
    <script src="<?php echo base_url('assets/backend/js/menu.js') ?>"></script>
    <!-- Responsive Tables Scripts -->
    <script src="<?php echo base_url('assets/backend/js/responsive-tables.js') ?>"></script>
    <!-- Dropdown Menu Fix Scripts -->
    <script src="<?php echo base_url('assets/backend/js/dropdown-fix.js') ?>"></script>
    <!-- Menu Links Fix Script -->
    <script src="<?php echo base_url('assets/backend/js/menu-links-fix.js') ?>"></script>
  </body>
</html>
<?php } ?>