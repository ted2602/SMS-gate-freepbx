<?php
/**
 * Created by Itach-soft.
 */
echo('<h1> </h1>');
$smsgatesettings = smsgate_getsettings();

foreach ($smsgatesettings as $gates) {
    $gateid = $gates['gateid'];
    echo("<a href=\"?display=smsgate&view=sendussd&gateid=$gateid\" class=\"btn btn-default\"></i>&nbsp;" . _("Gate") . " $gateid</a> ");
}
//выводим форму отправки
isset($request['view']) ? $view = $request['view'] : $view = '';
$gateid = $request['gateid'];
isset($request['action']) ? $action = $request['action'] : $action = '';

if (isset($request['gateid'])) {
    if ($action == 'sendussd') {
        $sendstatus=smsgate_sendussd($request['gateid'],$request['gateport'],$request['number']);
        echo ("<h3>");
        echo (_("USSD from Gate")." ".$gateid." "._("send")."."._("Answer:").$sendstatus);
        echo ("</h3>");

    }
        $smsgatesettings = smsgate_getsettings($gateid);
        $gateports = $smsgatesettings['gateports'];
 //       var_export($smsgatesettings);
        ?>
        <h1><?php echo(_("Send USSD from Gate ") . $gateid); ?></h1>
        <div class="display">
            <div class="row">
                <div class="col-sm-12">
                    <div class="fpbx-container">
                        <div class="display full-border">
                            <form autocomplete="off" class="fpbx-submit" name="group"
                                  action="?display=smsgate&amp;view=sendussd" method="post"
                                  data-fpbx-delete="?display=smsgate&amp;delete=true&amp;action=sendussd&amp;edit=1">
                                <input type="hidden" name="action" value="sendussd">
                                <input type="hidden" name="gateid" value="<?php echo $gateid; ?>">
                                <!--Number USSD-->
                                <div class="element-container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-3">
                                                        <label class="control-label"
                                                               for="number"><?php echo(_("Enter ussd number")); ?></label>
                                                        <i class="fa fa-question-circle fpbx-help-icon"
                                                           data-for="number"></i>
                                                      </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="number"
                                                               name="number"
                                                               value="80">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <span id="number-help"
                                              class="help-block fpbx-help-block"><?php echo(_("Enter ussd number")); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <!--END Number USSD-->


                                <!--Port SMS-->
                                <div class="element-container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-3">
                                                        <label class="control-label"
                                                               for="gateport"><?php echo(_("Choose gate port")); ?></label>
                                                        <i class="fa fa-question-circle fpbx-help-icon"
                                                           data-for="gateport"></i>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control" id="gateport" name="gateport">
                                                            <?php

                                                            for ($i = 1; $i <= $gateports; $i++) {
                                                                echo("
                                                        <option value=\"$i\">" . _("Port") . " $i</option>
                                                                    ");

                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <span id="gateport-help"
                                              class="help-block fpbx-help-block"><?php echo(_("Choose gate port")); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <!--Port TEXT SMS-->
                                <br> <input type="submit" name="button" value="<?php echo(_("Send USSD")); ?>">


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php

}

