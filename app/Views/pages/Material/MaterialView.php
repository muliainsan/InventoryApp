<?= $this->extend('layout/wrapper'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1>Material Data</h1>
                    <p class="card-text"> Create, Read, Update, Delete (CRUD) for Material Material datas</p>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('pesan'); ?>
                        </div>
                    <?php endif; ?>
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline">
                        <a href="/Material/create" class="btn btn-primary mb-2 ">Add Material</a>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Material Name</th>
                                <th>Price</th>
                                <th>Work</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($MaterialData as $Material) : ?>
                                <tr>
                                    <td><?php echo $i++ ?></th>
                                    <td><?php echo $Material['MaterialName']; ?></th>
                                    <td><?php echo $Material['Price']; ?></th>
                                        <?php
                                        if (is_null($Material['WorkId'])) {
                                        ?>
                                    <td><?php echo "-"; ?></th>
                                    <?php } else { ?>
                                    <td><?php echo $WorkModel->getWork((int)$Material['WorkId'])["WorkName"]; ?></th>
                                    <?php } ?>

                                    <td>
                                        <!-- <a href="/Material/detail/<?= $Material['Id']; ?>" class="btn btn-success">Detail</a> -->
                                        <a href="/Material/edit/<?= $Material['Id']; ?>" class="btn btn-warning">Update</a>
                                        <button type="button" class="btn btn-danger open-modaldelete" data-toggle="modal" data-target="#modal-delete" data-id='<?= $Material['Id']; ?>' data-name='<?= $Material['MaterialName']; ?>'>
                                            Delete
                                        </button>

                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Material Name</th>
                                <th>Price</th>
                                <th>Work</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.col-md-6 -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Material</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a>Are you sure want to delete "</a> <b id="Name"></b> <a>" Material?</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <form action="/Material/delete" class="d-inline" method="DELETE">
                    <?= csrf_field(); ?>

                    <input type="hidden" id="Id" name="Id" value="">

                    <button type="submit" href="" class="btn btn-danger">Delete</button>
                </form>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?= $this->endSection(); ?>