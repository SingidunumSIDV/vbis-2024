<?php

use app\models\UserModel;

/** @var $params UserModel
 */

?>

<div class="card">
    <form action="/processUpdateAdd" method="post">
        <input type="hidden" name="id" value="<?php echo $params->id ?>">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center">
                <p class="mb-0">Edit Advertisement</p>
                <button class="btn btn-success btn-sm ms-auto" type="submit">Save</button>
            </div>
        </div>
        <div class="card-body">
            <p class="text-uppercase text-sm">Add Information</p>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Add text</label>
                        <input class="form-control" type="text" name="text" value="<?php echo $params->text ?>"
                               onfocus="focused(this)" onfocusout="defocused(this)">
                        <?php
                        if ($params != null && $params->errors != null) {
                            foreach ($params->errors as $attribute => $error) {
                                if ($attribute == 'text') {
                                    echo "<span class='text-danger'>$error[0]</span>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Description</label>
                        <input class="form-control" type="text" name="description" value="<?php echo $params->description ?>"
                               onfocus="focused(this)" onfocusout="defocused(this)">
                        <?php
                        if ($params != null && $params->errors != null) {
                            foreach ($params->errors as $attribute => $error) {
                                if ($attribute == 'description') {
                                    echo "<span class='text-danger'>$error[0]</span>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>