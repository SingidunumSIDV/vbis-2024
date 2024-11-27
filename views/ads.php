<?php

/** @var $params array
 */
//    echo "<pre>";
//    var_dump($params);
?>

<div class="card">
    <div class="card-header pb-0">
        <h6>Advertisements</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Add</th>
                    <th class="text-secondary opacity-7"></th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($params as $param) {
                    echo "<tr>";
                    echo "<td>";
                    echo "<div class='d-flex px-2 py-1'>";
                    echo "<div>";
                    echo "<img src='../assets/img/curved-images/curved2.jpg' class='avatar avatar-xxl me-3' alt='user1'>";
                    echo "</div>";
                    echo "<div class='d-flex flex-column justify-content-center'>";
                    echo "<h6 class='mb-0 text-sm'><span class='text-xs text-secondary mb-0'>Site #:</span> $param[site_id]</h6>";
                    echo "<h6 class='mb-0 text-sm'><span class='text-xs text-secondary mb-0'>URL:</span> $param[site_url]</h6>";
                    echo "<h6 class='mb-0 text-sm'><span class='text-xs text-secondary mb-0'>Add text:</span> $param[text]</h6>";
                    echo "<p class='text-xs text-secondary mb-0'><span class='text-xs text-secondary mb-0'>Add description:</span> $param[description]</p>";
                    echo "</div>";
                    echo "</div>";
                    echo " </td>";
                    echo "<td class='align-middle'>";
                    echo "<a href='/updateAd?id=$param[id]' target='_blank' class='text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>";
                    echo "Edit";
                    echo "</a>";
                    echo " </td>";
                    echo "  </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>