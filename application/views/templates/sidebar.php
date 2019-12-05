    
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3">WPU Admin</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- QUERY MENU -->
      <?php

        $role = $this->session->userdata('role_id');
        $queryMenu = "SELECT
                        menu.id AS id,
                        menu
                      FROM
                        user_menus AS menu
                      JOIN
                        user_access_menus AS access
                      ON
                        menu.id=access.menu_id
                      WHERE
                        access.role_id = $role
                      ORDER BY
                        access.menu_id
                      ASC";

        $menu = $this->db->query($queryMenu)->result_array();

      ?>

      <!-- LOOPING MENU -->
      <?php foreach ($menu as $m) : ?>
        <div class="sidebar-heading">
          <?= $m['menu']; ?>
        </div>

        <!-- SIAPKAN SUB-MENU SESUAI MENU -->
        <?php
          $menuId = $m['id'];
          $querySubMenu = "SELECT
                          *
                        FROM
                          user_sub_menus AS sub
                        JOIN 
                          user_menus AS menu
                        ON
                          sub.menu_id=menu.id
                        WHERE
                          menu.id = $menuId";

          $subMenu = $this->db->query($querySubMenu)->result_array();
        ?>
 
        <?php foreach ($subMenu as $sm) : ?>

          <?php if($title == $sm['title']) : ?>
          <li class="nav-item active">
          <?php else : ?>
          <li class="nav-item">
          <?php endif; ?>

            <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
              <i class="<?= $sm['icon']; ?>"></i>
              <span><?= $sm['title']; ?></span></a>
          </li>
        <?php endforeach; ?>

        <hr class="sidebar-divider mt-3">

      <?php endforeach; ?>

      <!-- Nav Item -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->