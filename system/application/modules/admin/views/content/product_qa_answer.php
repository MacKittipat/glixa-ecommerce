<div>
    <?php
        echo form_open(current_url());
        echo create_form_key();
    ?>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product_qa', 'question'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php
                    echo $product_qa_data['question'];
                ?>
            </div>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product_qa', 'answer'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <textarea cols="50" rows="5" name="txt_answer"><?php echo $product_qa_data['answer'];?></textarea>
            </div>
        </div>
    </div>
    <div class="form_row">
        <input type="submit" name="btn_submit" value="ตอบคำถาม" />
    </div>
    <?php
        echo form_close();
    ?>
</div>