
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


          <div class="row">
          	<div class="col-lg-6">

          		<?= $this->session->flashdata('message'); ?>
          		<h5>Role : <?= $roles['role']; ?></h5>

          		<table class="table table-hover table-bordered">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Menu</th>
				      <th scope="col">Access</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $urut = 1; ?>
				  	<?php foreach($menus as $menu) : ?>
				    <tr>
			 	      <th scope="row"><?= $urut; ?></th>
				      <td><?= $menu['menu'] ?></td>
				      <td>
				      	<div class="form-check">
						  <input class="form-check-input" type="checkbox" <?= check_access($roles['id'], $menu['id'] ); ?> data-role="<?= $roles['id']; ?>" data-menu="<?= $menu['id']; ?>">
						</div>
				      </td>
				    </tr>
				    <?php $urut++; ?>
					<?php endforeach;?>
				  </tbody>
				</table>
          	</div>
          </div>

        </div>
        <!-- /.container-fluid -->