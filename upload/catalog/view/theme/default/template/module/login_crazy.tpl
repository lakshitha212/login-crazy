<div id="modal-logincrazy" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title main-heading"><?php echo $text_signin_register ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6" id="quick-login">
                        <h4 class="modal-title"><?php echo $text_returning ?></h4>
                        <span><?php echo $text_returning_customer ?></span>

                        <div class="form-group required">
                            <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                            <input type="text" name="email" value="" id="input-email" class="form-control"/>
                        </div>
                        <div class="form-group required">
                            <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
                            <input type="password" name="password" value="" id="input-password" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary loginaccount"
                                    data-loading-text="<?php echo $text_loading; ?>"><?php echo $button_login ?></button>
                            <a href="<?php echo $register; ?>"><?php echo $button_register; ?></a>
                        </div>
                        <div class="form-group">
                            <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h2>social</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
