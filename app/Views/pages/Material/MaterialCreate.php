<?= $this->extend('layout/wrapper'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <form action="/Material/save" method="POST">
                <?= csrf_field(); ?>
                <div class="row mb-3">
                    <label for="inputMaterial" class="col-sm-2 col-form-label">Material Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('inputMaterial')) ? 'is-invalid' : ''; ?>" id="inputMaterial" name="inputMaterial" value="<?= old('inputMaterial'); ?>" autofocus>
                        <div class="invalid-feedback">
                            <?= $validation->getError('inputMaterial'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputMaterial" class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control <?= ($validation->hasError('inputPrice')) ? 'is-invalid' : ''; ?>" id="inputPrie" name="inputPrice" value="<?= old('inputPrice'); ?>" autofocus>
                        <div class="invalid-feedback">
                            <?= $validation->getError('inputPrice'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputMaterial" class="col-sm-2 col-form-label">Work</label>
                    <div class="col-sm-10">
                        <select class="form-control <?= ($validation->hasError('inputWork')) ? 'is-invalid' : ''; ?>" id="inputWork" name="inputWork" value="<?= old('inputWork'); ?>" autofocus>
                            <option>No Work</option>
                            <?php foreach ($WorkData as $Work) : ?>
                                <option value="<?= $Work['Id']; ?>"><?= $Work['WorkName']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('inputPrice'); ?>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>