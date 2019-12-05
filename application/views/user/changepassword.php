
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <div class="row">

          	<div class="col-lg-6">
	          	<?= $this->session->flashdata('message'); ?>
          		<form action="<?= base_url('user/changePassword'); ?>" method="POST">
          			
          			<div class="form-group">
						<label for="current_password">Current Password</label>
						<input type="password" class="form-control" id="current_password" name="current_password">
						<?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>

					<div class="form-group">
						<label for="new_password">New Password</label>
						<input type="password" class="form-control" id="new_password" name="new_password">
						<?= form_error('new_password', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>

					<div class="form-group">
						<label for="repeat_password">Repeat Password</label>
						<input type="password" class="form-control" id="repeat_password" name="repeat_password">
						<?= form_error('repeat_password', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>

					<div class="form-group">
						<button class="btn btn-primary" type="submit">Change Password</button>
					</div>

          		</form>
          	</div>
          </div>

        </div>
        <!-- /.container-fluid -->