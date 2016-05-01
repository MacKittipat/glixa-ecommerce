<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<div>
    <?php
        echo form_open(current_url(), array('id'=>'frm_answer'));
        echo create_form_key();
    ?>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product_qa', 'question'); ?>
        </li>
        <li class="inputfield">
            <?php echo $product_qa_data['question']; ?>
        </li>
    </ul>
    <div class="clear"></div>

    <ul class="forms">
        <li class="txt">
            โดย / เมื่อ
        </li>
        <li class="inputfield">
            <?php
                echo $product_qa_data['user_name'] .' / ';
                echo $product_qa_data['add_date'];
            ?>
        </li>
    </ul>
    <div class="clear"></div>


    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product_qa', 'answer'); ?>
        </li>
        <li class="inputfield">
            <textarea name="txt_answer" class="txtx" style="width: 300px;" cols="50" rows="5"><?php echo $product_qa_data['answer']; ?></textarea>
        </li>
    </ul>
    <div class="clear"></div>
    <a href="javascript:void(0);" class="button right" style="margin-top: -5px;" onclick="javascript:$('#frm_answer').submit();"><span>ตอบ</span></a>
    <input type="hidden" name="btn_submit" value="ตอบ" />
    <div class="form_row" style="display: none;" >
        <input type="submit" name="btn_submit" value="ตอบ" />
    </div>
    <?php
        echo form_close();
    ?>
</div>
