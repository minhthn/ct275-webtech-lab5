<?php $this->layout("layouts/default", ["title" => APP_NAME]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<div class="container">

    <!-- SECTION HEADING -->
    <h2 class="text-center animate__animated animate__bounce">Contacts</h2>
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center">
            <p class="animate__animated animate__fadeInLeft">View your all contacs here.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <!-- FLASH MESSAGES -->

            <a href="/contacts/add" class="btn btn-primary mb-3">
                <i class="fa fa-plus"></i> New Contact</a>

            <!-- Table Starts Here -->
            <table id="contacts" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Notes</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact) : ?>
                        <tr>
                            <td><?= $this->e($contact->name) ?></td>
                            <td><?= $this->e($contact->phone) ?></td>
                            <td><?= $this->e(date("d-m-Y", strtotime($contact->created_at))) ?></td>
                            <td><?= $this->e($contact->notes) ?></td>
                            <td class="d-flex justify-content-center">
                                <a href="<?= '/contacts/edit/' . $this->e($contact->id) ?>" class="btn btn-xs btn-warning">
                                    <i alt="Edit" class="fa fa-pencil"></i> Edit</a>
                                <form class="form-inline ml-1" action="<?= '/contacts/delete/' . $this->e($contact->id) ?>" method="POST">
                                    <button type="submit" class="btn btn-xs btn-danger" name="delete-contact">
                                        <i alt="Delete" class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <!-- Table Ends Here -->
        </div>
    </div>
</div>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        new DataTable('#contacts');
    });
</script>
<?php $this->stop() ?>
