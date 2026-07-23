<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Dashboard :: S. K. Constructions Jagdalpur</title>
    <link rel="icon" type="image/x-icon" href="src/assets/img/favicon.ico"/>

    <link href="src/layouts/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="src/layouts/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="src/layouts/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- DASHBOARD STYLES -->
    <link href="src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="src/assets/css/components/list-group.css" rel="stylesheet" type="text/css">
    <!-- New Added Start-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

      <link href="src/assets/css/components/style-calendar.css" rel="stylesheet" type="text/css">
    <style>
            .datepicker{
                width: 320px;
                border: 0;
                border-radius: 8px;
                box-shadow: 0 18px 45px rgba(15, 23, 42, 0.18);
                padding: 14px;
                font-family: 'Nunito', sans-serif;
                z-index: 9999 !important;
            }

            .datepicker:before,
            .datepicker:after{
                display: none;
            }

            .datepicker table{
                width: 100%;
                border-collapse: separate;
                border-spacing: 0 4px;
            }

            .datepicker .datepicker-switch,
            .datepicker .prev,
            .datepicker .next{
                color: #1f2937;
                font-weight: 700;
                border-radius: 6px;
                height: 38px;
            }

            .datepicker .prev,
            .datepicker .next{
                color: #4361ee;
            }

            .datepicker .datepicker-switch:hover,
            .datepicker .prev:hover,
            .datepicker .next:hover{
                background: #eef2ff;
            }

            .datepicker th.dow{
                color: #64748b;
                font-size: 12px;
                font-weight: 700;
                padding-top: 10px;
                text-transform: uppercase;
            }

            .datepicker table tr td,
            .datepicker table tr th{
                border-radius: 6px;
            }

            .datepicker table tr td.day{
                color: #334155;
                height: 36px;
                width: 36px;
                transition: background-color .15s ease, color .15s ease, box-shadow .15s ease;
            }

            .datepicker table tr td.day:hover,
            .datepicker table tr td.focused{
                background: #eef2ff;
                color: #1e3a8a;
            }

            .datepicker table tr td.old,
            .datepicker table tr td.new{
                color: #cbd5e1;
            }

            .datepicker table tr td.today{
                background: #e0f2fe;
                color: #0369a1;
                font-weight: 800;
            }

            .datepicker table tr td.active,
            .datepicker table tr td.active:hover,
            .datepicker table tr td.active.highlighted,
            .datepicker table tr td.active.highlighted:hover{
                background: #4361ee;
                color: #fff;
                font-weight: 800;
                text-shadow: none;
                box-shadow: 0 8px 18px rgba(67, 97, 238, .28);
            }

            .datepicker .today,
            .datepicker .clear{
                border-radius: 6px;
                color: #4361ee;
                font-weight: 700;
            }

            .sk-datepicker-field{
                background-color: #fff !important;
                background-image: linear-gradient(45deg, transparent 50%, #4361ee 50%), linear-gradient(135deg, #4361ee 50%, transparent 50%);
                background-position: calc(100% - 18px) 55%, calc(100% - 13px) 55%;
                background-size: 5px 5px, 5px 5px;
                background-repeat: no-repeat;
                cursor: pointer;
                padding-right: 38px;
            }

            .sk-row-actions{
                display: inline-flex;
                align-items: center;
                overflow: hidden;
                border: 1px solid #e0e6ed;
                border-radius: 8px;
                background: #fff;
                box-shadow: 0 6px 16px rgba(31, 45, 61, .06);
            }

            .sk-row-actions .sk-action-btn{
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 34px;
                height: 32px;
                color: #3b3f5c;
                border-right: 1px solid #e0e6ed;
                transition: background-color .15s ease, color .15s ease;
            }

            .sk-row-actions .sk-action-btn:last-child{
                border-right: 0;
            }

            .sk-row-actions .sk-action-btn svg{
                width: 16px;
                height: 16px;
                stroke-width: 2;
            }

            .sk-row-actions .sk-action-edit:hover{
                background: #eef2ff;
                color: #4361ee;
            }

            .sk-row-actions .sk-action-view:hover{
                background: #e0f2fe;
                color: #0ea5e9;
            }

            .sk-row-actions .sk-action-delete{
                color: #e7515a;
            }

            .sk-row-actions .sk-action-delete:hover{
                background: #fff1f2;
                color: #dc2626;
            }

            .sk-list-filter-row .form-select,
            .sk-list-filter-row .form-control{
                height: 48px;
                margin-bottom: 0 !important;
            }

            .sk-filter-submit{
                height: 48px;
                min-width: 92px;
                padding: 0 22px;
                border-radius: 6px;
                font-size: 13px;
                font-weight: 600;
                box-shadow: 0 8px 18px rgba(67, 97, 238, .18) !important;
            }

            .dt--top-section .row{
                align-items: center;
            }

            .dt--top-section .dt-buttons{
                display: flex;
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 6px;
            }

            .dt-buttons .dt-button.sk-dt-export-btn,
            .dt-buttons .dt-button.btn-sm{
                margin: 0 !important;
                padding: 6px 12px !important;
                min-width: auto;
                border-radius: 6px !important;
                font-size: 12px !important;
                line-height: 1.2 !important;
                box-shadow: none !important;
            }

            .dataTables_filter{
                width: 100%;
                text-align: right;
            }

            .dataTables_filter label{
                width: 100%;
                margin-bottom: 0;
            }

            .dataTables_filter input{
                width: min(100%, 360px) !important;
                height: 42px;
                margin-left: 10px !important;
            }

            .sk-bulk-actions{
                display: inline-flex;
                overflow: hidden;
                border-radius: 6px;
                box-shadow: 0 6px 16px rgba(31, 45, 61, .08);
            }

            .sk-bulk-actions .btn{
                padding: 8px 16px;
                font-size: 13px;
                font-weight: 600;
            }
    </style>

    <!-- New Added Close -->
    <link href="src/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
    <!-- END DASHBOARD STYLES -->

    <!-- DATATABLES STYLES -->
    <link rel="stylesheet" type="text/css" href="src/plugins/src/table/datatable/datatables.css">

    <link rel="stylesheet" type="text/css" href="src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="src/plugins/css/light/table/datatable/custom_dt_miscellaneous.css">
    <!-- END DATATABLES STYLES -->


</head>
<body class=" layout-boxed">
