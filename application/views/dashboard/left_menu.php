<!-- start:Left Menu -->
            <div id="left-menu">
              <div class="sub-left-menu scroll">
                <ul class="nav nav-list">
                  
                    <li class="time">
                      <h1 class="animated fadeInLeft">21:00</h1>
                      <p class="animated fadeInRight">Sat,October 1st 2029</p>
                    </li>

                    
                    <li class="ripple">
                      <a href="<?php echo base_url(); ?>index.php/dashboard"><span class="fa-home fa"></span> Dashboard 
                        <span class="fa-angle-right fa right-arrow text-right"></span>
                      </a>
                    </li>
                    <li class="ripple">
                      <a href="<?php echo base_url(); ?>index.php/penjualan">
                        <span class="icons icon-basket"></span> Penjualan
                        <span class="fa-angle-right fa right-arrow text-right"></span>
                      </a>
                    </li>

                     <li class="ripple">
                      <a class="tree-toggle nav-header">
                        <span class="fa fa-cart-arrow-down"></span> Pembelian
                        <span class="fa-angle-right fa right-arrow text-right"></span>
                      </a>
                      <ul class="nav nav-list tree">
                      <li><a href="<?php echo base_url(); ?>index.php/pembelian">Update Pembelian</a></li>
                      <li><a href="<?php echo base_url(); ?>index.php/pembelianbaru">Register Barang Baru </a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/pembelianlain">Pembelian Lain-Lain</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/daftarpembelian">Daftar Pembelian</a></li>
                      </ul>
                    </li>
                    <li class="ripple">
                      <a class="tree-toggle nav-header">
                        <span class="fa-area-chart fa"></span> Laporan
                        <span class="fa-angle-right fa right-arrow text-right"></span>
                      </a>

                      <ul class="nav nav-list tree">
                        <li><a href="<?php echo base_url(); ?>index.php/laporan">Penjualan & Pembelian</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/laporan/delivery">Delivery</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/laporan/cetakNota">Cetak Nota</a></li>
                         <li><a href="<?php echo base_url(); ?>index.php/laporan/neraca">Neraca</a></li>


                      </ul>
                    </li>

                    <li class="ripple">
                     <a class="tree-toggle nav-header">
                        <span class="fa-area-chart fa"></span> Data Toko
                        <span class="fa-angle-right fa right-arrow text-right"></span>
                      </a>
                    <ul class="nav nav-list tree">
                    <li class="ripple"><a href="<?php echo base_url(); ?>index.php/petugasdelivery"><span class="fa fa-calendar-o"></span>Data Petugas Delivery</a></li>
                    <li class="ripple"><a href="<?php echo base_url(); ?>index.php/pelanggan"><span class="fa fa-calendar-o"></span>Data Pelanggan</a></li>
                    <li class="ripple"><a href="<?php echo base_url(); ?>index.php/suplier"><span class="fa fa-calendar-o"></span>Data Suplier</a></li>
                  </ul>
                  </li>

            <?php if($_SESSION['acces'] == 2){ ?>
                    <li class="ripple">
                     <a class="tree-toggle nav-header">
                        <span class="fa-area-chart fa"></span> Administrator
                        <span class="fa-angle-right fa right-arrow text-right"></span>
                      </a>
                       <ul class="nav nav-list tree">
                  <li class="ripple"><a href="<?php echo base_url(); ?>index.php/petugasdelivery"><span class="fa fa-calendar-o"></span>Data Pegawai</a></li>
                   <li class="ripple"><a href="<?php echo base_url(); ?>index.php/laporan/gaji">Gaji Pegawai</a></li>
                  <li class="ripple"><a href="<?php echo base_url(); ?>index.php/absensi"><span class="fa fa-calendar-o"></span>Absensi Pegawai</a></li>

                  <li class="ripple"><a href="<?php echo base_url(); ?>index.php/hapuspenjualan"><span class="fa fa-calendar-o"></span>Hapus Nota Jual</a></li>
                  <li class="ripple"><a href="<?php echo base_url(); ?>index.php/hapuspembelian"><span class="fa fa-calendar-o"></span>Hapus Nota Beli</a></li>
                    </ul>
                    <ul class="nav nav-list tree">
                    
                  </ul>
                  </li>
                  <?php } ?>

                </div>
            </div>
          <!-- end: Left Menu -->