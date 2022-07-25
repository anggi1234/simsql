<?php

namespace PHPMaker2021\simrs;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // ANTE_NATAL
    $app->any('/AnteNatalList[/{ANTE_NATAL}]', AnteNatalController::class . ':list')->add(PermissionMiddleware::class)->setName('AnteNatalList-ANTE_NATAL-list'); // list
    $app->any('/AnteNatalAdd[/{ANTE_NATAL}]', AnteNatalController::class . ':add')->add(PermissionMiddleware::class)->setName('AnteNatalAdd-ANTE_NATAL-add'); // add
    $app->any('/AnteNatalView[/{ANTE_NATAL}]', AnteNatalController::class . ':view')->add(PermissionMiddleware::class)->setName('AnteNatalView-ANTE_NATAL-view'); // view
    $app->any('/AnteNatalEdit[/{ANTE_NATAL}]', AnteNatalController::class . ':edit')->add(PermissionMiddleware::class)->setName('AnteNatalEdit-ANTE_NATAL-edit'); // edit
    $app->any('/AnteNatalDelete[/{ANTE_NATAL}]', AnteNatalController::class . ':delete')->add(PermissionMiddleware::class)->setName('AnteNatalDelete-ANTE_NATAL-delete'); // delete
    $app->group(
        '/ANTE_NATAL',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ANTE_NATAL}]', AnteNatalController::class . ':list')->add(PermissionMiddleware::class)->setName('ANTE_NATAL/list-ANTE_NATAL-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ANTE_NATAL}]', AnteNatalController::class . ':add')->add(PermissionMiddleware::class)->setName('ANTE_NATAL/add-ANTE_NATAL-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ANTE_NATAL}]', AnteNatalController::class . ':view')->add(PermissionMiddleware::class)->setName('ANTE_NATAL/view-ANTE_NATAL-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ANTE_NATAL}]', AnteNatalController::class . ':edit')->add(PermissionMiddleware::class)->setName('ANTE_NATAL/edit-ANTE_NATAL-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ANTE_NATAL}]', AnteNatalController::class . ':delete')->add(PermissionMiddleware::class)->setName('ANTE_NATAL/delete-ANTE_NATAL-delete-2'); // delete
        }
    );

    // ANTRIAN_FARMASI
    $app->any('/AntrianFarmasiList[/{Id}]', AntrianFarmasiController::class . ':list')->add(PermissionMiddleware::class)->setName('AntrianFarmasiList-ANTRIAN_FARMASI-list'); // list
    $app->any('/AntrianFarmasiAdd[/{Id}]', AntrianFarmasiController::class . ':add')->add(PermissionMiddleware::class)->setName('AntrianFarmasiAdd-ANTRIAN_FARMASI-add'); // add
    $app->any('/AntrianFarmasiView[/{Id}]', AntrianFarmasiController::class . ':view')->add(PermissionMiddleware::class)->setName('AntrianFarmasiView-ANTRIAN_FARMASI-view'); // view
    $app->any('/AntrianFarmasiEdit[/{Id}]', AntrianFarmasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('AntrianFarmasiEdit-ANTRIAN_FARMASI-edit'); // edit
    $app->any('/AntrianFarmasiDelete[/{Id}]', AntrianFarmasiController::class . ':delete')->add(PermissionMiddleware::class)->setName('AntrianFarmasiDelete-ANTRIAN_FARMASI-delete'); // delete
    $app->group(
        '/ANTRIAN_FARMASI',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{Id}]', AntrianFarmasiController::class . ':list')->add(PermissionMiddleware::class)->setName('ANTRIAN_FARMASI/list-ANTRIAN_FARMASI-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{Id}]', AntrianFarmasiController::class . ':add')->add(PermissionMiddleware::class)->setName('ANTRIAN_FARMASI/add-ANTRIAN_FARMASI-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{Id}]', AntrianFarmasiController::class . ':view')->add(PermissionMiddleware::class)->setName('ANTRIAN_FARMASI/view-ANTRIAN_FARMASI-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{Id}]', AntrianFarmasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('ANTRIAN_FARMASI/edit-ANTRIAN_FARMASI-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{Id}]', AntrianFarmasiController::class . ':delete')->add(PermissionMiddleware::class)->setName('ANTRIAN_FARMASI/delete-ANTRIAN_FARMASI-delete-2'); // delete
        }
    );

    // ANTRIAN_LOGIN
    $app->any('/AntrianLoginList[/{ID}]', AntrianLoginController::class . ':list')->add(PermissionMiddleware::class)->setName('AntrianLoginList-ANTRIAN_LOGIN-list'); // list
    $app->any('/AntrianLoginAdd[/{ID}]', AntrianLoginController::class . ':add')->add(PermissionMiddleware::class)->setName('AntrianLoginAdd-ANTRIAN_LOGIN-add'); // add
    $app->any('/AntrianLoginView[/{ID}]', AntrianLoginController::class . ':view')->add(PermissionMiddleware::class)->setName('AntrianLoginView-ANTRIAN_LOGIN-view'); // view
    $app->any('/AntrianLoginEdit[/{ID}]', AntrianLoginController::class . ':edit')->add(PermissionMiddleware::class)->setName('AntrianLoginEdit-ANTRIAN_LOGIN-edit'); // edit
    $app->any('/AntrianLoginDelete[/{ID}]', AntrianLoginController::class . ':delete')->add(PermissionMiddleware::class)->setName('AntrianLoginDelete-ANTRIAN_LOGIN-delete'); // delete
    $app->group(
        '/ANTRIAN_LOGIN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', AntrianLoginController::class . ':list')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/list-ANTRIAN_LOGIN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', AntrianLoginController::class . ':add')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/add-ANTRIAN_LOGIN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', AntrianLoginController::class . ':view')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/view-ANTRIAN_LOGIN-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', AntrianLoginController::class . ':edit')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/edit-ANTRIAN_LOGIN-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', AntrianLoginController::class . ':delete')->add(PermissionMiddleware::class)->setName('ANTRIAN_LOGIN/delete-ANTRIAN_LOGIN-delete-2'); // delete
        }
    );

    // ANTRIAN_PENDAFTARAN
    $app->any('/AntrianPendaftaranList[/{Id}]', AntrianPendaftaranController::class . ':list')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranList-ANTRIAN_PENDAFTARAN-list'); // list
    $app->any('/AntrianPendaftaranAdd[/{Id}]', AntrianPendaftaranController::class . ':add')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranAdd-ANTRIAN_PENDAFTARAN-add'); // add
    $app->any('/AntrianPendaftaranView[/{Id}]', AntrianPendaftaranController::class . ':view')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranView-ANTRIAN_PENDAFTARAN-view'); // view
    $app->any('/AntrianPendaftaranEdit[/{Id}]', AntrianPendaftaranController::class . ':edit')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranEdit-ANTRIAN_PENDAFTARAN-edit'); // edit
    $app->any('/AntrianPendaftaranDelete[/{Id}]', AntrianPendaftaranController::class . ':delete')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranDelete-ANTRIAN_PENDAFTARAN-delete'); // delete
    $app->group(
        '/ANTRIAN_PENDAFTARAN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{Id}]', AntrianPendaftaranController::class . ':list')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN/list-ANTRIAN_PENDAFTARAN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{Id}]', AntrianPendaftaranController::class . ':add')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN/add-ANTRIAN_PENDAFTARAN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{Id}]', AntrianPendaftaranController::class . ':view')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN/view-ANTRIAN_PENDAFTARAN-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{Id}]', AntrianPendaftaranController::class . ':edit')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN/edit-ANTRIAN_PENDAFTARAN-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{Id}]', AntrianPendaftaranController::class . ':delete')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN/delete-ANTRIAN_PENDAFTARAN-delete-2'); // delete
        }
    );

    // ANTRIAN_POLI
    $app->any('/AntrianPoliList[/{VISIT_ID}]', AntrianPoliController::class . ':list')->add(PermissionMiddleware::class)->setName('AntrianPoliList-ANTRIAN_POLI-list'); // list
    $app->any('/AntrianPoliAdd[/{VISIT_ID}]', AntrianPoliController::class . ':add')->add(PermissionMiddleware::class)->setName('AntrianPoliAdd-ANTRIAN_POLI-add'); // add
    $app->any('/AntrianPoliView[/{VISIT_ID}]', AntrianPoliController::class . ':view')->add(PermissionMiddleware::class)->setName('AntrianPoliView-ANTRIAN_POLI-view'); // view
    $app->any('/AntrianPoliEdit[/{VISIT_ID}]', AntrianPoliController::class . ':edit')->add(PermissionMiddleware::class)->setName('AntrianPoliEdit-ANTRIAN_POLI-edit'); // edit
    $app->any('/AntrianPoliDelete[/{VISIT_ID}]', AntrianPoliController::class . ':delete')->add(PermissionMiddleware::class)->setName('AntrianPoliDelete-ANTRIAN_POLI-delete'); // delete
    $app->group(
        '/ANTRIAN_POLI',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{VISIT_ID}]', AntrianPoliController::class . ':list')->add(PermissionMiddleware::class)->setName('ANTRIAN_POLI/list-ANTRIAN_POLI-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{VISIT_ID}]', AntrianPoliController::class . ':add')->add(PermissionMiddleware::class)->setName('ANTRIAN_POLI/add-ANTRIAN_POLI-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{VISIT_ID}]', AntrianPoliController::class . ':view')->add(PermissionMiddleware::class)->setName('ANTRIAN_POLI/view-ANTRIAN_POLI-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{VISIT_ID}]', AntrianPoliController::class . ':edit')->add(PermissionMiddleware::class)->setName('ANTRIAN_POLI/edit-ANTRIAN_POLI-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{VISIT_ID}]', AntrianPoliController::class . ':delete')->add(PermissionMiddleware::class)->setName('ANTRIAN_POLI/delete-ANTRIAN_POLI-delete-2'); // delete
        }
    );

    // call_stored_procedure
    $app->any('/CallStoredProcedure[/{params:.*}]', CallStoredProcedureController::class)->add(PermissionMiddleware::class)->setName('CallStoredProcedure-call_stored_procedure-custom'); // custom

    // CLASS_ROOM
    $app->any('/ClassRoomList[/{ORG_UNIT_CODE}/{CLASS_ROOM_ID}]', ClassRoomController::class . ':list')->add(PermissionMiddleware::class)->setName('ClassRoomList-CLASS_ROOM-list'); // list
    $app->group(
        '/CLASS_ROOM',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{CLASS_ROOM_ID}]', ClassRoomController::class . ':list')->add(PermissionMiddleware::class)->setName('CLASS_ROOM/list-CLASS_ROOM-list-2'); // list
        }
    );

    // Dashboard2
    $app->any('/Dashboard2', Dashboard2Controller::class)->add(PermissionMiddleware::class)->setName('Dashboard2-Dashboard2-dashboard'); // dashboard

    // DIAGNOSA
    $app->any('/DiagnosaList[/{DIAGNOSA_ID}]', DiagnosaController::class . ':list')->add(PermissionMiddleware::class)->setName('DiagnosaList-DIAGNOSA-list'); // list
    $app->any('/DiagnosaAdd[/{DIAGNOSA_ID}]', DiagnosaController::class . ':add')->add(PermissionMiddleware::class)->setName('DiagnosaAdd-DIAGNOSA-add'); // add
    $app->any('/DiagnosaEdit[/{DIAGNOSA_ID}]', DiagnosaController::class . ':edit')->add(PermissionMiddleware::class)->setName('DiagnosaEdit-DIAGNOSA-edit'); // edit
    $app->any('/DiagnosaDelete[/{DIAGNOSA_ID}]', DiagnosaController::class . ':delete')->add(PermissionMiddleware::class)->setName('DiagnosaDelete-DIAGNOSA-delete'); // delete
    $app->group(
        '/DIAGNOSA',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{DIAGNOSA_ID}]', DiagnosaController::class . ':list')->add(PermissionMiddleware::class)->setName('DIAGNOSA/list-DIAGNOSA-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{DIAGNOSA_ID}]', DiagnosaController::class . ':add')->add(PermissionMiddleware::class)->setName('DIAGNOSA/add-DIAGNOSA-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{DIAGNOSA_ID}]', DiagnosaController::class . ':edit')->add(PermissionMiddleware::class)->setName('DIAGNOSA/edit-DIAGNOSA-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{DIAGNOSA_ID}]', DiagnosaController::class . ':delete')->add(PermissionMiddleware::class)->setName('DIAGNOSA/delete-DIAGNOSA-delete-2'); // delete
        }
    );

    // EMPLOYEE_ALL
    $app->any('/EmployeeAllList[/{ORG_UNIT_CODE}/{EMPLOYEE_ID}]', EmployeeAllController::class . ':list')->add(PermissionMiddleware::class)->setName('EmployeeAllList-EMPLOYEE_ALL-list'); // list
    $app->group(
        '/EMPLOYEE_ALL',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{EMPLOYEE_ID}]', EmployeeAllController::class . ':list')->add(PermissionMiddleware::class)->setName('EMPLOYEE_ALL/list-EMPLOYEE_ALL-list-2'); // list
        }
    );

    // GOOD_GF
    $app->any('/GoodGfList[/{idx}]', GoodGfController::class . ':list')->add(PermissionMiddleware::class)->setName('GoodGfList-GOOD_GF-list'); // list
    $app->any('/GoodGfAdd[/{idx}]', GoodGfController::class . ':add')->add(PermissionMiddleware::class)->setName('GoodGfAdd-GOOD_GF-add'); // add
    $app->any('/GoodGfView[/{idx}]', GoodGfController::class . ':view')->add(PermissionMiddleware::class)->setName('GoodGfView-GOOD_GF-view'); // view
    $app->any('/GoodGfEdit[/{idx}]', GoodGfController::class . ':edit')->add(PermissionMiddleware::class)->setName('GoodGfEdit-GOOD_GF-edit'); // edit
    $app->any('/GoodGfDelete[/{idx}]', GoodGfController::class . ':delete')->add(PermissionMiddleware::class)->setName('GoodGfDelete-GOOD_GF-delete'); // delete
    $app->group(
        '/GOOD_GF',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idx}]', GoodGfController::class . ':list')->add(PermissionMiddleware::class)->setName('GOOD_GF/list-GOOD_GF-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{idx}]', GoodGfController::class . ':add')->add(PermissionMiddleware::class)->setName('GOOD_GF/add-GOOD_GF-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{idx}]', GoodGfController::class . ':view')->add(PermissionMiddleware::class)->setName('GOOD_GF/view-GOOD_GF-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{idx}]', GoodGfController::class . ':edit')->add(PermissionMiddleware::class)->setName('GOOD_GF/edit-GOOD_GF-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{idx}]', GoodGfController::class . ':delete')->add(PermissionMiddleware::class)->setName('GOOD_GF/delete-GOOD_GF-delete-2'); // delete
        }
    );

    // GOODS
    $app->any('/GoodsList[/{BRAND_ID}]', GoodsController::class . ':list')->add(PermissionMiddleware::class)->setName('GoodsList-GOODS-list'); // list
    $app->any('/GoodsAdd[/{BRAND_ID}]', GoodsController::class . ':add')->add(PermissionMiddleware::class)->setName('GoodsAdd-GOODS-add'); // add
    $app->any('/GoodsView[/{BRAND_ID}]', GoodsController::class . ':view')->add(PermissionMiddleware::class)->setName('GoodsView-GOODS-view'); // view
    $app->any('/GoodsEdit[/{BRAND_ID}]', GoodsController::class . ':edit')->add(PermissionMiddleware::class)->setName('GoodsEdit-GOODS-edit'); // edit
    $app->any('/GoodsDelete[/{BRAND_ID}]', GoodsController::class . ':delete')->add(PermissionMiddleware::class)->setName('GoodsDelete-GOODS-delete'); // delete
    $app->group(
        '/GOODS',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{BRAND_ID}]', GoodsController::class . ':list')->add(PermissionMiddleware::class)->setName('GOODS/list-GOODS-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{BRAND_ID}]', GoodsController::class . ':add')->add(PermissionMiddleware::class)->setName('GOODS/add-GOODS-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{BRAND_ID}]', GoodsController::class . ':view')->add(PermissionMiddleware::class)->setName('GOODS/view-GOODS-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{BRAND_ID}]', GoodsController::class . ':edit')->add(PermissionMiddleware::class)->setName('GOODS/edit-GOODS-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{BRAND_ID}]', GoodsController::class . ':delete')->add(PermissionMiddleware::class)->setName('GOODS/delete-GOODS-delete-2'); // delete
        }
    );

    // GOODS_FORM
    $app->any('/GoodsFormList[/{FORM_ID}]', GoodsFormController::class . ':list')->add(PermissionMiddleware::class)->setName('GoodsFormList-GOODS_FORM-list'); // list
    $app->any('/GoodsFormAdd[/{FORM_ID}]', GoodsFormController::class . ':add')->add(PermissionMiddleware::class)->setName('GoodsFormAdd-GOODS_FORM-add'); // add
    $app->any('/GoodsFormView[/{FORM_ID}]', GoodsFormController::class . ':view')->add(PermissionMiddleware::class)->setName('GoodsFormView-GOODS_FORM-view'); // view
    $app->any('/GoodsFormEdit[/{FORM_ID}]', GoodsFormController::class . ':edit')->add(PermissionMiddleware::class)->setName('GoodsFormEdit-GOODS_FORM-edit'); // edit
    $app->any('/GoodsFormDelete[/{FORM_ID}]', GoodsFormController::class . ':delete')->add(PermissionMiddleware::class)->setName('GoodsFormDelete-GOODS_FORM-delete'); // delete
    $app->group(
        '/GOODS_FORM',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{FORM_ID}]', GoodsFormController::class . ':list')->add(PermissionMiddleware::class)->setName('GOODS_FORM/list-GOODS_FORM-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{FORM_ID}]', GoodsFormController::class . ':add')->add(PermissionMiddleware::class)->setName('GOODS_FORM/add-GOODS_FORM-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{FORM_ID}]', GoodsFormController::class . ':view')->add(PermissionMiddleware::class)->setName('GOODS_FORM/view-GOODS_FORM-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{FORM_ID}]', GoodsFormController::class . ':edit')->add(PermissionMiddleware::class)->setName('GOODS_FORM/edit-GOODS_FORM-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{FORM_ID}]', GoodsFormController::class . ':delete')->add(PermissionMiddleware::class)->setName('GOODS_FORM/delete-GOODS_FORM-delete-2'); // delete
        }
    );

    // harian
    $app->any('/Harian', HarianController::class)->add(PermissionMiddleware::class)->setName('Harian-harian-summary'); // summary

    // ITEM_CONDITION
    $app->any('/ItemConditionList[/{CONDITION}]', ItemConditionController::class . ':list')->add(PermissionMiddleware::class)->setName('ItemConditionList-ITEM_CONDITION-list'); // list
    $app->any('/ItemConditionAdd[/{CONDITION}]', ItemConditionController::class . ':add')->add(PermissionMiddleware::class)->setName('ItemConditionAdd-ITEM_CONDITION-add'); // add
    $app->any('/ItemConditionView[/{CONDITION}]', ItemConditionController::class . ':view')->add(PermissionMiddleware::class)->setName('ItemConditionView-ITEM_CONDITION-view'); // view
    $app->any('/ItemConditionEdit[/{CONDITION}]', ItemConditionController::class . ':edit')->add(PermissionMiddleware::class)->setName('ItemConditionEdit-ITEM_CONDITION-edit'); // edit
    $app->any('/ItemConditionDelete[/{CONDITION}]', ItemConditionController::class . ':delete')->add(PermissionMiddleware::class)->setName('ItemConditionDelete-ITEM_CONDITION-delete'); // delete
    $app->group(
        '/ITEM_CONDITION',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{CONDITION}]', ItemConditionController::class . ':list')->add(PermissionMiddleware::class)->setName('ITEM_CONDITION/list-ITEM_CONDITION-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{CONDITION}]', ItemConditionController::class . ':add')->add(PermissionMiddleware::class)->setName('ITEM_CONDITION/add-ITEM_CONDITION-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{CONDITION}]', ItemConditionController::class . ':view')->add(PermissionMiddleware::class)->setName('ITEM_CONDITION/view-ITEM_CONDITION-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{CONDITION}]', ItemConditionController::class . ':edit')->add(PermissionMiddleware::class)->setName('ITEM_CONDITION/edit-ITEM_CONDITION-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{CONDITION}]', ItemConditionController::class . ':delete')->add(PermissionMiddleware::class)->setName('ITEM_CONDITION/delete-ITEM_CONDITION-delete-2'); // delete
        }
    );

    // kedatangan_pasien
    $app->any('/KedatanganPasien', KedatanganPasienController::class)->add(PermissionMiddleware::class)->setName('KedatanganPasien-kedatangan_pasien-summary'); // summary

    // l_set_cssd
    $app->any('/LSetCssdList[/{id_set}]', LSetCssdController::class . ':list')->add(PermissionMiddleware::class)->setName('LSetCssdList-l_set_cssd-list'); // list
    $app->any('/LSetCssdAdd[/{id_set}]', LSetCssdController::class . ':add')->add(PermissionMiddleware::class)->setName('LSetCssdAdd-l_set_cssd-add'); // add
    $app->any('/LSetCssdView[/{id_set}]', LSetCssdController::class . ':view')->add(PermissionMiddleware::class)->setName('LSetCssdView-l_set_cssd-view'); // view
    $app->any('/LSetCssdEdit[/{id_set}]', LSetCssdController::class . ':edit')->add(PermissionMiddleware::class)->setName('LSetCssdEdit-l_set_cssd-edit'); // edit
    $app->any('/LSetCssdDelete[/{id_set}]', LSetCssdController::class . ':delete')->add(PermissionMiddleware::class)->setName('LSetCssdDelete-l_set_cssd-delete'); // delete
    $app->group(
        '/l_set_cssd',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_set}]', LSetCssdController::class . ':list')->add(PermissionMiddleware::class)->setName('l_set_cssd/list-l_set_cssd-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_set}]', LSetCssdController::class . ':add')->add(PermissionMiddleware::class)->setName('l_set_cssd/add-l_set_cssd-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_set}]', LSetCssdController::class . ':view')->add(PermissionMiddleware::class)->setName('l_set_cssd/view-l_set_cssd-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_set}]', LSetCssdController::class . ':edit')->add(PermissionMiddleware::class)->setName('l_set_cssd/edit-l_set_cssd-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_set}]', LSetCssdController::class . ':delete')->add(PermissionMiddleware::class)->setName('l_set_cssd/delete-l_set_cssd-delete-2'); // delete
        }
    );

    // m_alat_cssd
    $app->any('/MAlatCssdList[/{alat_id}]', MAlatCssdController::class . ':list')->add(PermissionMiddleware::class)->setName('MAlatCssdList-m_alat_cssd-list'); // list
    $app->any('/MAlatCssdAdd[/{alat_id}]', MAlatCssdController::class . ':add')->add(PermissionMiddleware::class)->setName('MAlatCssdAdd-m_alat_cssd-add'); // add
    $app->any('/MAlatCssdView[/{alat_id}]', MAlatCssdController::class . ':view')->add(PermissionMiddleware::class)->setName('MAlatCssdView-m_alat_cssd-view'); // view
    $app->any('/MAlatCssdEdit[/{alat_id}]', MAlatCssdController::class . ':edit')->add(PermissionMiddleware::class)->setName('MAlatCssdEdit-m_alat_cssd-edit'); // edit
    $app->any('/MAlatCssdDelete[/{alat_id}]', MAlatCssdController::class . ':delete')->add(PermissionMiddleware::class)->setName('MAlatCssdDelete-m_alat_cssd-delete'); // delete
    $app->group(
        '/m_alat_cssd',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{alat_id}]', MAlatCssdController::class . ':list')->add(PermissionMiddleware::class)->setName('m_alat_cssd/list-m_alat_cssd-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{alat_id}]', MAlatCssdController::class . ':add')->add(PermissionMiddleware::class)->setName('m_alat_cssd/add-m_alat_cssd-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{alat_id}]', MAlatCssdController::class . ':view')->add(PermissionMiddleware::class)->setName('m_alat_cssd/view-m_alat_cssd-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{alat_id}]', MAlatCssdController::class . ':edit')->add(PermissionMiddleware::class)->setName('m_alat_cssd/edit-m_alat_cssd-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{alat_id}]', MAlatCssdController::class . ':delete')->add(PermissionMiddleware::class)->setName('m_alat_cssd/delete-m_alat_cssd-delete-2'); // delete
        }
    );

    // mata_dan_syaraf
    $app->any('/MataDanSyaraf', MataDanSyarafController::class)->add(PermissionMiddleware::class)->setName('MataDanSyaraf-mata_dan_syaraf-summary'); // summary

    // MEASUREMENT
    $app->any('/MeasurementList[/{MEASURE_ID}]', MeasurementController::class . ':list')->add(PermissionMiddleware::class)->setName('MeasurementList-MEASUREMENT-list'); // list
    $app->any('/MeasurementAdd[/{MEASURE_ID}]', MeasurementController::class . ':add')->add(PermissionMiddleware::class)->setName('MeasurementAdd-MEASUREMENT-add'); // add
    $app->any('/MeasurementView[/{MEASURE_ID}]', MeasurementController::class . ':view')->add(PermissionMiddleware::class)->setName('MeasurementView-MEASUREMENT-view'); // view
    $app->any('/MeasurementEdit[/{MEASURE_ID}]', MeasurementController::class . ':edit')->add(PermissionMiddleware::class)->setName('MeasurementEdit-MEASUREMENT-edit'); // edit
    $app->any('/MeasurementDelete[/{MEASURE_ID}]', MeasurementController::class . ':delete')->add(PermissionMiddleware::class)->setName('MeasurementDelete-MEASUREMENT-delete'); // delete
    $app->group(
        '/MEASUREMENT',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{MEASURE_ID}]', MeasurementController::class . ':list')->add(PermissionMiddleware::class)->setName('MEASUREMENT/list-MEASUREMENT-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{MEASURE_ID}]', MeasurementController::class . ':add')->add(PermissionMiddleware::class)->setName('MEASUREMENT/add-MEASUREMENT-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{MEASURE_ID}]', MeasurementController::class . ':view')->add(PermissionMiddleware::class)->setName('MEASUREMENT/view-MEASUREMENT-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{MEASURE_ID}]', MeasurementController::class . ':edit')->add(PermissionMiddleware::class)->setName('MEASUREMENT/edit-MEASUREMENT-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{MEASURE_ID}]', MeasurementController::class . ':delete')->add(PermissionMiddleware::class)->setName('MEASUREMENT/delete-MEASUREMENT-delete-2'); // delete
        }
    );

    // MUTATION_DOCS
    $app->any('/MutationDocsList[/{ID}]', MutationDocsController::class . ':list')->add(PermissionMiddleware::class)->setName('MutationDocsList-MUTATION_DOCS-list'); // list
    $app->any('/MutationDocsAdd[/{ID}]', MutationDocsController::class . ':add')->add(PermissionMiddleware::class)->setName('MutationDocsAdd-MUTATION_DOCS-add'); // add
    $app->any('/MutationDocsView[/{ID}]', MutationDocsController::class . ':view')->add(PermissionMiddleware::class)->setName('MutationDocsView-MUTATION_DOCS-view'); // view
    $app->any('/MutationDocsEdit[/{ID}]', MutationDocsController::class . ':edit')->add(PermissionMiddleware::class)->setName('MutationDocsEdit-MUTATION_DOCS-edit'); // edit
    $app->any('/MutationDocsDelete[/{ID}]', MutationDocsController::class . ':delete')->add(PermissionMiddleware::class)->setName('MutationDocsDelete-MUTATION_DOCS-delete'); // delete
    $app->group(
        '/MUTATION_DOCS',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', MutationDocsController::class . ':list')->add(PermissionMiddleware::class)->setName('MUTATION_DOCS/list-MUTATION_DOCS-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', MutationDocsController::class . ':add')->add(PermissionMiddleware::class)->setName('MUTATION_DOCS/add-MUTATION_DOCS-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', MutationDocsController::class . ':view')->add(PermissionMiddleware::class)->setName('MUTATION_DOCS/view-MUTATION_DOCS-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', MutationDocsController::class . ':edit')->add(PermissionMiddleware::class)->setName('MUTATION_DOCS/edit-MUTATION_DOCS-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', MutationDocsController::class . ':delete')->add(PermissionMiddleware::class)->setName('MUTATION_DOCS/delete-MUTATION_DOCS-delete-2'); // delete
        }
    );

    // OBSTETRI
    $app->any('/ObstetriList[/{ID}]', ObstetriController::class . ':list')->add(PermissionMiddleware::class)->setName('ObstetriList-OBSTETRI-list'); // list
    $app->any('/ObstetriAdd[/{ID}]', ObstetriController::class . ':add')->add(PermissionMiddleware::class)->setName('ObstetriAdd-OBSTETRI-add'); // add
    $app->any('/ObstetriView[/{ID}]', ObstetriController::class . ':view')->add(PermissionMiddleware::class)->setName('ObstetriView-OBSTETRI-view'); // view
    $app->any('/ObstetriEdit[/{ID}]', ObstetriController::class . ':edit')->add(PermissionMiddleware::class)->setName('ObstetriEdit-OBSTETRI-edit'); // edit
    $app->any('/ObstetriDelete[/{ID}]', ObstetriController::class . ':delete')->add(PermissionMiddleware::class)->setName('ObstetriDelete-OBSTETRI-delete'); // delete
    $app->group(
        '/OBSTETRI',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', ObstetriController::class . ':list')->add(PermissionMiddleware::class)->setName('OBSTETRI/list-OBSTETRI-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', ObstetriController::class . ':add')->add(PermissionMiddleware::class)->setName('OBSTETRI/add-OBSTETRI-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', ObstetriController::class . ':view')->add(PermissionMiddleware::class)->setName('OBSTETRI/view-OBSTETRI-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', ObstetriController::class . ':edit')->add(PermissionMiddleware::class)->setName('OBSTETRI/edit-OBSTETRI-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', ObstetriController::class . ':delete')->add(PermissionMiddleware::class)->setName('OBSTETRI/delete-OBSTETRI-delete-2'); // delete
        }
    );

    // PASIEN
    $app->any('/PasienList[/{ID}]', PasienController::class . ':list')->add(PermissionMiddleware::class)->setName('PasienList-PASIEN-list'); // list
    $app->any('/PasienAdd[/{ID}]', PasienController::class . ':add')->add(PermissionMiddleware::class)->setName('PasienAdd-PASIEN-add'); // add
    $app->any('/PasienView[/{ID}]', PasienController::class . ':view')->add(PermissionMiddleware::class)->setName('PasienView-PASIEN-view'); // view
    $app->any('/PasienEdit[/{ID}]', PasienController::class . ':edit')->add(PermissionMiddleware::class)->setName('PasienEdit-PASIEN-edit'); // edit
    $app->group(
        '/PASIEN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', PasienController::class . ':list')->add(PermissionMiddleware::class)->setName('PASIEN/list-PASIEN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', PasienController::class . ':add')->add(PermissionMiddleware::class)->setName('PASIEN/add-PASIEN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', PasienController::class . ':view')->add(PermissionMiddleware::class)->setName('PASIEN/view-PASIEN-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', PasienController::class . ':edit')->add(PermissionMiddleware::class)->setName('PASIEN/edit-PASIEN-edit-2'); // edit
        }
    );

    // PASIEN_DIAGNOSA
    $app->any('/PasienDiagnosaList[/{ID}]', PasienDiagnosaController::class . ':list')->add(PermissionMiddleware::class)->setName('PasienDiagnosaList-PASIEN_DIAGNOSA-list'); // list
    $app->any('/PasienDiagnosaAdd[/{ID}]', PasienDiagnosaController::class . ':add')->add(PermissionMiddleware::class)->setName('PasienDiagnosaAdd-PASIEN_DIAGNOSA-add'); // add
    $app->any('/PasienDiagnosaView[/{ID}]', PasienDiagnosaController::class . ':view')->add(PermissionMiddleware::class)->setName('PasienDiagnosaView-PASIEN_DIAGNOSA-view'); // view
    $app->any('/PasienDiagnosaEdit[/{ID}]', PasienDiagnosaController::class . ':edit')->add(PermissionMiddleware::class)->setName('PasienDiagnosaEdit-PASIEN_DIAGNOSA-edit'); // edit
    $app->any('/PasienDiagnosaDelete[/{ID}]', PasienDiagnosaController::class . ':delete')->add(PermissionMiddleware::class)->setName('PasienDiagnosaDelete-PASIEN_DIAGNOSA-delete'); // delete
    $app->group(
        '/PASIEN_DIAGNOSA',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', PasienDiagnosaController::class . ':list')->add(PermissionMiddleware::class)->setName('PASIEN_DIAGNOSA/list-PASIEN_DIAGNOSA-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', PasienDiagnosaController::class . ':add')->add(PermissionMiddleware::class)->setName('PASIEN_DIAGNOSA/add-PASIEN_DIAGNOSA-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', PasienDiagnosaController::class . ':view')->add(PermissionMiddleware::class)->setName('PASIEN_DIAGNOSA/view-PASIEN_DIAGNOSA-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', PasienDiagnosaController::class . ':edit')->add(PermissionMiddleware::class)->setName('PASIEN_DIAGNOSA/edit-PASIEN_DIAGNOSA-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', PasienDiagnosaController::class . ':delete')->add(PermissionMiddleware::class)->setName('PASIEN_DIAGNOSA/delete-PASIEN_DIAGNOSA-delete-2'); // delete
        }
    );

    // PASIEN_VISITATION
    $app->any('/PasienVisitationList[/{IDXDAFTAR}]', PasienVisitationController::class . ':list')->add(PermissionMiddleware::class)->setName('PasienVisitationList-PASIEN_VISITATION-list'); // list
    $app->any('/PasienVisitationAdd[/{IDXDAFTAR}]', PasienVisitationController::class . ':add')->add(PermissionMiddleware::class)->setName('PasienVisitationAdd-PASIEN_VISITATION-add'); // add
    $app->any('/PasienVisitationView[/{IDXDAFTAR}]', PasienVisitationController::class . ':view')->add(PermissionMiddleware::class)->setName('PasienVisitationView-PASIEN_VISITATION-view'); // view
    $app->any('/PasienVisitationEdit[/{IDXDAFTAR}]', PasienVisitationController::class . ':edit')->add(PermissionMiddleware::class)->setName('PasienVisitationEdit-PASIEN_VISITATION-edit'); // edit
    $app->any('/PasienVisitationSearch', PasienVisitationController::class . ':search')->add(PermissionMiddleware::class)->setName('PasienVisitationSearch-PASIEN_VISITATION-search'); // search
    $app->group(
        '/PASIEN_VISITATION',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', PasienVisitationController::class . ':list')->add(PermissionMiddleware::class)->setName('PASIEN_VISITATION/list-PASIEN_VISITATION-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{IDXDAFTAR}]', PasienVisitationController::class . ':add')->add(PermissionMiddleware::class)->setName('PASIEN_VISITATION/add-PASIEN_VISITATION-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', PasienVisitationController::class . ':view')->add(PermissionMiddleware::class)->setName('PASIEN_VISITATION/view-PASIEN_VISITATION-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', PasienVisitationController::class . ':edit')->add(PermissionMiddleware::class)->setName('PASIEN_VISITATION/edit-PASIEN_VISITATION-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', PasienVisitationController::class . ':search')->add(PermissionMiddleware::class)->setName('PASIEN_VISITATION/search-PASIEN_VISITATION-search-2'); // search
        }
    );

    // penyakit_menular
    $app->any('/PenyakitMenular', PenyakitMenularController::class)->add(PermissionMiddleware::class)->setName('PenyakitMenular-penyakit_menular-summary'); // summary

    // register_cara_bayar
    $app->any('/RegisterCaraBayar', RegisterCaraBayarController::class)->add(PermissionMiddleware::class)->setName('RegisterCaraBayar-register_cara_bayar-summary'); // summary

    // register_pasien
    $app->any('/RegisterPasien', RegisterPasienController::class)->add(PermissionMiddleware::class)->setName('RegisterPasien-register_pasien-summary'); // summary

    // register_perpoli_bulanan
    $app->any('/RegisterPerpoliBulanan', RegisterPerpoliBulananController::class)->add(PermissionMiddleware::class)->setName('RegisterPerpoliBulanan-register_perpoli_bulanan-summary'); // summary

    // register_perpoli_harian
    $app->any('/RegisterPerpoliHarian', RegisterPerpoliHarianController::class)->add(PermissionMiddleware::class)->setName('RegisterPerpoliHarian-register_perpoli_harian-summary'); // summary

    // register_perpoli_tahunan
    $app->any('/RegisterPerpoliTahunan', RegisterPerpoliTahunanController::class)->add(PermissionMiddleware::class)->setName('RegisterPerpoliTahunan-register_perpoli_tahunan-summary'); // summary

    // register_ranap
    $app->any('/RegisterRanap', RegisterRanapController::class)->add(PermissionMiddleware::class)->setName('RegisterRanap-register_ranap-summary'); // summary

    // sensus_hari_ini
    $app->any('/SensusHariIniList', SensusHariIniController::class . ':list')->add(PermissionMiddleware::class)->setName('SensusHariIniList-sensus_hari_ini-list'); // list
    $app->group(
        '/sensus_hari_ini',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', SensusHariIniController::class . ':list')->add(PermissionMiddleware::class)->setName('sensus_hari_ini/list-sensus_hari_ini-list-2'); // list
        }
    );

    // TARIF_TEMP
    $app->any('/TarifTempList', TarifTempController::class . ':list')->add(PermissionMiddleware::class)->setName('TarifTempList-TARIF_TEMP-list'); // list
    $app->group(
        '/TARIF_TEMP',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', TarifTempController::class . ':list')->add(PermissionMiddleware::class)->setName('TARIF_TEMP/list-TARIF_TEMP-list-2'); // list
        }
    );

    // TREAT_TARIF
    $app->any('/TreatTarifList[/{ORG_UNIT_CODE}/{TARIF_ID}]', TreatTarifController::class . ':list')->add(PermissionMiddleware::class)->setName('TreatTarifList-TREAT_TARIF-list'); // list
    $app->any('/TreatTarifAdd[/{ORG_UNIT_CODE}/{TARIF_ID}]', TreatTarifController::class . ':add')->add(PermissionMiddleware::class)->setName('TreatTarifAdd-TREAT_TARIF-add'); // add
    $app->group(
        '/TREAT_TARIF',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{TARIF_ID}]', TreatTarifController::class . ':list')->add(PermissionMiddleware::class)->setName('TREAT_TARIF/list-TREAT_TARIF-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ORG_UNIT_CODE}/{TARIF_ID}]', TreatTarifController::class . ':add')->add(PermissionMiddleware::class)->setName('TREAT_TARIF/add-TREAT_TARIF-add-2'); // add
        }
    );

    // TREATMENT_AKOMODASI
    $app->any('/TreatmentAkomodasiList[/{ID}]', TreatmentAkomodasiController::class . ':list')->add(PermissionMiddleware::class)->setName('TreatmentAkomodasiList-TREATMENT_AKOMODASI-list'); // list
    $app->any('/TreatmentAkomodasiAdd[/{ID}]', TreatmentAkomodasiController::class . ':add')->add(PermissionMiddleware::class)->setName('TreatmentAkomodasiAdd-TREATMENT_AKOMODASI-add'); // add
    $app->any('/TreatmentAkomodasiView[/{ID}]', TreatmentAkomodasiController::class . ':view')->add(PermissionMiddleware::class)->setName('TreatmentAkomodasiView-TREATMENT_AKOMODASI-view'); // view
    $app->any('/TreatmentAkomodasiEdit[/{ID}]', TreatmentAkomodasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('TreatmentAkomodasiEdit-TREATMENT_AKOMODASI-edit'); // edit
    $app->group(
        '/TREATMENT_AKOMODASI',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', TreatmentAkomodasiController::class . ':list')->add(PermissionMiddleware::class)->setName('TREATMENT_AKOMODASI/list-TREATMENT_AKOMODASI-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', TreatmentAkomodasiController::class . ':add')->add(PermissionMiddleware::class)->setName('TREATMENT_AKOMODASI/add-TREATMENT_AKOMODASI-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', TreatmentAkomodasiController::class . ':view')->add(PermissionMiddleware::class)->setName('TREATMENT_AKOMODASI/view-TREATMENT_AKOMODASI-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', TreatmentAkomodasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('TREATMENT_AKOMODASI/edit-TREATMENT_AKOMODASI-edit-2'); // edit
        }
    );

    // TREATMENT_BILL
    $app->any('/TreatmentBillList[/{ID}]', TreatmentBillController::class . ':list')->add(PermissionMiddleware::class)->setName('TreatmentBillList-TREATMENT_BILL-list'); // list
    $app->any('/TreatmentBillAdd[/{ID}]', TreatmentBillController::class . ':add')->add(PermissionMiddleware::class)->setName('TreatmentBillAdd-TREATMENT_BILL-add'); // add
    $app->any('/TreatmentBillEdit[/{ID}]', TreatmentBillController::class . ':edit')->add(PermissionMiddleware::class)->setName('TreatmentBillEdit-TREATMENT_BILL-edit'); // edit
    $app->any('/TreatmentBillDelete[/{ID}]', TreatmentBillController::class . ':delete')->add(PermissionMiddleware::class)->setName('TreatmentBillDelete-TREATMENT_BILL-delete'); // delete
    $app->group(
        '/TREATMENT_BILL',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', TreatmentBillController::class . ':list')->add(PermissionMiddleware::class)->setName('TREATMENT_BILL/list-TREATMENT_BILL-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', TreatmentBillController::class . ':add')->add(PermissionMiddleware::class)->setName('TREATMENT_BILL/add-TREATMENT_BILL-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', TreatmentBillController::class . ':edit')->add(PermissionMiddleware::class)->setName('TREATMENT_BILL/edit-TREATMENT_BILL-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', TreatmentBillController::class . ':delete')->add(PermissionMiddleware::class)->setName('TREATMENT_BILL/delete-TREATMENT_BILL-delete-2'); // delete
        }
    );

    // TREATMENT_OBAT
    $app->any('/TreatmentObatList[/{ID}]', TreatmentObatController::class . ':list')->add(PermissionMiddleware::class)->setName('TreatmentObatList-TREATMENT_OBAT-list'); // list
    $app->any('/TreatmentObatAdd[/{ID}]', TreatmentObatController::class . ':add')->add(PermissionMiddleware::class)->setName('TreatmentObatAdd-TREATMENT_OBAT-add'); // add
    $app->any('/TreatmentObatView[/{ID}]', TreatmentObatController::class . ':view')->add(PermissionMiddleware::class)->setName('TreatmentObatView-TREATMENT_OBAT-view'); // view
    $app->any('/TreatmentObatEdit[/{ID}]', TreatmentObatController::class . ':edit')->add(PermissionMiddleware::class)->setName('TreatmentObatEdit-TREATMENT_OBAT-edit'); // edit
    $app->any('/TreatmentObatDelete[/{ID}]', TreatmentObatController::class . ':delete')->add(PermissionMiddleware::class)->setName('TreatmentObatDelete-TREATMENT_OBAT-delete'); // delete
    $app->group(
        '/TREATMENT_OBAT',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', TreatmentObatController::class . ':list')->add(PermissionMiddleware::class)->setName('TREATMENT_OBAT/list-TREATMENT_OBAT-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', TreatmentObatController::class . ':add')->add(PermissionMiddleware::class)->setName('TREATMENT_OBAT/add-TREATMENT_OBAT-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', TreatmentObatController::class . ':view')->add(PermissionMiddleware::class)->setName('TREATMENT_OBAT/view-TREATMENT_OBAT-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', TreatmentObatController::class . ':edit')->add(PermissionMiddleware::class)->setName('TREATMENT_OBAT/edit-TREATMENT_OBAT-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', TreatmentObatController::class . ':delete')->add(PermissionMiddleware::class)->setName('TREATMENT_OBAT/delete-TREATMENT_OBAT-delete-2'); // delete
        }
    );

    // USER_LOGIN
    $app->any('/UserLoginList[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':list')->add(PermissionMiddleware::class)->setName('UserLoginList-USER_LOGIN-list'); // list
    $app->any('/UserLoginAdd[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':add')->add(PermissionMiddleware::class)->setName('UserLoginAdd-USER_LOGIN-add'); // add
    $app->any('/UserLoginView[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':view')->add(PermissionMiddleware::class)->setName('UserLoginView-USER_LOGIN-view'); // view
    $app->any('/UserLoginEdit[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserLoginEdit-USER_LOGIN-edit'); // edit
    $app->group(
        '/USER_LOGIN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':list')->add(PermissionMiddleware::class)->setName('USER_LOGIN/list-USER_LOGIN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':add')->add(PermissionMiddleware::class)->setName('USER_LOGIN/add-USER_LOGIN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':view')->add(PermissionMiddleware::class)->setName('USER_LOGIN/view-USER_LOGIN-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ORG_UNIT_CODE}/{_USERNAME}]', UserLoginController::class . ':edit')->add(PermissionMiddleware::class)->setName('USER_LOGIN/edit-USER_LOGIN-edit-2'); // edit
        }
    );

    // V_DAFTAR_PASIEN
    $app->any('/VDaftarPasienList[/{ID}]', VDaftarPasienController::class . ':list')->add(PermissionMiddleware::class)->setName('VDaftarPasienList-V_DAFTAR_PASIEN-list'); // list
    $app->any('/VDaftarPasienAdd[/{ID}]', VDaftarPasienController::class . ':add')->add(PermissionMiddleware::class)->setName('VDaftarPasienAdd-V_DAFTAR_PASIEN-add'); // add
    $app->any('/VDaftarPasienView[/{ID}]', VDaftarPasienController::class . ':view')->add(PermissionMiddleware::class)->setName('VDaftarPasienView-V_DAFTAR_PASIEN-view'); // view
    $app->group(
        '/V_DAFTAR_PASIEN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', VDaftarPasienController::class . ':list')->add(PermissionMiddleware::class)->setName('V_DAFTAR_PASIEN/list-V_DAFTAR_PASIEN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', VDaftarPasienController::class . ':add')->add(PermissionMiddleware::class)->setName('V_DAFTAR_PASIEN/add-V_DAFTAR_PASIEN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ID}]', VDaftarPasienController::class . ':view')->add(PermissionMiddleware::class)->setName('V_DAFTAR_PASIEN/view-V_DAFTAR_PASIEN-view-2'); // view
        }
    );

    // V_FARMASI
    $app->any('/VFarmasiList[/{IDXDAFTAR}]', VFarmasiController::class . ':list')->add(PermissionMiddleware::class)->setName('VFarmasiList-V_FARMASI-list'); // list
    $app->any('/VFarmasiAdd[/{IDXDAFTAR}]', VFarmasiController::class . ':add')->add(PermissionMiddleware::class)->setName('VFarmasiAdd-V_FARMASI-add'); // add
    $app->any('/VFarmasiView[/{IDXDAFTAR}]', VFarmasiController::class . ':view')->add(PermissionMiddleware::class)->setName('VFarmasiView-V_FARMASI-view'); // view
    $app->any('/VFarmasiEdit[/{IDXDAFTAR}]', VFarmasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('VFarmasiEdit-V_FARMASI-edit'); // edit
    $app->any('/VFarmasiSearch', VFarmasiController::class . ':search')->add(PermissionMiddleware::class)->setName('VFarmasiSearch-V_FARMASI-search'); // search
    $app->group(
        '/V_FARMASI',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VFarmasiController::class . ':list')->add(PermissionMiddleware::class)->setName('V_FARMASI/list-V_FARMASI-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{IDXDAFTAR}]', VFarmasiController::class . ':add')->add(PermissionMiddleware::class)->setName('V_FARMASI/add-V_FARMASI-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VFarmasiController::class . ':view')->add(PermissionMiddleware::class)->setName('V_FARMASI/view-V_FARMASI-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VFarmasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_FARMASI/edit-V_FARMASI-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', VFarmasiController::class . ':search')->add(PermissionMiddleware::class)->setName('V_FARMASI/search-V_FARMASI-search-2'); // search
        }
    );

    // V_KASIR
    $app->any('/VKasirList[/{IDXDAFTAR}]', VKasirController::class . ':list')->add(PermissionMiddleware::class)->setName('VKasirList-V_KASIR-list'); // list
    $app->any('/VKasirAdd[/{IDXDAFTAR}]', VKasirController::class . ':add')->add(PermissionMiddleware::class)->setName('VKasirAdd-V_KASIR-add'); // add
    $app->any('/VKasirView[/{IDXDAFTAR}]', VKasirController::class . ':view')->add(PermissionMiddleware::class)->setName('VKasirView-V_KASIR-view'); // view
    $app->any('/VKasirEdit[/{IDXDAFTAR}]', VKasirController::class . ':edit')->add(PermissionMiddleware::class)->setName('VKasirEdit-V_KASIR-edit'); // edit
    $app->any('/VKasirSearch', VKasirController::class . ':search')->add(PermissionMiddleware::class)->setName('VKasirSearch-V_KASIR-search'); // search
    $app->group(
        '/V_KASIR',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VKasirController::class . ':list')->add(PermissionMiddleware::class)->setName('V_KASIR/list-V_KASIR-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{IDXDAFTAR}]', VKasirController::class . ':add')->add(PermissionMiddleware::class)->setName('V_KASIR/add-V_KASIR-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VKasirController::class . ':view')->add(PermissionMiddleware::class)->setName('V_KASIR/view-V_KASIR-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VKasirController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_KASIR/edit-V_KASIR-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', VKasirController::class . ':search')->add(PermissionMiddleware::class)->setName('V_KASIR/search-V_KASIR-search-2'); // search
        }
    );

    // V_KUNJUNGAN
    $app->any('/VKunjunganList[/{NO_REGISTRATION}/{VISIT_ID}]', VKunjunganController::class . ':list')->add(PermissionMiddleware::class)->setName('VKunjunganList-V_KUNJUNGAN-list'); // list
    $app->group(
        '/V_KUNJUNGAN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{NO_REGISTRATION}/{VISIT_ID}]', VKunjunganController::class . ':list')->add(PermissionMiddleware::class)->setName('V_KUNJUNGAN/list-V_KUNJUNGAN-list-2'); // list
        }
    );

    // V_KUNJUNGAN_PASIEN
    $app->any('/VKunjunganPasienList[/{IDXDAFTAR}]', VKunjunganPasienController::class . ':list')->add(PermissionMiddleware::class)->setName('VKunjunganPasienList-V_KUNJUNGAN_PASIEN-list'); // list
    $app->any('/VKunjunganPasienAdd[/{IDXDAFTAR}]', VKunjunganPasienController::class . ':add')->add(PermissionMiddleware::class)->setName('VKunjunganPasienAdd-V_KUNJUNGAN_PASIEN-add'); // add
    $app->any('/VKunjunganPasienView[/{IDXDAFTAR}]', VKunjunganPasienController::class . ':view')->add(PermissionMiddleware::class)->setName('VKunjunganPasienView-V_KUNJUNGAN_PASIEN-view'); // view
    $app->any('/VKunjunganPasienEdit[/{IDXDAFTAR}]', VKunjunganPasienController::class . ':edit')->add(PermissionMiddleware::class)->setName('VKunjunganPasienEdit-V_KUNJUNGAN_PASIEN-edit'); // edit
    $app->group(
        '/V_KUNJUNGAN_PASIEN',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VKunjunganPasienController::class . ':list')->add(PermissionMiddleware::class)->setName('V_KUNJUNGAN_PASIEN/list-V_KUNJUNGAN_PASIEN-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{IDXDAFTAR}]', VKunjunganPasienController::class . ':add')->add(PermissionMiddleware::class)->setName('V_KUNJUNGAN_PASIEN/add-V_KUNJUNGAN_PASIEN-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VKunjunganPasienController::class . ':view')->add(PermissionMiddleware::class)->setName('V_KUNJUNGAN_PASIEN/view-V_KUNJUNGAN_PASIEN-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VKunjunganPasienController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_KUNJUNGAN_PASIEN/edit-V_KUNJUNGAN_PASIEN-edit-2'); // edit
        }
    );

    // V_LABORATORIUM
    $app->any('/VLaboratoriumList[/{IDXDAFTAR}]', VLaboratoriumController::class . ':list')->add(PermissionMiddleware::class)->setName('VLaboratoriumList-V_LABORATORIUM-list'); // list
    $app->any('/VLaboratoriumAdd[/{IDXDAFTAR}]', VLaboratoriumController::class . ':add')->add(PermissionMiddleware::class)->setName('VLaboratoriumAdd-V_LABORATORIUM-add'); // add
    $app->any('/VLaboratoriumView[/{IDXDAFTAR}]', VLaboratoriumController::class . ':view')->add(PermissionMiddleware::class)->setName('VLaboratoriumView-V_LABORATORIUM-view'); // view
    $app->any('/VLaboratoriumEdit[/{IDXDAFTAR}]', VLaboratoriumController::class . ':edit')->add(PermissionMiddleware::class)->setName('VLaboratoriumEdit-V_LABORATORIUM-edit'); // edit
    $app->any('/VLaboratoriumSearch', VLaboratoriumController::class . ':search')->add(PermissionMiddleware::class)->setName('VLaboratoriumSearch-V_LABORATORIUM-search'); // search
    $app->group(
        '/V_LABORATORIUM',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VLaboratoriumController::class . ':list')->add(PermissionMiddleware::class)->setName('V_LABORATORIUM/list-V_LABORATORIUM-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{IDXDAFTAR}]', VLaboratoriumController::class . ':add')->add(PermissionMiddleware::class)->setName('V_LABORATORIUM/add-V_LABORATORIUM-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VLaboratoriumController::class . ':view')->add(PermissionMiddleware::class)->setName('V_LABORATORIUM/view-V_LABORATORIUM-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VLaboratoriumController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_LABORATORIUM/edit-V_LABORATORIUM-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', VLaboratoriumController::class . ':search')->add(PermissionMiddleware::class)->setName('V_LABORATORIUM/search-V_LABORATORIUM-search-2'); // search
        }
    );

    // V_PASIENVISITATIONRJ
    $app->any('/VPasienvisitationrjList[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':list')->add(PermissionMiddleware::class)->setName('VPasienvisitationrjList-V_PASIENVISITATIONRJ-list'); // list
    $app->any('/VPasienvisitationrjAdd[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':add')->add(PermissionMiddleware::class)->setName('VPasienvisitationrjAdd-V_PASIENVISITATIONRJ-add'); // add
    $app->any('/VPasienvisitationrjView[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':view')->add(PermissionMiddleware::class)->setName('VPasienvisitationrjView-V_PASIENVISITATIONRJ-view'); // view
    $app->any('/VPasienvisitationrjEdit[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':edit')->add(PermissionMiddleware::class)->setName('VPasienvisitationrjEdit-V_PASIENVISITATIONRJ-edit'); // edit
    $app->group(
        '/V_PASIENVISITATIONRJ',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':list')->add(PermissionMiddleware::class)->setName('V_PASIENVISITATIONRJ/list-V_PASIENVISITATIONRJ-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':add')->add(PermissionMiddleware::class)->setName('V_PASIENVISITATIONRJ/add-V_PASIENVISITATIONRJ-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':view')->add(PermissionMiddleware::class)->setName('V_PASIENVISITATIONRJ/view-V_PASIENVISITATIONRJ-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{NO_REGISTRATION}/{ORG_UNIT_CODE}/{visit_id}]', VPasienvisitationrjController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_PASIENVISITATIONRJ/edit-V_PASIENVISITATIONRJ-edit-2'); // edit
        }
    );

    // V_RADIOLOGI
    $app->any('/VRadiologiList[/{IDXDAFTAR}]', VRadiologiController::class . ':list')->add(PermissionMiddleware::class)->setName('VRadiologiList-V_RADIOLOGI-list'); // list
    $app->any('/VRadiologiAdd[/{IDXDAFTAR}]', VRadiologiController::class . ':add')->add(PermissionMiddleware::class)->setName('VRadiologiAdd-V_RADIOLOGI-add'); // add
    $app->any('/VRadiologiView[/{IDXDAFTAR}]', VRadiologiController::class . ':view')->add(PermissionMiddleware::class)->setName('VRadiologiView-V_RADIOLOGI-view'); // view
    $app->any('/VRadiologiEdit[/{IDXDAFTAR}]', VRadiologiController::class . ':edit')->add(PermissionMiddleware::class)->setName('VRadiologiEdit-V_RADIOLOGI-edit'); // edit
    $app->any('/VRadiologiSearch', VRadiologiController::class . ':search')->add(PermissionMiddleware::class)->setName('VRadiologiSearch-V_RADIOLOGI-search'); // search
    $app->group(
        '/V_RADIOLOGI',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VRadiologiController::class . ':list')->add(PermissionMiddleware::class)->setName('V_RADIOLOGI/list-V_RADIOLOGI-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{IDXDAFTAR}]', VRadiologiController::class . ':add')->add(PermissionMiddleware::class)->setName('V_RADIOLOGI/add-V_RADIOLOGI-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VRadiologiController::class . ':view')->add(PermissionMiddleware::class)->setName('V_RADIOLOGI/view-V_RADIOLOGI-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VRadiologiController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_RADIOLOGI/edit-V_RADIOLOGI-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', VRadiologiController::class . ':search')->add(PermissionMiddleware::class)->setName('V_RADIOLOGI/search-V_RADIOLOGI-search-2'); // search
        }
    );

    // V_REKAM_MEDIS
    $app->any('/VRekamMedisList[/{IDXDAFTAR}]', VRekamMedisController::class . ':list')->add(PermissionMiddleware::class)->setName('VRekamMedisList-V_REKAM_MEDIS-list'); // list
    $app->any('/VRekamMedisAdd[/{IDXDAFTAR}]', VRekamMedisController::class . ':add')->add(PermissionMiddleware::class)->setName('VRekamMedisAdd-V_REKAM_MEDIS-add'); // add
    $app->any('/VRekamMedisView[/{IDXDAFTAR}]', VRekamMedisController::class . ':view')->add(PermissionMiddleware::class)->setName('VRekamMedisView-V_REKAM_MEDIS-view'); // view
    $app->any('/VRekamMedisEdit[/{IDXDAFTAR}]', VRekamMedisController::class . ':edit')->add(PermissionMiddleware::class)->setName('VRekamMedisEdit-V_REKAM_MEDIS-edit'); // edit
    $app->any('/VRekamMedisSearch', VRekamMedisController::class . ':search')->add(PermissionMiddleware::class)->setName('VRekamMedisSearch-V_REKAM_MEDIS-search'); // search
    $app->group(
        '/V_REKAM_MEDIS',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VRekamMedisController::class . ':list')->add(PermissionMiddleware::class)->setName('V_REKAM_MEDIS/list-V_REKAM_MEDIS-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{IDXDAFTAR}]', VRekamMedisController::class . ':add')->add(PermissionMiddleware::class)->setName('V_REKAM_MEDIS/add-V_REKAM_MEDIS-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{IDXDAFTAR}]', VRekamMedisController::class . ':view')->add(PermissionMiddleware::class)->setName('V_REKAM_MEDIS/view-V_REKAM_MEDIS-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{IDXDAFTAR}]', VRekamMedisController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_REKAM_MEDIS/edit-V_REKAM_MEDIS-edit-2'); // edit
            $group->any('/' . Config("SEARCH_ACTION") . '', VRekamMedisController::class . ':search')->add(PermissionMiddleware::class)->setName('V_REKAM_MEDIS/search-V_REKAM_MEDIS-search-2'); // search
        }
    );

    // V_RIWAYAT_RM
    $app->any('/VRiwayatRmList[/{IDXDAFTAR}]', VRiwayatRmController::class . ':list')->add(PermissionMiddleware::class)->setName('VRiwayatRmList-V_RIWAYAT_RM-list'); // list
    $app->group(
        '/V_RIWAYAT_RM',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VRiwayatRmController::class . ':list')->add(PermissionMiddleware::class)->setName('V_RIWAYAT_RM/list-V_RIWAYAT_RM-list-2'); // list
        }
    );

    // v_riwayat_sep
    $app->any('/VRiwayatSepList[/{IDXDAFTAR}]', VRiwayatSepController::class . ':list')->add(PermissionMiddleware::class)->setName('VRiwayatSepList-v_riwayat_sep-list'); // list
    $app->group(
        '/v_riwayat_sep',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{IDXDAFTAR}]', VRiwayatSepController::class . ':list')->add(PermissionMiddleware::class)->setName('v_riwayat_sep/list-v_riwayat_sep-list-2'); // list
        }
    );

    // V_SENSUS
    $app->any('/VSensusList[/{NO_REGISTRATION}]', VSensusController::class . ':list')->add(PermissionMiddleware::class)->setName('VSensusList-V_SENSUS-list'); // list
    $app->group(
        '/V_SENSUS',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{NO_REGISTRATION}]', VSensusController::class . ':list')->add(PermissionMiddleware::class)->setName('V_SENSUS/list-V_SENSUS-list-2'); // list
        }
    );

    // V_SENSUS_MATA_SYARAF
    $app->any('/VSensusMataSyarafList', VSensusMataSyarafController::class . ':list')->add(PermissionMiddleware::class)->setName('VSensusMataSyarafList-V_SENSUS_MATA_SYARAF-list'); // list
    $app->group(
        '/V_SENSUS_MATA_SYARAF',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', VSensusMataSyarafController::class . ':list')->add(PermissionMiddleware::class)->setName('V_SENSUS_MATA_SYARAF/list-V_SENSUS_MATA_SYARAF-list-2'); // list
        }
    );

    // V_TREATMENTBILL
    $app->any('/VTreatmentbillList[/{visit_id}]', VTreatmentbillController::class . ':list')->add(PermissionMiddleware::class)->setName('VTreatmentbillList-V_TREATMENTBILL-list'); // list
    $app->group(
        '/V_TREATMENTBILL',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{visit_id}]', VTreatmentbillController::class . ':list')->add(PermissionMiddleware::class)->setName('V_TREATMENTBILL/list-V_TREATMENTBILL-list-2'); // list
        }
    );

    // V_RAWAT_INAP
    $app->any('/VRawatInapList[/{ID}]', VRawatInapController::class . ':list')->add(PermissionMiddleware::class)->setName('VRawatInapList-V_RAWAT_INAP-list'); // list
    $app->group(
        '/V_RAWAT_INAP',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', VRawatInapController::class . ':list')->add(PermissionMiddleware::class)->setName('V_RAWAT_INAP/list-V_RAWAT_INAP-list-2'); // list
        }
    );

    // V_AKOMODASI_KAMAR
    $app->any('/VAkomodasiKamarList[/{ID}]', VAkomodasiKamarController::class . ':list')->add(PermissionMiddleware::class)->setName('VAkomodasiKamarList-V_AKOMODASI_KAMAR-list'); // list
    $app->any('/VAkomodasiKamarAdd[/{ID}]', VAkomodasiKamarController::class . ':add')->add(PermissionMiddleware::class)->setName('VAkomodasiKamarAdd-V_AKOMODASI_KAMAR-add'); // add
    $app->any('/VAkomodasiKamarEdit[/{ID}]', VAkomodasiKamarController::class . ':edit')->add(PermissionMiddleware::class)->setName('VAkomodasiKamarEdit-V_AKOMODASI_KAMAR-edit'); // edit
    $app->any('/VAkomodasiKamarDelete[/{ID}]', VAkomodasiKamarController::class . ':delete')->add(PermissionMiddleware::class)->setName('VAkomodasiKamarDelete-V_AKOMODASI_KAMAR-delete'); // delete
    $app->group(
        '/V_AKOMODASI_KAMAR',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', VAkomodasiKamarController::class . ':list')->add(PermissionMiddleware::class)->setName('V_AKOMODASI_KAMAR/list-V_AKOMODASI_KAMAR-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', VAkomodasiKamarController::class . ':add')->add(PermissionMiddleware::class)->setName('V_AKOMODASI_KAMAR/add-V_AKOMODASI_KAMAR-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', VAkomodasiKamarController::class . ':edit')->add(PermissionMiddleware::class)->setName('V_AKOMODASI_KAMAR/edit-V_AKOMODASI_KAMAR-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ID}]', VAkomodasiKamarController::class . ':delete')->add(PermissionMiddleware::class)->setName('V_AKOMODASI_KAMAR/delete-V_AKOMODASI_KAMAR-delete-2'); // delete
        }
    );

    // ANTRIAN_PENDAFTARAN_DISABILITAS
    $app->any('/AntrianPendaftaranDisabilitasList[/{Id}]', AntrianPendaftaranDisabilitasController::class . ':list')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranDisabilitasList-ANTRIAN_PENDAFTARAN_DISABILITAS-list'); // list
    $app->any('/AntrianPendaftaranDisabilitasAdd[/{Id}]', AntrianPendaftaranDisabilitasController::class . ':add')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranDisabilitasAdd-ANTRIAN_PENDAFTARAN_DISABILITAS-add'); // add
    $app->any('/AntrianPendaftaranDisabilitasView[/{Id}]', AntrianPendaftaranDisabilitasController::class . ':view')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranDisabilitasView-ANTRIAN_PENDAFTARAN_DISABILITAS-view'); // view
    $app->any('/AntrianPendaftaranDisabilitasEdit[/{Id}]', AntrianPendaftaranDisabilitasController::class . ':edit')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranDisabilitasEdit-ANTRIAN_PENDAFTARAN_DISABILITAS-edit'); // edit
    $app->any('/AntrianPendaftaranDisabilitasDelete[/{Id}]', AntrianPendaftaranDisabilitasController::class . ':delete')->add(PermissionMiddleware::class)->setName('AntrianPendaftaranDisabilitasDelete-ANTRIAN_PENDAFTARAN_DISABILITAS-delete'); // delete
    $app->group(
        '/ANTRIAN_PENDAFTARAN_DISABILITAS',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{Id}]', AntrianPendaftaranDisabilitasController::class . ':list')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN_DISABILITAS/list-ANTRIAN_PENDAFTARAN_DISABILITAS-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{Id}]', AntrianPendaftaranDisabilitasController::class . ':add')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN_DISABILITAS/add-ANTRIAN_PENDAFTARAN_DISABILITAS-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{Id}]', AntrianPendaftaranDisabilitasController::class . ':view')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN_DISABILITAS/view-ANTRIAN_PENDAFTARAN_DISABILITAS-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{Id}]', AntrianPendaftaranDisabilitasController::class . ':edit')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN_DISABILITAS/edit-ANTRIAN_PENDAFTARAN_DISABILITAS-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{Id}]', AntrianPendaftaranDisabilitasController::class . ':delete')->add(PermissionMiddleware::class)->setName('ANTRIAN_PENDAFTARAN_DISABILITAS/delete-ANTRIAN_PENDAFTARAN_DISABILITAS-delete-2'); // delete
        }
    );

    // AuditTrail
    $app->any('/AuditTrailList[/{Id}]', AuditTrailController::class . ':list')->add(PermissionMiddleware::class)->setName('AuditTrailList-AuditTrail-list'); // list
    $app->any('/AuditTrailAdd[/{Id}]', AuditTrailController::class . ':add')->add(PermissionMiddleware::class)->setName('AuditTrailAdd-AuditTrail-add'); // add
    $app->any('/AuditTrailView[/{Id}]', AuditTrailController::class . ':view')->add(PermissionMiddleware::class)->setName('AuditTrailView-AuditTrail-view'); // view
    $app->any('/AuditTrailEdit[/{Id}]', AuditTrailController::class . ':edit')->add(PermissionMiddleware::class)->setName('AuditTrailEdit-AuditTrail-edit'); // edit
    $app->any('/AuditTrailDelete[/{Id}]', AuditTrailController::class . ':delete')->add(PermissionMiddleware::class)->setName('AuditTrailDelete-AuditTrail-delete'); // delete
    $app->group(
        '/AuditTrail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{Id}]', AuditTrailController::class . ':list')->add(PermissionMiddleware::class)->setName('AuditTrail/list-AuditTrail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{Id}]', AuditTrailController::class . ':add')->add(PermissionMiddleware::class)->setName('AuditTrail/add-AuditTrail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{Id}]', AuditTrailController::class . ':view')->add(PermissionMiddleware::class)->setName('AuditTrail/view-AuditTrail-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{Id}]', AuditTrailController::class . ':edit')->add(PermissionMiddleware::class)->setName('AuditTrail/edit-AuditTrail-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{Id}]', AuditTrailController::class . ':delete')->add(PermissionMiddleware::class)->setName('AuditTrail/delete-AuditTrail-delete-2'); // delete
        }
    );

    // cv_pasien
    $app->any('/CvPasienList[/{ID}]', CvPasienController::class . ':list')->add(PermissionMiddleware::class)->setName('CvPasienList-cv_pasien-list'); // list
    $app->any('/CvPasienAdd[/{ID}]', CvPasienController::class . ':add')->add(PermissionMiddleware::class)->setName('CvPasienAdd-cv_pasien-add'); // add
    $app->group(
        '/cv_pasien',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', CvPasienController::class . ':list')->add(PermissionMiddleware::class)->setName('cv_pasien/list-cv_pasien-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ID}]', CvPasienController::class . ':add')->add(PermissionMiddleware::class)->setName('cv_pasien/add-cv_pasien-add-2'); // add
        }
    );

    // icd9
    $app->any('/Icd9List[/{kode}]', Icd9Controller::class . ':list')->add(PermissionMiddleware::class)->setName('Icd9List-icd9-list'); // list
    $app->any('/Icd9Add[/{kode}]', Icd9Controller::class . ':add')->add(PermissionMiddleware::class)->setName('Icd9Add-icd9-add'); // add
    $app->any('/Icd9View[/{kode}]', Icd9Controller::class . ':view')->add(PermissionMiddleware::class)->setName('Icd9View-icd9-view'); // view
    $app->any('/Icd9Edit[/{kode}]', Icd9Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('Icd9Edit-icd9-edit'); // edit
    $app->any('/Icd9Delete[/{kode}]', Icd9Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('Icd9Delete-icd9-delete'); // delete
    $app->group(
        '/icd9',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{kode}]', Icd9Controller::class . ':list')->add(PermissionMiddleware::class)->setName('icd9/list-icd9-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{kode}]', Icd9Controller::class . ':add')->add(PermissionMiddleware::class)->setName('icd9/add-icd9-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{kode}]', Icd9Controller::class . ':view')->add(PermissionMiddleware::class)->setName('icd9/view-icd9-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{kode}]', Icd9Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('icd9/edit-icd9-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{kode}]', Icd9Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('icd9/delete-icd9-delete-2'); // delete
        }
    );

    // userlevel2
    $app->any('/Userlevel2List[/{UserLevelID}]', Userlevel2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('Userlevel2List-userlevel2-list'); // list
    $app->any('/Userlevel2Add[/{UserLevelID}]', Userlevel2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('Userlevel2Add-userlevel2-add'); // add
    $app->any('/Userlevel2View[/{UserLevelID}]', Userlevel2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('Userlevel2View-userlevel2-view'); // view
    $app->any('/Userlevel2Edit[/{UserLevelID}]', Userlevel2Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('Userlevel2Edit-userlevel2-edit'); // edit
    $app->any('/Userlevel2Delete[/{UserLevelID}]', Userlevel2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('Userlevel2Delete-userlevel2-delete'); // delete
    $app->group(
        '/userlevel2',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{UserLevelID}]', Userlevel2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('userlevel2/list-userlevel2-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{UserLevelID}]', Userlevel2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('userlevel2/add-userlevel2-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{UserLevelID}]', Userlevel2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('userlevel2/view-userlevel2-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{UserLevelID}]', Userlevel2Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevel2/edit-userlevel2-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{UserLevelID}]', Userlevel2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevel2/delete-userlevel2-delete-2'); // delete
        }
    );

    // userlevelpermission
    $app->any('/UserlevelpermissionList[/{UserLevelID}]', UserlevelpermissionController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelpermissionList-userlevelpermission-list'); // list
    $app->any('/UserlevelpermissionAdd[/{UserLevelID}]', UserlevelpermissionController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelpermissionAdd-userlevelpermission-add'); // add
    $app->any('/UserlevelpermissionView[/{UserLevelID}]', UserlevelpermissionController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelpermissionView-userlevelpermission-view'); // view
    $app->any('/UserlevelpermissionEdit[/{UserLevelID}]', UserlevelpermissionController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelpermissionEdit-userlevelpermission-edit'); // edit
    $app->any('/UserlevelpermissionDelete[/{UserLevelID}]', UserlevelpermissionController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelpermissionDelete-userlevelpermission-delete'); // delete
    $app->group(
        '/userlevelpermission',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{UserLevelID}]', UserlevelpermissionController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermission/list-userlevelpermission-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{UserLevelID}]', UserlevelpermissionController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermission/add-userlevelpermission-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{UserLevelID}]', UserlevelpermissionController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermission/view-userlevelpermission-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{UserLevelID}]', UserlevelpermissionController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermission/edit-userlevelpermission-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{UserLevelID}]', UserlevelpermissionController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermission/delete-userlevelpermission-delete-2'); // delete
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->any('/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
