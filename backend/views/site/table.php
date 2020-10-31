<?php
use common\models\WorkHoliday;
?>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width:25%">От</th>
                <th style="width:25%">До</th>
                <th style="width:50%">Название</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($days as $day) : ?>
            <tr class="<?= ($day['holiday'] == WorkHoliday::HOLIDDAY)?'danger':'success' ?>">
                <td><?= date(($day['holiday'] == WorkHoliday::HOLIDDAY)?'d.m.Y':'d.m.Y H:i',strtotime($day['begin'])) ?></td>
                <td><?= date(($day['holiday'] == WorkHoliday::HOLIDDAY)?'d.m.Y':'d.m.Y H:i',strtotime($day['end'])) ?></td>
                <td><?= $day['name'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
