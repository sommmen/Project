<!DOCTYPE html>
<html>
<head>
    <title>This is default template of MyCMS</title>
    <link type='text/css' rel='stylesheet' href='<?php echo $this->getCurrentTemplatePath(); ?>res/css/style.css' />
</head>
<body>
<div class="wrapper">
    <div class="header"><?php echo $this->widgetOutput('logoPosition'); ?></div>
    <div class='clear'></div>
    <div class="sidebar">
        <?php $this->widgetOutput('sidebarPosition'); ?>
        <br><br><br><br><br><br><br>
    </div>
    <div class='content'>
        <?php echo $this->appOutput();?>
        <br><br><br><br><br>
    </div>
    <div class='clear'></div>
    <div class="footer">
        this is footer text                
    </div>
</div>
</body>
</html>