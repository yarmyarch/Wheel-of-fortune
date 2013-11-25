<form name="publicSettings" id="publicSettings" method="post" action="">
    <input type="hidden" name="isSubmit" value="1" />
    <input type="hidden" name="wheelName" value="<?php echo $this->currentWheelName; ?>" />
    <input type="hidden" name="choosedMembers" id="choosedMembers" value="" />
    <br/><br/>
    
    <h2><?php echo __("All avaliable wheels", "wheel-of-fortune"); ?></h2>
    <label for="wheelSelect"><?php echo __("Actived wheels: ", "wheel-of-fortune"); ?></label>
    <select id="wheelSelect" name="wheelSelect">
        <?php foreach($this->wheelNameList as $name=>$userData) { ?>
        <option value="<?php echo $name; ?>" <?php if ($name == $this->currentWheelName) echo "selected"; ?>><?php echo $name; ?></option>
        <?php } ?>
    </select>
    <input id="wheelAddGoBtn" style="display:none;" type="button" value="<?php echo __("View config", "wheel-of-fortune"); ?>" />
    <input id="wheelAddDltBtn" <?php if ("Default" == $this->currentWheelName) echo 'style="display:none;"'; ?> type="button" value="<?php echo __("Remove wheel", "wheel-of-fortune"); ?>" />
    <br/><br/>
    <label for="wheelAddNew"><?php echo __("Add another wheel with the name of:", "wheel-of-fortune"); ?></label>
    <input id="wheelAddNew" name="wheelAddNew" size="16" maxlength="16" />
    <input id="wheelAddNewBtn" type="button" value="<?php echo __("Add", "wheel-of-fortune"); ?>" />
    <span style="color:red" id="wheelAddInfo"></span>
    <br>
    <?php echo __("NOTE: The name should be unique that would be used to specify each wheel. It won't be displayed into the page. No spaces or other symbols required.", "wheel-of-fortune"); ?>
    <br/><br/>
    
    <h2><?php echo __("Member Settings for wheel", "wheel-of-fortune")." \"".$this->currentWheelName."\""; ?></h2>
    <br/><br/>
    <input type="checkbox" name="clearWinner" id="clearWinner" value="1" />&nbsp;&nbsp;
    <label for="clearWinner"><?php 
        echo __("Clear current winner and repick another one: ", "wheel-of-fortune"); 
        if (!$this->winnerId) echo "nobody";
        else {
            echo $this->userList[$this->winnerId];
        }
    ?></label><br /><br />
    
    <label for="memberSelect"><?php echo __("Choose members from: ", "wheel-of-fortune"); ?></label>
    <select id="memberSelect" name="memberFrom">
        <option value="0" <?php if ($this->memberFrom == 0) echo "selected"; ?>><?php echo __("Members with posts or comments", "wheel-of-fortune"); ?></option>
        <option value="1" <?php if ($this->memberFrom == 1) echo "selected"; ?>><?php echo __("All regested members", "wheel-of-fortune"); ?></option>
    </select>
    <br />
    
    <div id="pcMemberWrap" <?php if ($this->memberFrom != 0) echo 'style="display:none;"'; ?>>
        
        <label for="pcYear"><?php echo __("Date interval from: ", "wheel-of-fortune"); ?></label> 
        <input name="pcDay" id="pcDay" size="2" maxlength="2" /><label for="pcDay"><?php echo __("(day)", "wheel-of-fortune"); ?></label> - 
        <input name="pcMonth" id="pcMonth" size="2" maxlength="2" /><label for="pcMonth"><?php echo __("(month)", "wheel-of-fortune"); ?></label> - 
        <input name="pcYear" id="pcYear" size="4" maxlength="4" /><label for="pcYear"><?php echo __("(year)", "wheel-of-fortune"); ?></label>
        <input name="pcDateConfirm" id="pcDateConfirm" type="button" value="<?php echo __("confirm", "wheel-of-fortune"); ?>" />
        <input name="pcDateClear" id="pcDateClear" type="button" value="<?php echo __("clear date info", "wheel-of-fortune"); ?>" />
        <span style="color:red" id="pcDateInfo"></span>
        <br />
        <label for="pcYearTo"><?php echo __("Date interval to&nbsp;&nbsp;: ", "wheel-of-fortune"); ?></label> 
        <input name="pcDayTo" id="pcDayTo" size="2" maxlength="2" /><label for="pcDayTo"><?php echo __("(day)", "wheel-of-fortune"); ?></label> - 
        <input name="pcMonthTo" id="pcMonthTo" size="2" maxlength="2" /><label for="pcMonthTo"><?php echo __("(month)", "wheel-of-fortune"); ?></label> - 
        <input name="pcYearTo" id="pcYearTo" size="4" maxlength="4" /><label for="pcYearTo"><?php echo __("(year)", "wheel-of-fortune"); ?></label>
        <input name="pcDateConfirmTo" id="pcDateConfirmTo" type="button" value="<?php echo __("confirm", "wheel-of-fortune"); ?>" />
        <span style="color:red" id="pcDateInfoTo"></span>
        <br />
        
        <label for="catSelect"><?php echo __("Category in: ", "wheel-of-fortune"); ?></label>
        <select id="catSelect" name="catSelect">
            <option value="0"><?php echo __("  All categories", "wheel-of-fortune"); ?></option>
            <?php 
            foreach($this->activedCategories as $category) { 
                if (isset($category["catData"]) && isset($category["catData"]->cat_ID)) {
            ?>
                    <option value="<?php echo $category["catData"]->cat_ID; ?>"><?php echo $category["catData"]->name; ?></option>
            <?php 
                } // endif
            } // end foreach?>
        </select>
        <br /><br />
    
        <input type="checkbox" id="pcSelectAll" /><label for="pcSelectAll">&nbsp;&nbsp;<?php echo __("Select all (Default if no members selected)", "wheel-of-fortune"); ?></label><br>
