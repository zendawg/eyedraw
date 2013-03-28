
<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<script type="text/javascript">
    
		
    function changeLevel(ed_drawing, _value)
    {
        var doodle = ed_drawing.firstDoodleOfClass('OpticDisk');
        doodle.isBasic = (_value);
        doodle.toggleMode();
        doodle.setHandleProperties();
        ed_drawing.repaint();
    }
</script>
<!-- Uncomment following line to re-enable doodle hover tooltips once layer bug is fixed (OE-1583) -->
<!-- <span id="canvasTooltip"></span> -->
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
    <?php echo $model->getAttributeLabel($side . '_description'); ?>:
                </div>
                <div class="data">
                    <?php echo CHtml::activeTextArea($model, $side . '_description', array('rows' => "2", 'cols' => "20", 'class' => 'autosize')) ?>
                </div>
            </div>
            <div>
                <div class="label">
    <?php echo "Toggle Mode"; ?>
                </div>
                <div class="data">
                    <input id="checkbox1" type="checkbox" name="checkgroup" onclick="changeLevel(<?php echo $drawingName ?>, this.checked);"></input>
                </div>
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


<script type="text/javascript">
    /*
     * TODO figure out how to remove the 'Unit:' label vua tge dropDownList...
     */
    //    var node = document.getElementById('div_ElementOpticDisk_description_right');
    //    node.removeChild(node.childNodes[1]);
    //    var node = document.getElementById('div_ElementOpticDisk_description_left');
    //    node.removeChild(node.childNodes[1]);
</script>
