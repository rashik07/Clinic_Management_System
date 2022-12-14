<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>(HMS) Hospital Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/login.css">

</head>
<style>
    .proclinic-bg.fadeInDown.margin_auto {
        text-align: center;
    }

    .proclinic-bg.fadeInDown.margin_auto img {
        max-width: 150px;
    }

    div#formContent {
        display: block;
        margin: 0 auto;
    }
</style>

<body>

    <div class="proclinic-bg  margin_auto" style="height: 100%; 
    background: #67B26F;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

    ">
        <div style="text-align: center; padding-top: 5%;">
            <img src="../assets/images/logo-dark.png" id="icon" alt="User Icon" width="20%" />
            <h1 style="color: white; font-size: 40px;margin-top: 30px; margin-bottom: 30px; font-weight: 500;">WELCOME TO MOMTAJ TRAUMA CENTER</h1>
        </div>

        <div id="formContent">

            <form onsubmit="authenticate(); return false;" class="login-form">
                <input type="text" id="email" name="email" placeholder="Email">
                <input type="password" id="password" name="password" placeholder="Password">
                <input type="submit" value="Log In">
            </form>

        </div>
        <div style="color: white; text-align: center;margin-top: 30px;">
            <p>Developed by <a href="https://theicthub.com/" style="color: white;">THE ICT HUB </a></p>
        </div>
    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function authenticate() {

            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;

            //alert(email);
            // var email="abdullahalrifat95@gmail.com";
            // var password="accessdenied";
            var login = "authenticate";
            var token;
            var user_id;
            var user_Name;
            var user_type_Name;
            var user_type_access_level;
            var user_Status;
            var user_Full_Name;

            //alert("To");
            jQuery.ajax({
                type: 'POST',
                url: '../apis/token_based_user_authenticate.php',
                cache: false,
                //dataType: "json", // and this
                data: {
                    email: email,
                    password: password,
                    login: login
                },

                success: function(response) {
                    //alert(response);
                    //alert("response : "+JSON.stringify(response));
                    //document.forms["authentication"].submit();

                    var obj = JSON.parse(response);

                    token = obj.token;
                    //alert("token: "+token);
                    var datas = obj.user_authenticate;
                    for (var key in datas) {
                        if (datas.hasOwnProperty(key)) {
                            //alert(datas[key].user_id);
                            user_id = datas[key].user_id;
                            user_Full_Name = datas[key].user_Full_Name;
                            user_type_Name = datas[key].user_type_Name;
                            user_type_access_level = datas[key].user_type_access_level;
                            user_Status = datas[key].user_Status;
                            //alert(user_Status);
                            //alert(user_leave_count);
                            //alert(datas[key].user_Name);
                            //alert(datas[key].user_PhoneNo);
                            //alert(datas[key].user_Email);
                            //alert(datas[key].user_designation_Name);
                            //alert(datas[key].user_type_Name);
                            //alert(datas[key].user_type_access_level);

                        }
                    }

                    //window.open("dashboard.html","_self");
                    //alert(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(textStatus, errorThrown);
                    alert("alert : " + errorThrown);
                },
                complete: function(response) {
                    //alert(response);
                    jQuery.ajax({
                        type: 'POST',
                        url: '../scripts/define_session.php',
                        cache: false,
                        //dataType: "json", // and this
                        data: {
                            token: token,
                            user_id: user_id,
                            user_type_Name: user_type_Name,
                            user_type_access_level: user_type_access_level,
                            user_Status: user_Status,
                            user_Full_Name: user_Full_Name,
                        },

                        success: function(response) {
                            //alert(response);
                            //alert("response : "+JSON.stringify(response));
                            //document.forms["authentication"].submit();
                            var obj = JSON.parse(response);

                            user_authenticate = obj.user_authenticate;

                            if (user_authenticate === "True") {
                                //if(user_type_access_level > 1)
                                window.open("index.php", "_self");
                                //else
                                //   window.open("dashboard.php","_self");
                            } else {
                                alert("Authentication Error !!!");

                            }

                            //window.open("dashboard.html","_self");
                            //alert(response);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            //console.log(textStatus, errorThrown);
                            alert("alert : " + errorThrown);
                        }
                    });
                }
            });
        }
        // authenticate();
    </script>
</body>

</html>