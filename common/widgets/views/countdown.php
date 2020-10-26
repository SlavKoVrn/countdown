<div id="<?= $id ?>" style="width:100%;height:150px;background:black;">
    <div style="position:absolute;top:55%;left:30px;">
        <img id="<?= $id ?>-on" src="<?= $on ?>" style="display:none;float:left;" />
        <img id="<?= $id ?>-off" src="<?= $off ?>" style="display:none;float:left;" />
        <img id="<?= $id ?>-red" src="<?= $red ?>" style="display:none;float:left;" />
        <span id="<?= $id ?>-countdown" style="padding-top:50px;color:white">Торги на
            <span class="stock"><?= $stock ?></span>
            <span class="state"></span> через
            <span class="days"></span>
            <span class="hours"></span>
            <span class="minutes"></span>
            <span class="seconds"></span> по МСК
        </span>
    </div>
</div>
