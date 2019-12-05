
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <div class="row">
          	<div class="col-lg">

          		<?= $this->session->flashdata('message'); ?>
          		<?= form_error('menu', '<div class="alert alert-danger" role="alert">','</div>'); ?>
          		<?= form_error('title', '<div class="alert alert-danger" role="alert">','</div>'); ?>
          		<?= form_error('url', '<div class="alert alert-danger" role="alert">','</div>'); ?>
          		<?= form_error('icon', '<div class="alert alert-danger" role="alert">','</div>'); ?>
          		<?= form_error('is_active', '<div class="alert alert-danger" role="alert">','</div>'); ?>
          		<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">Add New Submenu</a>

          		<table class="table table-hover table-bordered">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Parent</th>
				      <th scope="col">Title</th>
				      <th scope="col">Url</th>
				      <th scope="col">Icon</th>
				      <th scope="col">Is Active</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $urut = 1; ?>
				  	<?php foreach($submenu as $sm) : ?>
				    <tr>
				      <th scope="row"><?= $urut; ?></th>
				      <td><?= $sm['menu'] ?></td>
				      <td><?= $sm['title'] ?></td>
				      <td><?= $sm['url'] ?></td>
				      <td><?= $sm['icon'] ?></td>
				      <td><?= ($sm['is_active'] == 1) ? 'active' : 'non active'; ?></td>
				      <td>
				      	<a href="<?= base_url('menu/editmenu')?>" class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Submenu"><i class="fas fa-edit"></i></a>
				      	<a href="<?= base_url('menu/deleteSubMenu/') . $sm['id']; ?>" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Delete Submenu"><i class="fas fa-trash"></i></a>
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

		<!-- Modal -->
		<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add New Submenu</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <form class="form-group" action="<?= base_url('menu/submenu'); ?>" method="POST">
			      <div class="modal-body">
					  <div class="form-group">
					    <select class="form-control" id="menu" name="menu">
					      <option>-- Select Menu --</option>
					      <?php foreach ($menu AS $m) : ?>
					      <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
					  	  <?php endforeach; ?>
					    </select>
					  </div>
					  <div class="form-group">
					    <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title'); ?>" placeholder="Title submenu">
					  </div>
					  <div class="form-group">
					    <input type="text" class="form-control" id="url" name="url" value="<?= set_value('url'); ?>" placeholder="Url submenu">
					  </div>
					  <div class="form-group">
					    <input type="text" class="form-control" id="icon" name="icon" value="<?= set_value('icon'); ?>" placeholder="Icon awesome">
					  </div>
					  <div class="form-group">
					    <select class="form-control" id="is_active" name="is_active">
					      <option>-- Select one --</option>
					      <option value="1">Active</option>
					      <option value="0">Inactive</option>
					    </select>
					  </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary">Add</button>
			      </div>
			  </form>
		    </div>
		  </div>
		</div>