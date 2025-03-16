<?php if($this->uri->uri_string != "backend/auth/login") : ?>
  <h6 class="element-header header-breadcrumb">
    <?php if($this->uri->segment(2) == "dashboard"){ ?>
      <a href="<?php echo base_url().'backend/dashboard' ?>"><i class="fa fa-home"></i> Dashboard</a>
    <?php }else{ ?>
      <a href="<?php echo base_url().'backend/dashboard' ?>"><i class="fa fa-home"></i> Dashboard</a>
      <?php 
        $urls = $this->uri->segment_array();
        
        foreach ($urls as $f) {
          $array_breadcrumb = sudaca_url_segmentos(); 
          $url = str_replace(array_keys($array_breadcrumb), array_values($array_breadcrumb), $f);
          
          if ($f != 'backend' && $f != 'ecommerce' && $f != 'cms') {
            ?>
            <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2) ?>"><?php echo ucwords($url) ?></a>
          <?php
          }
        }
      } 
    ?>
  </h6>
<?php endif ?>
