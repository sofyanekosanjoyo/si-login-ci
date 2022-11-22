<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $judul; ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?= form_error('menu', '<div class="alert alert-danger" role="alert"> Gagal menambahkan menu baru! </div>'); ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahAksesMenuModal">Tambah Akses Menu</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Akses Menu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($aksesMenu as $am) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $am['level']; ?></td>
                                <td>
                                    <a href="<?= base_url('admin/akses_user/' . $am['id']); ?>" class="badge badge-warning">akses</a>
                                    <a href="#" class="badge badge-success">edit</a>
                                    <a href="#" class="badge badge-danger">hapus</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal - Live Demo -->
<div class="modal fade" id="tambahAksesMenuModal" tabindex="-1" role="dialog" aria-labelledby="tambahAksesMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAksesMenuModalLabel">Form Tambah Akses Menu</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="<?= base_url('admin/akses_menu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="akses_menu" name="akses_menu" placeholder="Masukkan Akses Menu...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>