<?php
    if($this->input->post('ddl_supplier_first')) {
?>
<div class="form_row">
    <div id="form_row_title">
        <b><?php echo get_field_lang('shop_purchase', 'supplier'); ?></b>
    </div>
    <div id="form_row_control">
        <?php echo $supplier_data['name']; ?>
    </div>
</div>
<?php
    echo form_open('admin/purchase/add');
    echo create_form_key();
?>
<input type="hidden" name="hid_supplier_id" value="<?php echo $supplier_data['id']; ?>" />
<div class="form_row datatable">
    <table id="datatable_table" border="1">
        <thead>
            <tr>
                <th style="width: 300px;">
                    สินค้า <a href="javascript:void(0);" onclick="add_product();">เพิ่ม</a>
                </th>
                <th  style="width: 200px;">
                    ราคาต่อชิ้น (บาท)
                </th>
                <th  style="width: 200px;">
                    จำนวน
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="ddl_product[]">
                        <?php
                            foreach($product_data as $product) {
                        ?>
                        <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                     <a href="javascript:void(0);" onclick="del_product(this);">ลบ</a>
                </td>
                <td style="text-align: center;">
                    <input type="text" name="txt_price[]" />
                </td>
                <td style="text-align: center;">
                    <input type="text" name="txt_quantity[]" />
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="form_row">
    <input type="submit" name="btn_submit" value="เพิ่มใบสั่งซื้อ" />
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
    function add_product() {
        $("#datatable_table tbody").append("<tr>" +
            "<td><select name='ddl_product[]'>" +
            <?php
                foreach($product_data as $product) {
            ?>
            "<option value='<?php echo $product['id']; ?>'><?php echo $product['name']; ?></option>" + 
            <?php
                }
            ?>
            "</select> <a href='javascript:void(0);' onclick='del_product(this);'>ลบ</a></td>" +
            "<td style='text-align: center;'><input type='text' name='txt_price[]' /></td>" +
            "<td style='text-align: center;'><input type='text' name='txt_quantity[]' /></td></tr>"
        );
    }
    function del_product(ele) {
        $(ele).parent().parent("tr").remove();
    }
</script>
<?php
    } else {
?>
<?php
    echo form_open('admin/purchase/add', array('id'=>'frm_purchase_first'));
    echo create_form_key();
?>
<div class="form_row">
    <div id="form_row_title">
        <b><?php echo get_field_lang('shop_purchase', 'supplier'); ?></b>
    </div>
    <div id="form_row_control">
        <select name="ddl_supplier_first" id="ddl_supplier_first">
            <option value="0"> == เลือกผู้ผลิตสินค้า == </option>
        <?php
            foreach($all_supplier_data as $supplier) {
        ?>
            <option value="<?php echo $supplier['id']; ?>">
                <?php echo $supplier['name']; ?>
            </option>
        <?php
            }
        ?>
        </select>
    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#ddl_supplier_first").change(function() {
            if($("#ddl_supplier_first").val()!='0') { // เข้าหน้านี้ครั้งแรกต้องเลือก supplier ก่อน
                $("#frm_purchase_first").submit();
            }
        });
    });
</script>
<?php
    }
?>








