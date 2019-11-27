<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Menü</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="stylesheet" type="text/css" href="Style/style.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="fontawesome.min">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">




  </head>
  <style>
  html, body{
    margin: 0;
    padding: 0;
    background-color: #cceeff;
    margin-top: 50px;
    margin-left: 200px;
    margin-right: 200px;
    text-align: center;
    font-family: 'Roboto', sans-serif;

  }

  section{
    min-height: 100%;
  }

  a{
    text-decoration: none;

  }

  li{
    list-style-type: none;
  }


  li, img{
    transition: all 300ms;
    -webkit-transition: all 300ms;
    -moz-transition: all 300ms;
    -o-transition: all 300ms;
  }



  /* icons ***************************************/


  #icons ul{
    padding: 0;

  }
  #icons ul li{
    width: 33.3%;
    float: left;
    margin-top: 20px;

  }

  #icons img{
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background-color: #a1c3f7;
  }
  #icons img:hover{
    transform:scale(1.1);
    -webkit-transform:scale(1.1);
    -moz-transform:scale(1.1);
    -o-transform:scale(1.1);
    box-shadow: 0 5px 5px rgba(0, 0, 0, 0.3);

  }

  </style>

  <body>



  <!-- Menü--------------->

      <section id="menü">


        <div id="icons">
          <ul>


          <li><a href="index.php?action=open_shop"><img src="http://cdn.onlinewebfonts.com/svg/img_265961.png" alt="1"></a><h1>Shop</h1></li>
          <li><a href="index.php?action=open_magazine"><img src="https://cdn1.iconfinder.com/data/icons/logistic-10/48/49_logistic_delivery_shipping_luggage_parcel_boxes_transport_warehouse_godown_storage_storehouse-512.png" alt="2"></a><h1>Lager</h1></li>
          <li><a href="index.php?action=open_logs"><img src="https://www.shareicon.net/data/256x256/2016/06/10/778566_graph_512x512.png" alt="3"></a><h1>Statistik</h1></li>
          <li><a href="index.php?action=open_userInterface"><img src="http://cdn.onlinewebfonts.com/svg/img_508735.png" alt="4"></a><h1>User</h1></li>
          <li><a href="index.php?action=open_settings"><img src="http://cdn.onlinewebfonts.com/svg/img_518053.png" alt="5"></a><h1>Settings</h1></li>
          <li><a href="index.php?action=doLogout"><img src="https://image.flaticon.com/icons/png/512/19/19920.png" alt="6"></a><h1>Logout</h1></li>
            </ul>
        </div>
      </section>



  </body>
</html>
