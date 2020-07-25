<html>
    <head>
        <style>
            body,html{
                margin:0px;
                padding:0px;
            }
            .msgContainer{
                width:100%;
                min-height: 95vh;
                height:100%;
                background:linear-gradient(#e4e4e4,#f1f1f1);
                position:relative;
            }
            .msgContainer img{
                margin: auto;
                display: block;
                position: absolute;
                left: 50%;
                top: 20%;
                transform: translate(-69%,25%);
            }
            .msgContainer p{
                position: absolute;
                left: 11%;
                color: transparent;
                background-color: #706e6e;
                font-size: 30px;
                font-family: arial;
                font-weight: bold;
                text-shadow: 2px 2px 3px rgb(194, 194, 194);
                -webkit-background-clip: text;
                -moz-background-clip: text;
                background-clip: text !important;
                top: 40%;
            }
            .loginAgain{
                font-size: 20px;
                padding: 10px 30px;
                text-align: center;
                color: #ffffff;
                outline: none;
                cursor: pointer;
                border: none;
                position: absolute;
                bottom: 40%;
                left: 45%;
                border: 1px solid #6e991d;
                border-radius: 38px;
                background-color: #8dbf2d;
            }
            .loginAgain:hover, 
            .loginAgain:focus {
              animation: pulse 1s;
              box-shadow: 0 0 0 2em rgba(#fff,0);
              background-color:#74a516;
              transition:0.5s;
            }
        </style>
    </head>
    <body>
        <div class="msgContainer">
            <!-- <img src="https://www.techprodevcenter.co.in/ulsa/assets/images/brand/logo.png"> -->
            <p>Your password has been successfully changed Now go to application and login again</p>
        </div>
    </body>
</html>