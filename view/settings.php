<?php
/**
 * Created by Itach-soft.
 */
$gateid='1';
//var_export($_REQUEST);
if ($action=='savegatesettings')
{
    //    echo _("Settings saved");
    $res=smsgate_editsettings($request);
    needreload();
    $smsgatesettings=smsgate_getsettings($gateid);
  //  var_export($res);

}
else {
    $smsgatesettings = smsgate_getsettings($gateid);
    extract($smsgatesettings);

}

?>
<div class="display">
    <div class="row">
        <div class="col-sm-12">
            <div class="fpbx-container">
                <div class="display full-border">
                    <form autocomplete="off" class="fpbx-submit" name="group"
                          action="?display=smsgate&amp;view=settings" method="post"
                          data-fpbx-delete="?display=smsgate&amp;delete=true&amp;action=settings&amp;edit=1">
                        <input type="hidden" name="action" value="savegatesettings">
                        <input type="hidden" name="gateid" value="<?php echo $gateid; ?>">
                        <input type="hidden" name="gatebrand" value="dinstar">


                        <!--Gate IP-->
                        <div class="element-container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label" for="client_id"><?php echo(_("Gate ip or dns name")); ?></label>
                                                <i class="fa fa-question-circle fpbx-help-icon"
                                                   data-for="gateip"></i>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="gateip" name="gateip"  value="<?php echo $gateip; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span id="gateip-help" class="help-block fpbx-help-block"><?php echo(_("Enter Gate IP-address or full dns name"));?></span>
                                </div>
                            </div>
                        </div>
                        <!--END Gate IP-->
                        <!--Gate API port-->
                        <div class="element-container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label" for="client_id"><?php echo(_("Gate api port")); ?></label>
                                                <i class="fa fa-question-circle fpbx-help-icon"
                                                   data-for="gateapiport"></i>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" id="gateapiport" name="gateapiport" value="<?php echo $gateapiport; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span id="gateapiport-help" class="help-block fpbx-help-block"><?php echo(_("Enter gate API port to connect"));?></span>
                                </div>
                            </div>
                        </div>
                        <!--END API port-->
                        <!--Gate Username-->
                        <div class="element-container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label" for="gateusername"><?php echo(_("Gate API username")); ?></label>
                                                <i class="fa fa-question-circle fpbx-help-icon"
                                                   data-for="gateusername"></i>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="gateusername" name="gateusername"  value="<?php echo $gateusername; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span id="gateusername-help" class="help-block fpbx-help-block"><?php echo(_("Enter API Gate username"));?></span>
                                </div>
                            </div>
                        </div>
                        <!--END Gate Usrename-->
                        <!--Gate Password-->
                        <div class="element-container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label" for="gatepassword"><?php echo(_("Gate API password")); ?></label>
                                                <i class="fa fa-question-circle fpbx-help-icon"
                                                   data-for="gatepassword"></i>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="gatepassword" name="gatepassword"  value="<?php echo $gatepassword; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span id="gatepassword-help" class="help-block fpbx-help-block"><?php echo(_("Enter Gate API password"));?></span>
                                </div>
                            </div>
                        </div>
                        <!--END Gate Password-->
                        <!--Gate ports-->
                        <div class="element-container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label" for="gateports"><?php echo(_("Gate number of ports")); ?></label>
                                                <i class="fa fa-question-circle fpbx-help-icon"
                                                   data-for="gateports"></i>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" id="gateports" name="gateports" value="<?php echo $gateports; ?>">                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span id="gateports-help" class="help-block fpbx-help-block"><?php echo(_("Enter how many ports have gate"));?></span>
                                </div>
                            </div>
                        </div>
                        <!--END Gate Password-->
                        <br> <input type="submit" name="submit" value="<?php echo(_("Add/Edit Settings"));?>">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>