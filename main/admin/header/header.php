
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $intro ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            overflow: none;
        }
        nav {
            background-color: #343a40;
            color: #fff;
            width: 150px;
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        nav .main-nav, nav .sub-nav {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }
        nav :where(.main-nav, nav .sub-nav) span{
        	margin: 5px 0;
        }
        nav span, nav a {
            color: #fff;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        nav a:hover {
            color: #ddd;
        }
        nav img {
            width: 100px;
            height: auto;
            margin-bottom: 30px;
        }
        .space {
            flex-grow: 1;
        }
        .wrapper {
            margin-left: 250px; /* Content shifted right to avoid overlap with sidebar */
            padding: 20px;
            width: calc(100% - 250px);

        }
        ul{
        	max-height: 70vh;
        	overflow-y: scroll;
        }
        li {
            padding: 30px;
            border-radius: 10px;
            margin: 10px 0;
            box-shadow: 1px 1px 12px rgba(0, 0, 0, 0.1);
        }
        li .detail .name {
            font-size: 1.5em;
            font-weight: 600;
        }
        .wrapper .main h1{
        	font-weight: 600;
        }
        .dialog-box {
        padding: 15px 20px;
        background-color: #f8f9fa; /* Light background */
        border: 1px solid #ccc; /* Light gray border */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Light shadow */
        font-size: 1.1em;
        color: #333;
        width: fit-content;
        margin-top: 20px;
        position: relative;
    }
    .dialog-box::before {
        content: "";
        position: absolute;
        top: -10px;
        left: 20px;
        border-width: 0 10px 10px 10px;
        border-style: solid;
        border-color: transparent transparent #ccc transparent;
    }

    .dialog-box::after {
        content: "";
        position: absolute;
        top: -8px;
        left: 21px;
        border-width: 0 9px 9px 9px;
        border-style: solid;
        border-color: transparent transparent #f8f9fa transparent;
    }

     
        @media (max-width: 768px) {
            nav {
                width: 70px;
                padding: 10px;
            }
            nav span .word {
                display: none; 
                }
            nav a {
                display: flex;
            }
            nav img {
                width: 50px;
            }
            .wrapper {
                margin-left: 70px; /* Adjust content margin for smaller screens */
                width: calc(100% - 70px);
            }
            .wrapper .all{
            	font-size: 0.5em;

            }
            .wrapper h1{
            	font-size: 0.6em;
            }
            .wrapper button{
            	font-size: 0.5em;
            }
            .wrapper .amount{
            	font-size: 0.3em;
            }
            .wrapper .date{
            	font-size: 0.3em;
            }
            .wrapper .main h1{
            	font-size: 1em;
            	font-weight: 600;
            }
        }


    </style>