<?php 
    foreach($this->memberList as $member) {
?>
        <span id="pcMember_<?php echo $member->user_id ?>">
            <input type="checkbox" class="pc-member-item" id="pcUserCheck_<?php echo $member->user_id; ?>" value="<?php echo $member->user_id; ?>" <?php if ($this->userList[$member->user_id]) echo "checked"; ?>/>
            <label for="pcUserCheck_<?php echo $member->user_id; ?>">
                <?php echo $member->{WheelOfFortune::$SHOW_NAME_AS[$this->showNameAs]}."<br>&nbsp;&nbsp;(".__("Last actived at: ", "wheel-of-fortune").$member->a_date.")"; ?>
            </label>
            <br>
        </span>
<?php
    }
?>
    </div>
    <div id="fullMemberWrap" <?php if ($this->memberFrom != 1) echo 'style="display:none;"'; ?>>
    
        <label for="fullYear"><?php echo __("Registered since&nbsp;: ", "wheel-of-fortune"); ?></label> 
        <input name="fullDay" id="fullDay" size="2" maxlength="2" /><label for="fullDay"><?php echo __("(day)", "wheel-of-fortune"); ?></label> - 
        <input name="fullMonth" id="fullMonth" size="2" maxlength="2" /><label for="fullMonth"><?php echo __("(month)", "wheel-of-fortune"); ?></label> - 
        <input name="fullYear" id="fullYear" size="4" maxlength="4" /><label for="fullYear"><?php echo __("(year)", "wheel-of-fortune"); ?></label>
        <input name="fullDateConfirm" id="fullDateConfirm" type="button" value="<?php echo __("confirm", "wheel-of-fortune"); ?>" />
        <input name="fullDateClear" id="fullDateClear" type="button" value="<?php echo __("clear date info", "wheel-of-fortune"); ?>" />
        <span style="color:red" id="fullDateInfo"></span>
        <br />
        <label for="fullYearTo"><?php echo __("Registered before: ", "wheel-of-fortune"); ?></label> 
        <input name="fullDayTo" id="fullDayTo" size="2" maxlength="2" /><label for="fullDayTo"><?php echo __("(day)", "wheel-of-fortune"); ?></label> - 
        <input name="fullMonthTo" id="fullMonthTo" size="2" maxlength="2" /><label for="fullMonthTo"><?php echo __("(month)", "wheel-of-fortune"); ?></label> - 
        <input name="fullYearTo" id="fullYearTo" size="4" maxlength="4" /><label for="fullYearTo"><?php echo __("(year)", "wheel-of-fortune"); ?></label>
        <input name="fullDateConfirmTo" id="fullDateConfirmTo" type="button" value="<?php echo __("confirm", "wheel-of-fortune"); ?>" />
        <span style="color:red" id="fullDateInfoTo"></span>
        <br />
    
        <input type="checkbox" id="fullSelectAll" /><label for="fullSelectAll">&nbsp;&nbsp;<?php echo __("Select all", "wheel-of-fortune"); ?></label><br>
