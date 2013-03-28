<?php
/**
 * Contains a Yii widget for EyeDraw
 * @package OphCiGlaucomaexamination
 * @author Richard Meeking <richard@plus10tech.co.uk>
 * @version 0.1
 * @copyright Copyright (c) 2012 OpenEyes Foundation
 * @copyright Copyright (c) 2012 Cardiff University
 * @license http://www.yiiframework.com/license/
 * 
 * This file is part of OpenEyes.
 * 
 * OpenEyes is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * OpenEyes is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with OpenEyes.  If not, see <http://www.gnu.org/licenses/>.
 */
//include 'OEEyeDrawWidgetGlaucoma.php';
?>
<script type="text/javascript">
    
    // Level
    var isBasic = true;
                           
    // Runs on page load
    function init()
    {
        // Initial level setting
        changeGonioscopyLevel('Basic', 'right');
        changeGonioscopyLevel('Basic', 'left');
    }
               
    function popupSelect(_value, _id, _div)
    {
        var select = document.getElementById(_id);
        select.value = _value;
        hidePop(_div);
    }
        
    function showPop(id)
    {
        if (document.getElementById(id) != null) {
            document.getElementById(id).style.visibility = "visible";
            document.getElementById(id).style.display = "inline";
        }
    }
		
    function hidePop(id)
    {
        document.getElementById(id).style.visibility = "hidden";
        document.getElementById(id).style.display = "none";
    }
		
    function changeGonioscopyLevel(_value, _side)
    {
        if (document.getElementById(_value) == null) {
            return;
        }
        // Set flag indicating level
        if (_value == 'Basic') {
            isBasic = true;
        }
        else {
            isBasic = false;
        }
			
        // Basic level
        if (isBasic) {
            document.getElementById("foster_images_" + _side).style.display = "none";	
            document.getElementById("van_herick_" + _side).style.display = "none";
        }
        // Expert level
        else {
            document.getElementById("foster_images_" + _side).style.display = "inline";	
            document.getElementById("van_herick_" + _side).style.display = "inline";								
        }
    }

    function setGrade(id, sel) {
        var doodles = id.doodleArray;
        for (var i=0; i < doodles.length; i++) {
            id.selectedDoodle = doodles[i];
            if (id.selectedDoodle.className == 'AngleGrade') {
                id.setParameterForDoodle(
                id.selectedDoodle, 'grade-schaffer', sel.options[sel.selectedIndex].text);
            }
        }
    }
    
