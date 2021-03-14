<ol class="breadcrumb">
    <?php
    $breadCrumbsCount = count($breadCrumbs);
    $breadCrumbsCounter = 1;
    ?>
    <?php foreach ($breadCrumbs as $breadCrumb) { ?>
        <?php if ($breadCrumbsCounter == $breadCrumbsCount) { ?> 
            <span style="font-size : 13px;margin-left: 5px;">  <?= $breadCrumb['name'] == 'Dashboard' ? '<i class="fa fa-dashboard"></i> Dashboard' : '> '.$breadCrumb['name'] ?></span>
        <?php } else { ?>
            <li class="<?= $breadCrumbsCounter == $breadCrumbsCount ? 'active' : '' ?>">
                <a href="<?= asset($breadCrumb['href']) ?>"><?= $breadCrumb['name'] == 'Dashboard' ? '<i class="fa fa-dashboard"></i> Dashboard' : $breadCrumb['name'] ?></a>
            </li>
        <?php } $breadCrumbsCounter++; ?>
    <?php } ?>
</ol>