<?php 
    foreach($this->fullMemberList as $member) {
?>
        <span id="fullMember_<?php echo $member->user_id ?>">
            <input type="checkbox" class="full-member-item" id="fullUserCheck_<?php echo $member->user_id; ?>" value="<?php echo $member->user_id; ?>" <?php if ($this->userList[$member->user_id]) echo "checked"; ?>/>
            <label for="fullUserCheck_<?php echo $member->user_id; ?>"><?php echo $member->{WheelOfFortune::$SHOW_NAME_AS[$this->showNameAs]}; ?></label>
        </span>
<?php
    }
?>
    </div>
    
    <br/><br/>
    <h2><?php echo __("Advanced Settings", "wheel-of-fortune"); ?></h2>
    <br/><br/>
    
    <label for="maxMember"><?php echo __("Max member count for each display(min 2, if choosen users' number is bigger than this config, random users would be picked for the page to show up. Not including the winner and the logged in user himself): ", "wheel-of-fortune"); ?></label><input type="input" name="maxMember" id="maxMember" size=5 maxlength="3" value="<?php echo $this->maxMemberCount; ?>" /><br/><br/>
    <label for="mpLayer"><?php echo __("Max member count in each wheel(min 2): ", "wheel-of-fortune"); ?></label><input type="input" name="mpLayer" id="mpLayer" size=5 maxlength="2" value="<?php echo $this->memberPerLayer; ?>" /><br/><br/>
    
    <label for="startRadius"><?php echo __("The radius of the first wheel: ", "wheel-of-fortune"); ?></label><input type="input" name="startRadius" id="startRadius" size=5 maxlength="3" value="<?php echo $this->startRadius; ?>" />(px)<br/><br/>
    <label for="radiusRange"><?php echo __("Radius range between wheels: ", "wheel-of-fortune"); ?></label><input type="input" name="radiusRange" id="radiusRange" size=5 maxlength="3" value="<?php echo $this->radiusRange; ?>" />(px)<br/><br/>
    <label for="mpLayer"><?php echo __("How much time will the rotation last: ", "wheel-of-fortune"); ?></label><input type="input" name="duration" id="duration" size=5 maxlength="5" value="<?php echo $this->animationDuration; ?>" />(ms)<br/><br/>
    <label for="duration"><?php echo __("Show member's name as: ", "wheel-of-fortune"); ?></label>
    <input type="radio" name="usernameAs" value="0" <?php if ($this->showNameAs == 0) echo "checked"; ?>/><?php echo __("  user's login account", "wheel-of-fortune"); ?>
    <input type="radio" name="usernameAs" value="1" <?php if ($this->showNameAs == 1) echo "checked"; ?>/><?php echo __("  real name in profile", "wheel-of-fortune"); ?>
    <br/><br/>
    
    <input type="submit" />
