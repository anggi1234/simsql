<?php

namespace PHPMaker2021\simrs;

// Page object
$UserlevelpermissionAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fuserlevelpermissionadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fuserlevelpermissionadd = currentForm = new ew.Form("fuserlevelpermissionadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "userlevelpermission")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.userlevelpermission)
        ew.vars.tables.userlevelpermission = currentTable;
    fuserlevelpermissionadd.addFields([
        ["UserLevelID", [fields.UserLevelID.visible && fields.UserLevelID.required ? ew.Validators.required(fields.UserLevelID.caption) : null, ew.Validators.integer], fields.UserLevelID.isInvalid],
        ["_TableName", [fields._TableName.visible && fields._TableName.required ? ew.Validators.required(fields._TableName.caption) : null], fields._TableName.isInvalid],
        ["_Permission", [fields._Permission.visible && fields._Permission.required ? ew.Validators.required(fields._Permission.caption) : null, ew.Validators.integer], fields._Permission.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fuserlevelpermissionadd,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fuserlevelpermissionadd.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fuserlevelpermissionadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuserlevelpermissionadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fuserlevelpermissionadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fuserlevelpermissionadd" id="fuserlevelpermissionadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevelpermission">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->UserLevelID->Visible) { // UserLevelID ?>
    <div id="r_UserLevelID" class="form-group row">
        <label id="elh_userlevelpermission_UserLevelID" for="x_UserLevelID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UserLevelID->caption() ?><?= $Page->UserLevelID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->UserLevelID->cellAttributes() ?>>
<span id="el_userlevelpermission_UserLevelID">
<input type="<?= $Page->UserLevelID->getInputTextType() ?>" data-table="userlevelpermission" data-field="x_UserLevelID" name="x_UserLevelID" id="x_UserLevelID" size="30" placeholder="<?= HtmlEncode($Page->UserLevelID->getPlaceHolder()) ?>" value="<?= $Page->UserLevelID->EditValue ?>"<?= $Page->UserLevelID->editAttributes() ?> aria-describedby="x_UserLevelID_help">
<?= $Page->UserLevelID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UserLevelID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_TableName->Visible) { // TableName ?>
    <div id="r__TableName" class="form-group row">
        <label id="elh_userlevelpermission__TableName" for="x__TableName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_TableName->caption() ?><?= $Page->_TableName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_TableName->cellAttributes() ?>>
<span id="el_userlevelpermission__TableName">
<input type="<?= $Page->_TableName->getInputTextType() ?>" data-table="userlevelpermission" data-field="x__TableName" name="x__TableName" id="x__TableName" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_TableName->getPlaceHolder()) ?>" value="<?= $Page->_TableName->EditValue ?>"<?= $Page->_TableName->editAttributes() ?> aria-describedby="x__TableName_help">
<?= $Page->_TableName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_TableName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Permission->Visible) { // Permission ?>
    <div id="r__Permission" class="form-group row">
        <label id="elh_userlevelpermission__Permission" for="x__Permission" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Permission->caption() ?><?= $Page->_Permission->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_Permission->cellAttributes() ?>>
<span id="el_userlevelpermission__Permission">
<input type="<?= $Page->_Permission->getInputTextType() ?>" data-table="userlevelpermission" data-field="x__Permission" name="x__Permission" id="x__Permission" size="30" placeholder="<?= HtmlEncode($Page->_Permission->getPlaceHolder()) ?>" value="<?= $Page->_Permission->EditValue ?>"<?= $Page->_Permission->editAttributes() ?> aria-describedby="x__Permission_help">
<?= $Page->_Permission->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Permission->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("userlevelpermission");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
