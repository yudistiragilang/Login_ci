
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


          <div class="row">
          	<div class="col-lg-6 mx-auto">

          		<?= $this->session->flashdata('message'); ?>
          		<?= form_error('menu', '<div class="alert alert-danger" role="alert">','</div>'); ?>
          		<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add New Menu</a>

          		<table class="table table-hover table-bordered">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Menu</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $urut = 1; ?>
				  	<?php foreach($menu as $m) : ?>
				    <tr>
				      <th scope="row"><?= $urut; ?></th>
				      <td><?= $m['menu'] ?></td>
				      <td>
				      	<a href="<?= base_url('menu/editmenu')?>" class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Menu"><i class="fas fa-edit"></i></a>
				      	<a href="<?= base_url('menu/deleteMenu/') . $m['id']; ?>" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Delete Menu"><i class="fas fa-trash"></i></a>
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
		<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add New Menu</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <form class="form-group" action="<?= base_url('menu'); ?>" method="POST">
			      <div class="modal-body">
					  <div class="form-group">
					    <label for="menu">Menu</label>
					    <input type="text" class="form-control" id="menu" name="menu" value="<?= set_value('menu'); ?>" placeholder="Input new menu">
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