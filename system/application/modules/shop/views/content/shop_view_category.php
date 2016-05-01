<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<div>
    <ul>
    <?php
        foreach($sub_category_data as $sub_cat) {
    ?>
        <li>
            <?php echo anchor('shop/category/'.$sub_cat['id'].'/'.$sub_cat['name'],$sub_cat['name']); ?>
        </li>
    <?php
        }
    ?>
    </ul>
</div>

