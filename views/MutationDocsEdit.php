<?php

namespace PHPMaker2021\simrs;

// Page object
$MutationDocsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fMUTATION_DOCSedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fMUTATION_DOCSedit = currentForm = new ew.Form("fMUTATION_DOCSedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "MUTATION_DOCS")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.MUTATION_DOCS)
        ew.vars.tables.MUTATION_DOCS = currentTable;
    fMUTATION_DOCSedit.addFields([
        ["DOC_NO", [fields.DOC_NO.visible && fields.DOC_NO.required ? ew.Validators.required(fields.DOC_NO.caption) : null], fields.DOC_NO.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["CLINIC_ID_TO", [fields.CLINIC_ID_TO.visible && fields.CLINIC_ID_TO.required ? ew.Validators.required(fields.CLINIC_ID_TO.caption) : null], fields.CLINIC_ID_TO.isInvalid],
        ["MUTATION_DATE", [fields.MUTATION_DATE.visible && fields.MUTATION_DATE.required ? ew.Validators.required(fields.MUTATION_DATE.caption) : null], fields.MUTATION_DATE.isInvalid],
        ["ORDER_VALUE", [fields.ORDER_VALUE.visible && fields.ORDER_VALUE.required ? ew.Validators.required(fields.ORDER_VALUE.caption) : null], fields.ORDER_VALUE.isInvalid],
        ["MUTATION_VALUE", [fields.MUTATION_VALUE.visible && fields.MUTATION_VALUE.required ? ew.Validators.required(fields.MUTATION_VALUE.caption) : null], fields.MUTATION_VALUE.isInvalid],
        ["RECEIVED_BY", [fields.RECEIVED_BY.visible && fields.RECEIVED_BY.required ? ew.Validators.required(fields.RECEIVED_BY.caption) : null], fields.RECEIVED_BY.isInvalid],
        ["DISTRIBUTION_TYPE", [fields.DISTRIBUTION_TYPE.visible && fields.DISTRIBUTION_TYPE.required ? ew.Validators.required(fields.DISTRIBUTION_TYPE.caption) : null], fields.DISTRIBUTION_TYPE.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fMUTATION_DOCSedit,
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
    fMUTATION_DOCSedit.validate = function () {
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
    fMUTATION_DOCSedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fMUTATION_DOCSedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fMUTATION_DOCSedit");
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
<form name="fMUTATION_DOCSedit" id="fMUTATION_DOCSedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="MUTATION_DOCS">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
    <div id="r_DOC_NO" class="form-group row">
        <label id="elh_MUTATION_DOCS_DOC_NO" for="x_DOC_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DOC_NO->caption() ?><?= $Page->DOC_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOC_NO->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_DOC_NO">
<span<?= $Page->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->DOC_NO->getDisplayValue($Page->DOC_NO->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="MUTATION_DOCS" data-field="x_DOC_NO" data-hidden="1" name="x_DOC_NO" id="x_DOC_NO" value="<?= HtmlEncode($Page->DOC_NO->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_MUTATION_DOCS_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CLINIC_ID->getDisplayValue($Page->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="MUTATION_DOCS" data-field="x_CLINIC_ID" data-hidden="1" name="x_CLINIC_ID" id="x_CLINIC_ID" value="<?= HtmlEncode($Page->CLINIC_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID_TO->Visible) { // CLINIC_ID_TO ?>
    <div id="r_CLINIC_ID_TO" class="form-group row">
        <label id="elh_MUTATION_DOCS_CLINIC_ID_TO" for="x_CLINIC_ID_TO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID_TO->caption() ?><?= $Page->CLINIC_ID_TO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID_TO->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_CLINIC_ID_TO">
<span<?= $Page->CLINIC_ID_TO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CLINIC_ID_TO->getDisplayValue($Page->CLINIC_ID_TO->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="MUTATION_DOCS" data-field="x_CLINIC_ID_TO" data-hidden="1" name="x_CLINIC_ID_TO" id="x_CLINIC_ID_TO" value="<?= HtmlEncode($Page->CLINIC_ID_TO->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MUTATION_DATE->Visible) { // MUTATION_DATE ?>
    <div id="r_MUTATION_DATE" class="form-group row">
        <label id="elh_MUTATION_DOCS_MUTATION_DATE" for="x_MUTATION_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MUTATION_DATE->caption() ?><?= $Page->MUTATION_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MUTATION_DATE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_MUTATION_DATE">
<span<?= $Page->MUTATION_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->MUTATION_DATE->getDisplayValue($Page->MUTATION_DATE->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="MUTATION_DOCS" data-field="x_MUTATION_DATE" data-hidden="1" name="x_MUTATION_DATE" id="x_MUTATION_DATE" value="<?= HtmlEncode($Page->MUTATION_DATE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORDER_VALUE->Visible) { // ORDER_VALUE ?>
    <div id="r_ORDER_VALUE" class="form-group row">
        <label id="elh_MUTATION_DOCS_ORDER_VALUE" for="x_ORDER_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORDER_VALUE->caption() ?><?= $Page->ORDER_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORDER_VALUE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_ORDER_VALUE">
<span<?= $Page->ORDER_VALUE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ORDER_VALUE->getDisplayValue($Page->ORDER_VALUE->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="MUTATION_DOCS" data-field="x_ORDER_VALUE" data-hidden="1" name="x_ORDER_VALUE" id="x_ORDER_VALUE" value="<?= HtmlEncode($Page->ORDER_VALUE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MUTATION_VALUE->Visible) { // MUTATION_VALUE ?>
    <div id="r_MUTATION_VALUE" class="form-group row">
        <label id="elh_MUTATION_DOCS_MUTATION_VALUE" for="x_MUTATION_VALUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MUTATION_VALUE->caption() ?><?= $Page->MUTATION_VALUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MUTATION_VALUE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_MUTATION_VALUE">
<span<?= $Page->MUTATION_VALUE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->MUTATION_VALUE->getDisplayValue($Page->MUTATION_VALUE->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="MUTATION_DOCS" data-field="x_MUTATION_VALUE" data-hidden="1" name="x_MUTATION_VALUE" id="x_MUTATION_VALUE" value="<?= HtmlEncode($Page->MUTATION_VALUE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RECEIVED_BY->Visible) { // RECEIVED_BY ?>
    <div id="r_RECEIVED_BY" class="form-group row">
        <label id="elh_MUTATION_DOCS_RECEIVED_BY" for="x_RECEIVED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RECEIVED_BY->caption() ?><?= $Page->RECEIVED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RECEIVED_BY->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_RECEIVED_BY">
<span<?= $Page->RECEIVED_BY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->RECEIVED_BY->getDisplayValue($Page->RECEIVED_BY->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="MUTATION_DOCS" data-field="x_RECEIVED_BY" data-hidden="1" name="x_RECEIVED_BY" id="x_RECEIVED_BY" value="<?= HtmlEncode($Page->RECEIVED_BY->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
    <div id="r_DISTRIBUTION_TYPE" class="form-group row">
        <label id="elh_MUTATION_DOCS_DISTRIBUTION_TYPE" for="x_DISTRIBUTION_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISTRIBUTION_TYPE->caption() ?><?= $Page->DISTRIBUTION_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_DISTRIBUTION_TYPE">
<span<?= $Page->DISTRIBUTION_TYPE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->DISTRIBUTION_TYPE->getDisplayValue($Page->DISTRIBUTION_TYPE->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="MUTATION_DOCS" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="x_DISTRIBUTION_TYPE" id="x_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Page->DISTRIBUTION_TYPE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="MUTATION_DOCS" data-field="x_ID" data-hidden="1" name="x_ID" id="x_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
<?php
    if (in_array("GOOD_GF", explode(",", $Page->getCurrentDetailTable())) && $GOOD_GF->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("GOOD_GF", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "GoodGfGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("MUTATION_DOCS");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
