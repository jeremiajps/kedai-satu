<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Kedai Makan Satu-Satu </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;600&display=swap');
            *{
                padding: 0;
                margin: 0;
            }
            body{
                font-family: 'Poppins', sans-serif;
                background-color: #c0dcac;
            }
            h2{
                color: #206A5D;
            }
            h4{
                color: #206A5D;
            }
            a{
                color: inherit;
                text-decoration: none;
            }
            .navbar{
                padding: 0.5rem 1rem;
                background-color: #206A5D;
                color: #c0dcac;
                position: fixed;
                width: 100%;
                top: 0;
                left: 0;
                z-index: 99;
            }
            .sidebar{
                position: fixed;
                width: 200px;
                top: 0;
                bottom: 0;
                background-color: #FFFFFF;
                padding-top: 40px;
                transition: all .5s;
            }
            .sidebar-hide{
                left: -250px;
            }
            .sidebar-show{
                left: 0;
            }
            .sidebar-body{
                padding: 15px;
            }
            .sidebar-body h4{
                margin-bottom: 8px;
                color: #206A5D;
            }
            .sidebar-body ul{
                list-style: none;
                color: #206A5D;
                font-size: small;
            }
            .sidebar-body ul li a{
                width: 100%;
                display: inline-block;
                padding: 7px 15px;
                box-sizing: border-box;
            }
            .sidebar-body ul li a:hover{
                background-color: #206A5D;
                color: #c0dcac;
            }
            .sidebar-body ul li:not(:last-child){
                border-bottom: 1px solid #206A5D;
            }
            .buttonedit{
                display: block;
                background-color: #FFFFFF;
                color: #206A5D;
                font-size: 15px;
                font-weight: 600;
                width: 242px;
                height: 48px;
                border-radius: 10px;
                cursor: pointer;
                margin: auto;
                border-style: none;
            }
            .container-input{
                width: 100%;
                padding: 50px 5px;
                box-sizing: border-box;
                justify-content: center;
                align-items: center;
            }
            .body-input{
                background-color: #fff;
                width: 50%;
                padding: 10px 15px;
                box-sizing: border-box;
                border-radius: 5px;
                margin: 20px auto;
            }
            .body-field {
                margin: 5px 0;
                font-weight: 600;
                font-size: x-small;
                color: #206A5D;
                font-family: 'Poppins', sans-serif;
            }
            .update{
                display: block;
                width: 100%;
                padding: 0.5rem 1rem;
                color: #fff;
                background-color: #206A5D;
                border-style: none;
                border-radius: 5px;
                cursor: pointer;
                margin: 10px 0;
            }
            .card{
                width: 100%;
                border-radius: 5px;
                background-color: #FFFFFF;
                color: #206A5D;
                margin-bottom: 15px;
                padding: 3px;
            }
            .body-table{
                width: 100%;
                box-sizing: border-box;
                margin-left: auto;
                margin-right: auto;
            }
            .content-table{
                padding: 60px 10px;
            }
            .table{
                font-size: smaller;
                font-weight: 600;
                color: #206A5D;
                width: 100%;
                border-collapse: collapse;
                margin-top: 8px;
            }
            .image{
                width: 100%;
                max-width: 200px;
                height: auto;
            }
            .table thead th, .table tbody td{
                border: 1px solid;
                padding: 3px;
                font-size: x-small;
            }
            .buttonicon{
                border-radius: 3px;
                padding: 2px 4px;
                display: inline-block;
                background-color: #206A5D;
                color: #FFFFFF;
                margin-left: 2px;
                margin-right: 2px;
            }
            .buttonTambah{
                border-radius: 3px;
                padding: 2px 6px;
                display: inline-block;
                background-color: #206A5D;
                color: #FFFFFF;
                margin-left: 2px;
                margin-right: 2px;
            }
            .input{
                margin-bottom: 8px;
                font-size: small;
                color: #206A5D;
            }
            .input label{
                display: block; 
                margin-bottom: 5px;
                font-weight: 600;
            }
            .input-field{
                width: 100%;
                box-sizing: border-box;
                padding: 0.5rem;
                font-size: small;
            }
            .buttonback{
                padding: 6px 10px;
                display: inline-block;
                background-color: #206A5D;
                color: #FFFFFF;
                border-radius: 3px;
                border-style: none;
                font-size: smaller;
                cursor: pointer;
            }
            .buttonsubmit{
                padding: 6px 10px;
                display: inline-block;
                background-color: #206A5D;
                color: #FFFFFF;
                border-radius: 3px;
                border-style: none;
                font-size: smaller;
                cursor: pointer;
            }
            @media (max-width: 768px) {
                .container{
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            <a href="#" id="btnBars">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="sidebar sidebar-hide">
            <div class="sidebar-body">
                <h4>Kategori Menu</h4>
                <ul>
                    <li><a href="../pages/beranda.php">Beranda</a></li>
                    <li><a href="../auth/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        
