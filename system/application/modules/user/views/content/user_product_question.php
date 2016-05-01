<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<div>
    <table class="table" border="1">
        <thead>
            <tr>
                <th>
                    <?php echo get_field_lang('shop_product_qa', 'question'); ?>
                </th>
                <th style="width: 200px;">
                    <?php echo get_field_lang('shop_product_qa', 'product_id'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($product_qa_data as $qa) {
                    $product_data = $this->product_model->get_product('id',$qa['product_id']);
            ?>
            <tr>
                <td><?php echo anchor('user/product_answer/'.$qa['id'],$qa['question']); ?></td>
                <td><?php echo anchor('shop/product/'.$product_data['id'].'/'.$product_data['name'],$product_data['name']); ?></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
<?php echo $pagination; ?>