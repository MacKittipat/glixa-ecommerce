<div style="font-size: small;font-family: Tahoma;">
    <div style="margin-bottom: 5px;">
        เรียนคุณ <?php echo $firstname.' '.$lastname; ?>
    </div>
    <div style="margin-bottom: 5px;">
        เรื่อง การขอรหัสผ่าน
    </div>
    <div style="margin-bottom: 5px;">
        รหัสผ่านของคุณคือ <?php echo $new_password; ?>
    </div>
    <div style="margin-bottom: 5px;">
        กรุณาเก็บข้อมูลนี้เป็นความลับและเปลี่ยนรหัสผ่านอย่างสม่ำเสมอเพื่อความปลอดภัยในข้อมูลของคุณ
    </div>
    <?php $this->load->view('mail_template/mail_footer'); ?>
</div>
