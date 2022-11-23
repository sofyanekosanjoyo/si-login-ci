<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $judul; ?></h1>

    <div class="row">
        <div class="col-lg-6">

            <?= $this->session->flashdata('message'); ?>

            <form action="<?= base_url('user/ubahpassword'); ?>" method="post">
                <div class="form-group row">
                    <label class="col-sm-4" for="password_saat_ini">Password Saat Ini</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password_saat_ini" name="password_saat_ini">
                        <?= form_error('password_saat_ini', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="password_baru1">Password Baru</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password_baru1" name="password_baru1">
                        <?= form_error('password_baru1', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="password_baru2">Ulangi Password Baru</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password_baru2" name="password_baru2">
                        <?= form_error('password_baru2', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->