</form>
<script type="text/javascript">
(function(){

    var pageConfig = {
        pcMembers : {<?php 
            $i = 0;
            $count = count($this->memberList);
            foreach($this->memberList as $member) {
                echo $member->user_id.": "."{ name : '".$member->{WheelOfFortune::$SHOW_NAME_AS[$this->showNameAs]}."', activeDate : '".$member->a_date."', activeCatId : +'".$member->category->cat_ID."' }"; 
                if ($i < $count) echo ",";
                ++$i;
            }
        ?>
        },
        fullMembers : {<?php 
            $i = 0;
            $count = count($this->fullMemberList);
            foreach($this->fullMemberList as $member) {
                echo $member->user_id.": "."{name : '".$member->{WheelOfFortune::$SHOW_NAME_AS[$this->showNameAs]}."',registDate : '".$member->r_date."'}"; 
                if ($i < $count) echo ",";
                ++$i;
            }
        ?>
        },
        categories : {<?php 
            $i = 0;
            $count = count($this->activedCategories);
            foreach($this->activedCategories as $category) {
                $memberForCat = join(",", array_unique($category["members"]));
                $catData = $category["catData"];
                if (isset($catData) && isset($catData->cat_ID)) {
                    echo $catData->cat_ID.": "."{name : '".$catData->name."', members : [".$memberForCat."]}"; 
                    if ($i < $count) echo ",";
                }
                ++$i;
            }
        ?>
        },
        wheelName : "<?php echo $this->currentWheelName; ?>",
        wheelList : {
            <?php
            $i = 0;
            $count = count($this->wheelNameList);
            foreach($this->wheelNameList as $name=>$userData) {
                echo $name.": "."1"; 
                if ($i < $count) echo ",";
                ++$i;
            }
            ?>
        }
    };

    var memberWrap = ["pcMemberWrap", "fullMemberWrap"];
    var memberItemClass = ["pc-member-item", "full-member-item"];
    
    var validateDate = function(year, month, day) {
        if (+year >= 2000 && +year <= 2099 && +month >= 1 && +month <= 12 && +day >= 0 && +day <= 31) return true;
        return false;
    }
    
    var dateLaterThan = function(date, year, month, day) {
        var year = +year,
            month = +month,
            day = +day,
            d_year = date.match(/\d{4}(?=[-_])/),
            d_month = date.match(/[-_](\d{1,2})[-_]/)[1],
            d_day = date.match(/[-_]\d{1,2}[-_](\d{1,2})(?![-_])/)[1];
        return validateDate(d_year, d_month, d_day) && (d_year > year || (d_year == year && d_month > month) || (d_year == year && d_month == month && d_day >= day));
    }
    
    getElementsByClassName = function(className, tagName) {
            
        //check buf first
        var elems, tmpElems;
        
        elems = document.getElementsByClassName && document.getElementsByClassName(className);
        
        if (elems) return elems;
        tagName = tagName || "div";
        tmpElems = document.getElementsByTagName(tagName);
        elems = [];
        for (var i = 0, len = tmpElems.length; i < len; ++i) {
            tmpElems[i].className.match(className) && elems.push(tmpElems[i]);
        }
        return elems;
    }
    
    document.getElementById("memberSelect").onchange = function(e) {
        var value = this.value;
        document.getElementById(memberWrap[value]).style.display = "block";
        document.getElementById(memberWrap[+!+value]).style.display = "none";
    }
    
    document.getElementById("publicSettings").onsubmit = function(e) {
        
        // generate selected user list.
        var elems = getElementsByClassName(memberItemClass[document.getElementById("memberSelect").value], "input"),
            ids = [];
        for (var i = 0, len = elems.length; i < len; ++i) {
            elems[i].checked && ids.push(elems[i].id.match(/\d+/)[0]);
        }
        
        document.getElementById("choosedMembers").value = ids.join(",");
    }
    
    document.getElementById("fullSelectAll").onchange = function(e) {
        var elems = getElementsByClassName(memberItemClass[1]);
        for (var i = 0, len = elems.length; i < len; ++i) {
            // check if not hidden
            if (document.getElementById("fullMember_" + elems[i].id.match(/\d+/)).style.display != "none") {
                elems[i].checked = this.checked;
            }
        }
    }
    
    document.getElementById("pcSelectAll").onchange = function(e) {
        var elems = getElementsByClassName(memberItemClass[0]);
        for (var i = 0, len = elems.length; i < len; ++i) {
            // check if not hidden
            if (document.getElementById("pcMember_" + elems[i].id.match(/\d+/)).style.display != "none") {
                elems[i].checked = this.checked;
            }
        }
    }
    
    document.getElementById("pcDateConfirm").onclick = document.getElementById("pcDateConfirmTo").onclick = function() {
        
        var yearFrom = document.getElementById("pcYear").value,
            monthFrom = document.getElementById("pcMonth").value,
            dayFrom = document.getElementById("pcDay").value;
            yearTo = document.getElementById("pcYearTo").value,
            monthTo = document.getElementById("pcMonthTo").value,
            dayTo = document.getElementById("pcDayTo").value,
            fromValidated = validateDate(yearFrom, monthFrom, dayFrom),
            toValidated = validateDate(yearTo, monthTo, dayTo);
            
        if (!fromValidated && !toValidated) {
            document.getElementById("pcDateInfoTo").innerHTML = "<?php echo "Invalid date format, non-blank and number only."; ?>";
            setTimeout(function() {
                document.getElementById("pcDateInfoTo").innerHTML = "";
            }, 3000);
            return;
        }
        // filter post/comments member list.
        for (var i in pageConfig.pcMembers) {
            var pass = true;
            if (fromValidated && !dateLaterThan(pageConfig.pcMembers[i]["activeDate"], yearFrom, monthFrom, dayFrom)) {
                document.getElementById("pcMember_" + i).style.display = "none";
                document.getElementById("pcUserCheck_" + i).checked = false;
                pass = false;
            } 
            if (toValidated && dateLaterThan(pageConfig.pcMembers[i]["activeDate"], yearTo, monthTo, dayTo)) {
                document.getElementById("pcMember_" + i).style.display = "none";
                document.getElementById("pcUserCheck_" + i).checked = false;
                pass = false;
            }
            if (pass) {
                document.getElementById("pcMember_" + i).style.display = "";
                document.getElementById("pcUserCheck_" + i).checked = true;
            }
        }
    }
    
    document.getElementById("pcDateClear").onclick = function() {
        
        document.getElementById("pcYear").value = "",
        document.getElementById("pcMonth").value = "",
        document.getElementById("pcDay").value = "";
        
        document.getElementById("pcYearTo").value = "",
        document.getElementById("pcMonthTo").value = "",
        document.getElementById("pcDayTo").value = "";
        
        // filter post/comments member list.
        for (var i in pageConfig.pcMembers) {
            document.getElementById("pcMember_" + i).style.display = "";
            document.getElementById("pcUserCheck_" + i).checked = true;
        }
    }
    
    document.getElementById("fullDateConfirm").onclick = document.getElementById("fullDateConfirmTo").onclick = function() {
        
        var yearFrom = document.getElementById("fullYear").value,
            monthFrom = document.getElementById("fullMonth").value,
            dayFrom = document.getElementById("fullDay").value;
            yearTo = document.getElementById("fullYearTo").value,
            monthTo = document.getElementById("fullMonthTo").value,
            dayTo = document.getElementById("fullDayTo").value,
            fromValidated = validateDate(yearFrom, monthFrom, dayFrom),
            toValidated = validateDate(yearTo, monthTo, dayTo);
            
        if (!fromValidated && !toValidated) {
            document.getElementById("fullDateInfoTo").innerHTML = "<?php echo "Invalid date format, non-blank and number only."; ?>";
            setTimeout(function() {
                document.getElementById("fullDateInfoTo").innerHTML = "";
            }, 3000);
            return;
        }
        // filter post/comments member list.
        for (var i in pageConfig.fullMembers) {
            var pass = true;
            if (fromValidated && !dateLaterThan(pageConfig.fullMembers[i]["registDate"], yearFrom, monthFrom, dayFrom)) {
                document.getElementById("fullMember_" + i).style.display = "none";
                document.getElementById("fullUserCheck_" + i).checked = false;
                pass = false;
            } 
            if (toValidated && dateLaterThan(pageConfig.fullMembers[i]["registDate"], yearTo, monthTo, dayTo)) {
                document.getElementById("fullMember_" + i).style.display = "none";
                document.getElementById("fullUserCheck_" + i).checked = false;
                pass = false;
            }
            if (pass) {
                document.getElementById("fullMember_" + i).style.display = "";
                document.getElementById("fullUserCheck_" + i).checked = true;
            }
        }
    }
    
    document.getElementById("fullDateClear").onclick = function() {
        
        document.getElementById("fullYear").value = "",
        document.getElementById("fullMonth").value = "",
        document.getElementById("fullDay").value = "";
        
        document.getElementById("fullYearTo").value = "",
        document.getElementById("fullMonthTo").value = "",
        document.getElementById("fullDayTo").value = "";
        
        // filter post/comments member list.
        for (var i in pageConfig.fullMembers) {
            document.getElementById("fullMember_" + i).style.display = "";
            document.getElementById("fullUserCheck_" + i).checked = true;
        }
    }
    
    document.getElementById("catSelect").onchange = function(e) {
        
        // filter post/comments member list.
        if (!+this.value) {
            // default value, show all
            for (var i in pageConfig.pcMembers) {
                document.getElementById("pcMember_" + i).style.display = "";
                document.getElementById("pcUserCheck_" + i).checked = true;
            }
        } else {
            var userId;
            
            // hide all first.
            for (var i in pageConfig.pcMembers) {
                document.getElementById("pcMember_" + i).style.display = "none";
                document.getElementById("pcUserCheck_" + i).checked = false;
            }
            
            for (var i in pageConfig.categories[+this.value].members) {
                userId = pageConfig.categories[+this.value].members[i];
                if (!document.getElementById("pcMember_" + userId)) continue;
                document.getElementById("pcMember_" + userId).style.display = "";
                document.getElementById("pcUserCheck_" + userId).checked = true;
            }
        }
    }
    
    document.getElementById("wheelAddNewBtn").onclick = function() {
       
        var name = document.getElementById("wheelAddNew").value
                .replace(/\W/g, ""),
            fail = false;
        if (!name) {
            document.getElementById("wheelAddInfo").innerHTML = "<?php echo __("Name can't be blank.", "wheel-of-fortune"); ?>";
            fail = true;
        }
        if (pageConfig["wheelList"][name]) {
            document.getElementById("wheelAddInfo").innerHTML = "<?php echo __("The name is used already. Note that spaces or other symbols would be removed from the wheel name.", "wheel-of-fortune"); ?>";
            fail = true;
        }
        if (fail) {
            setTimeout(function() {
                document.getElementById("wheelAddInfo").innerHTML = "";
            }, 3000);
            return;
        }
        
        // passed, do the redirection.
        window.location = (window.location + "").replace(/&name=\w+/ig, "").replace(/&delete=\w+/ig, "") + "&name=" + name;
    }
    
    document.getElementById("wheelAddGoBtn").onclick = function() {
    
        window.location = (window.location + "").replace(/&name=\w+/ig, "").replace(/&delete=\w+/ig, "") + "&name=" + document.getElementById("wheelSelect").value;
    }
    
    document.getElementById("wheelAddDltBtn").onclick = function() {
        
        var confirmText = "<?php echo __("Do you really want to remove the wheel: ", "wheel-of-fortune"); ?>"
            + "\"" + document.getElementById("wheelSelect").value + "\"?\n"
            + "<?php echo __("It can't be find back once removed.", "wheel-of-fortune"); ?>"
        if (confirm(confirmText)) 
            window.location = (window.location + "").replace(/&name=\w+/ig, "").replace(/&delete=\w+/ig, "") + "&name=" + document.getElementById("wheelSelect").value + "&delete=1";
    }
    
    document.getElementById("wheelSelect").onchange = function() {
    
        if (this.value != pageConfig.wheelName) document.getElementById("wheelAddGoBtn").style.display = "";
        else document.getElementById("wheelAddGoBtn").style.display = "none";
        
        if (this.value != "Default") document.getElementById("wheelAddDltBtn").style.display = "";
        else document.getElementById("wheelAddDltBtn").style.display = "none";
    }
    
})();
</script>