<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Properties</h4>
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Property name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php
                    if (isset($properties) && !empty($properties)) {
                        foreach ($properties as $property)
                    ?>
                        <tr>
                            <td>
                                <strong><?= $property->propertyName; ?></strong><?php if ($property->isDefault == 2) { ?>
                                    <span class="badge bg-label-success me-1">Default</span>
                                <?php } ?>
                            </td>
                            <td><?= $property->roleName; ?>
                            </td>
                            <td><span class="badge bg-label-primary me-1">Active</span></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-pencil me-1"></i> Edit</a>
                                        <?php if ($property->isDefault != 2) {
                                        ?>
                                            <a class="dropdown-item" onclick="setDefault('<?= $property->id; ?>','<?= $property->propertyName; ?>')"><i class="ti ti-pencil me-1"></i> Set default</a>
                                        <?php
                                        } ?>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <tr>
                            <td colspan="4">No records found.</td>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function setDefault(id, propertyName) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Set ' + propertyName + ' as your default property',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {

        });
    }
</script>