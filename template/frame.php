<link rel="stylesheet" href="<?php echo $this->pluginUrl; ?>css/wof.css"/>
<div id="yarWheelWrap">
    <div class="yar-wheel">
        <div id="YarLeaves" class="yar-leaves">
        <?php foreach ($this->userList as $userId=>$userName) { ?>
        
        <div class="yar-leaf-wrap"><div class="yar-wheel-name" title="<?php echo $userName; ?>" id="yarWheelName_<?php echo $userId; ?>"><?php echo $userName; ?></div></div>
        
        <?php } ?>
        </div>
        <div id="YarStart" class="yar-wheel-start"></div>
    </div>
</div>
<script type="text/javascript">
var pageConfig = {
    userIdList : [<?php 
    $iterator = 0;
    foreach ($this->userList as $userId=>$userName) {
        if (!$userName) continue;
        echo $userId;
        if ($iterator != count($this->userList) - 1) {
            echo ",";
        }
        ++$iterator;
    }
?>],
    winner : <?php echo $this->winnerId; ?>,
    layerLeafCount : <?php echo $this->memberPerLayer; ?>,
    startRadius : <?php echo $this->startRadius; ?>,
    radiusRange : <?php echo $this->radiusRange; ?>,
    leafScale : <?php echo $this->leafScale; ?>,
    animationDuiton : <?php echo $this->animationDuration; ?>
};
</script>
<script type="text/javascript" src="<?php echo $this->pluginUrl; ?>js/wof.js"></script>