</script>
<body onload="init();" /> 
<div data-side="<?php echo $side ?>">
    <input type="hidden" id="<?php echo $inputId ?>" name="<?php echo $inputName ?>" value='<?php echo $this->model[$this->attribute] ?>' />
    <?php if ($isEditable && $toolbar) { ?>
        <div style="float: left">
            <div class="ed_toolbar">
                <button class="ed_img_button" disabled="disabled" id="moveToFront<?php echo $idSuffix ?>" title="Move to front" onclick="<?php echo $drawingName ?>.moveToFront(); return false;">
                    <img src="<?php echo $imgPath ?>moveToFront.gif" />
                </button>
                <button class="ed_img_button" disabled="disabled" id="moveToBack<?php echo $idSuffix ?>" title="Move to back" onclick="<?php echo $drawingName ?>.moveToBack(); return false;">
                    <img src="<?php echo $imgPath ?>moveToBack.gif" />
                </button>
                <button class="ed_img_button" disabled="disabled" id="deleteDoodle<?php echo $idSuffix ?>" title="Delete" onclick="<?php echo $drawingName ?>.deleteDoodle(); return false;">
                    <img src="<?php echo $imgPath ?>deleteDoodle.gif" />
                </button>
                <button class="ed_img_button" disabled="disabled" id="lock<?php echo $idSuffix ?>" title="Lock" onclick="<?php echo $drawingName ?>.lock(); return false;">
                    <img src="<?php echo $imgPath ?>lock.gif" />
                </button>
                <button class="ed_img_button" id="unlock<?php echo $idSuffix ?>" title="Unlock" onclick="<?php echo $drawingName ?>.unlock(); return false;">
                    <img src="<?php echo $imgPath ?>unlock.gif" />
                </button>
            </div>
            <div class="ed_toolbar">
                <?php foreach ($doodleToolBarArray as $i => $item) { ?>
                    <button class="ed_img_button" id="<?php echo $item['classname'] . $idSuffix ?>" title="<?php echo $item['title'] ?>" onclick="<?php echo $drawingName ?>.addDoodle('<?php echo $item['classname'] ?>'); return false;">
                        <img src="<?php echo $imgPath . $item['classname'] ?>.gif" />
                    </button>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <canvas id="<?php echo $canvasId?>" class="<?php if ($isEditable) { echo 'edit'; } else { echo 'display'; }?>" width="<?php echo $size?>" height="<?php echo $size?>" tabindex="1"<?php if ($canvasStyle) {?> style="<?php echo $canvasStyle?>"<?php }?>></canvas>
                    <?php if ($isEditable) { ?>
        <div class="eyedrawFields">
            <div>
                    <div class="label">
    <?php echo 'Level' ?>:
                    </div>
                    <div class="data">
                        <select style="width: auto; margin-bottom:5px;" onchange="changeGonioscopyLevel(this.value, '<?php echo $side ?>');">
                            <option>Basic</option>
                            <option>Expert</option>
                        </select>
                    </div>
                </div>
                <div class="aligned" id="van_herick_<?php echo $inputId ?>">
                    <div class="label">
    <?php echo $model->getAttributeLabel('van_herick_' . $side); ?>:
                    </div>
                    <div class="data">
    <?php echo CHtml::activeDropDownList($model, 'van_herick_' . $side, $model->getVanHerickOptions()) ?>
                    </div>
                </div>
                <div class="aligned"  id="foster_images_<?php echo $side ?>">
                    <div class="label">
                        <a href="javascript:void(0);" title="" onClick="showPop('vanHerickPNG<?php echo ucfirst($side) ?>')">Foster images</a>
                    </div>
                    <?php
                    $path = YiiBase::getPathOfAlias('application.modules.OphCiExamination.assets');
                    $assetUrl = Yii::app()->assetManager->publish($path);
                    $modelName = $model->elementType->class_name;
                    ?>
                    <div style="display:none; z-index:100; position:absolute; margin-top: -200px" id='<?php echo 'vanHerickPNG' . ucfirst($side) ?>' class="popup" title="Click an area of image to select result">
                        <img usemap="#pickmapL" width=450 src="<?php echo $assetUrl ?>/img/gonioscopy.png">
                        <map name="pickmapL">
                            <area style="cursor:pointer" shape="rect" coords="0,0,225,225" onclick="popupSelect(5, '<?php echo $modelName ?>_van_herick_<?php echo $side ?>', 'vanHerickPNG<?php echo ucfirst($side) ?>');" />
                            <area style="cursor:pointer" shape="rect" coords="0,225,225,450" onclick="popupSelect(15, '<?php echo $modelName ?>_van_herick_<?php echo $side ?>', 'vanHerickPNG<?php echo ucfirst($side) ?>');" />
                            <area style="cursor:pointer" shape="rect" coords="0,450,225,675" onclick="popupSelect(25, '<?php echo $modelName ?>_van_herick_<?php echo $side ?>', 'vanHerickPNG<?php echo ucfirst($side) ?>');" />
                            <area style="cursor:pointer" shape="rect" coords="225,0,450,225" onclick="popupSelect(30, '<?php echo $modelName ?>_van_herick_<?php echo $side ?>', 'vanHerickPNG<?php echo ucfirst($side) ?>');" />
                            <area style="cursor:pointer" shape="rect" coords="225,225,450,450" onclick="popupSelect(75, '<?php echo $modelName ?>_van_herick_<?php echo $side ?>', 'vanHerickPNG<?php echo ucfirst($side) ?>');" />
                            <area style="cursor:pointer" shape="rect" coords="225,450,450,675" onclick="popupSelect(100, '<?php echo $modelName ?>_van_herick_<?php echo $side ?>', 'vanHerickPNG<?php echo ucfirst($side) ?>');" />						                    	</map>
                    </div>	
                </div>

                <div class="aligned">
                    <div class="label">
    <?php echo $model->getAttributeLabel('gonio_' . $side); ?>:
                    </div>
                    <div class="data">
                    <?php echo CHtml::activeDropDownList($model, 'gonio_' . $side, $model->getGonioscopyOptions(), array('onchange' => 'setGrade(ed_drawing_edit_' . $side . '_' . $model->elementType->id . ', this)')) ?>
                    </div>
                </div>

                <div class="label">
    <?php echo $model->getAttributeLabel($side . '_description'); ?>:
                </div>
                <div class="data">
            <?php echo CHtml::activeTextArea($model, $side . '_description', array('rows' => "2", 'cols' => "20", 'class' => 'autosize')) ?>
                </div>
                <button class="ed_report">Report</button>
                <button class="ed_clear">Clear</button>
            </div>
                    <?php } else { ?>
            <div class="eyedrawFields view">
    <?php if ($description = $model->{$side . '_description'}) { ?>
                    <div>
                        <div class="data">
                <?php echo $description ?>
                        </div>
                    </div>
    <?php } ?>
            </div>
<?php } ?>
    </div>